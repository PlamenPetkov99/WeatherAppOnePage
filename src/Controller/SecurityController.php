<?php

namespace App\Controller;

use App\Dto\Security\ChangePasswordDto;
use App\Dto\Security\LoginUserDto;
use App\Dto\Security\RegisterUserDto;
use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\LoginType;
use App\Form\RegisterType;
use App\Form\TwoFactorType;
use App\Repository\UserRepository;
use App\Security\CustomLoginAuthenticator;
use App\Service\BackupCodeService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Endroid\QrCode\Builder\BuilderInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\Provider\Google\GoogleAuthenticatorInterface;
use Scheb\TwoFactorBundle\Security\TwoFactor\TwoFactorFirewallContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;

class SecurityController extends AbstractController
{
    /**
     * Bcrypt hash of an unused placeholder password, used to keep the login timing
     * constant when no user matches the submitted email (avoids user enumeration).
     */
    private const DUMMY_PASSWORD_HASH = '$2y$12$BoXF/T7GWsH6wxsW2FusYevo7NvtrrnWZGq1TtI5OPHxvNNwFpuJC';

    public function __construct(
        private readonly UserService $userService,
        private readonly BackupCodeService $backupCodeService,
    ) {
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $hasher,
        Security $security,
        #[Autowire(service: 'limiter.login')]
        RateLimiterFactory $loginLimiter,
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_index');
        }

        $loginDto = new LoginUserDto();
        $form = $this->createForm(LoginType::class, $loginDto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $limiter = $loginLimiter->create($request->getClientIp().'|'.$loginDto->getEmail());

            if (!$limiter->consume(1)->isAccepted()) {
                $form->get('password')->addError(new FormError('Too many login attempts. Please try again later.'));

                return $this->render('security/login.html.twig', [
                    'form' => $form,
                ]);
            }

            $user = $userRepository->findOneBy(['email' => $loginDto->getEmail()]);

            $badges = [];

            if ($loginDto->getRememberMe()) {
                $badges[] = new RememberMeBadge()->enable();
            }

            $dummyUser = (new User())->setPassword(self::DUMMY_PASSWORD_HASH);
            $passwordValid = $hasher->isPasswordValid($user ?? $dummyUser, $loginDto->getPassword());

            if ($user && $passwordValid) {
                $limiter->reset();

                return $security->login(
                    $user,
                    CustomLoginAuthenticator::class,
                    null,
                    $badges
                );
            }
            $form->get('password')->addError(new FormError('Invalid credentials'));
        }

