<?php

namespace App\EventListener;

use App\Entity\User;
use Scheb\TwoFactorBundle\Security\TwoFactor\Event\TwoFactorAuthenticationEvent;
use Scheb\TwoFactorBundle\Security\TwoFactor\Event\TwoFactorAuthenticationEvents;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class SecurityFlashListener
{
    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
    }

    #[AsEventListener(event: LoginSuccessEvent::class)]
    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        $user = $event->getUser();

        if ($user instanceof User && $user->isGoogleAuthenticatorEnabled()) {
            return;
        }

        $this->requestStack->getSession()->getFlashBag()->add('success', 'You have been logged in!');
    }

    #[AsEventListener(event: TwoFactorAuthenticationEvents::COMPLETE)]
    public function onTwoFactorComplete(TwoFactorAuthenticationEvent $event): void
    {
        $this->requestStack->getSession()->getFlashBag()->add('success', 'You have been logged in!');
    }

    /**
     * Symfony's SessionLogoutListener invalidates the session (wiping the flash bag) on
     * LogoutEvent at the default priority, so this must run afterwards to survive into
     * the post-logout redirect.
     */
    #[AsEventListener(event: LogoutEvent::class, priority: -10)]
    public function onLogout(): void
    {
        $this->requestStack->getSession()->getFlashBag()->add('success', 'You have been logged out.');
    }
}