        return $this->render('security/login.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/register', name: 'app_register')]
    public function register(Request $request)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_index');
        }

        $registerUserDto = new RegisterUserDto();
        $form = $this->createForm(RegisterType::class, $registerUserDto);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->registerUser($registerUserDto);
            $this->addFlash('success', 'Registration successful');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/authenticate/2fa/enable', name: 'app_2fa_enable')]
    public function enableTwoFactor(
        GoogleAuthenticatorInterface $googleAuthenticator,
        BuilderInterface $defaultBuilder,
        Request $request,
        #[CurrentUser] User $user,
    ): ?Response {
        $session = $request->getSession();
        $secret = $session->get('pending_2fa_secret');
        if (null === $secret) {
            $secret = $googleAuthenticator->generateSecret();
            $session->set('pending_2fa_secret', $secret);
        }

        $userCopy = clone $user;
        $userCopy->setGoogleAuthenticatorSecret($secret);

        $qrCodeContent = $googleAuthenticator->getQRContent($userCopy);
        $qrCode = $defaultBuilder->build(data: $qrCodeContent);

        return $this->render('security/2fa_enable.html.twig', [
            'qrCodeDataUri' => $qrCode->getDataUri(),
            'secret' => $secret,
        ]);
    }

    #[Route(path: '/authenticate/2fa/enable/confirm', name: 'app_2fa_enable_confirm')]
    public function confirmEnableTwoFactor(
        Request $request,
        GoogleAuthenticatorInterface $googleAuthenticator,
        EntityManagerInterface $entityManager,
        #[CurrentUser] User $user,
    ) {
        $form = $this->createForm(TwoFactorType::class);
        $form->handleRequest($request);

        $session = $request->getSession();
        $secret = $session->get('pending_2fa_secret');

        if (null === $secret) {
            $this->addFlash('error', 'Setup expired — scan the QR code again.');

            return $this->redirectToRoute('app_2fa_enable');
        }

        $userCopy = clone $user;
        $userCopy->setGoogleAuthenticatorSecret($secret);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$googleAuthenticator->checkCode($userCopy, (string) $form->get('code')->getData())) {
                $this->addFlash('error', "That code didn't match.");

                return $this->redirectToRoute('app_2fa_enable_confirm');
            }

            $user->setGoogleAuthenticatorSecret($secret);

            $backUpCodes = $this->backupCodeService->generateBackupCodes($user);
            $session->remove('pending_2fa_secret');
            $session->set('new_backup_codes', $backUpCodes);

            $entityManager->flush();

            $this->addFlash('success', 'Two-factor authentication enabled.');

            return $this->redirectToRoute('app_2fa_backup_codes');
        }

        return $this->render('security/2fa_verify.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/authenticate/2fa/disable', name: 'app_2fa_disable')]
    public function disableTwoFactor(
        Request $request,
        #[CurrentUser] User $user,
        EntityManagerInterface $entityManager,
    ) {
        $user->setGoogleAuthenticatorSecret(null);
        $entityManager->flush();

        $this->addFlash('success', 'Two-factor authentication disabled.');

        return $this->redirectToRoute('app_profile');
    }

    #[Route(path: '/authenticate/change_password', name: 'app_change_password')]
    public function changePassword(
        Request $request,
        #[CurrentUser] User $user,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
    ) {
        $changePasswordDto = new ChangePasswordDto();
        $form = $this->createForm(ChangePasswordType::class, $changePasswordDto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$userPasswordHasher->isPasswordValid($user, $changePasswordDto->getCurrentPassword())) {
                $form->get('currentPassword')->addError(new FormError('Current password is wrong'));
            } elseif ($userPasswordHasher->isPasswordValid($user, $changePasswordDto->getNewPassword())) {
                $form->addError(new FormError('New password cant be same as old one.'));
            } else {
                $user->setPassword($userPasswordHasher->hashPassword($user, $changePasswordDto->getNewPassword()));
                $entityManager->flush();

                $this->addFlash('success', 'Password changed.');

                return $this->redirectToRoute('app_profile');
            }
        }

        return $this->render('security/change_password.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/authenticate/2fa_backup', name: 'app_2fa_backup_form', methods: ['GET'])]
    public function backupTwoFactorForm(TwoFactorFirewallContext $twoFactorFirewallContext): Response
    {
        $config = $twoFactorFirewallContext->getFirewallConfig('main');

        return $this->render('security/backup_template.html.twig', [
            'isCsrfProtectionEnabled' => $config->isCsrfProtectionEnabled(),
            'csrfParameterName' => $config->getCsrfParameterName(),
            'csrfTokenId' => $config->getCsrfTokenId(),
        ]);
    }

    #[Route(path: '/authenticate/backup_codes', name: 'app_2fa_backup_codes')]
    public function backupCodes(
        Request $request,
    ): Response {
        $codes = $request->getSession()->get('new_backup_codes');

        return $this->render('security/backup_codes.html.twig', [
            'backupCodes' => $codes,
        ]);
    }


    #[Route('/authenticate/backup_codes/finish', name: 'app_2fa_backup_codes_finish')]
    public function finishBackupCodes(
        Request $request,
    ) {
        $request->getSession()->remove('new_backup_codes');

        return $this->redirectToRoute('app_profile');
    }
}
