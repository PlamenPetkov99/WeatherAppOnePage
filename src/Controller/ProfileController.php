<?php

namespace App\Controller;

use App\Dto\Security\ChangeProfileDto;
use App\Entity\User;
use App\Form\ChangeProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ProfileController extends AbstractController
{
    #[Route(
        path: '/profile',
        name: 'app_profile',
    )]
    public function profile(
        SessionInterface $session,
    ): Response {
        return $this->render('dashboard/profile.html.twig', [
        ]);
    }

    #[Route(path: '/profile/edit', name: 'app_edit_profile')]
    public function editProfile(
        Request $request,
        #[CurrentUser] User $user,
        EntityManagerInterface $entityManager,
    ) {
        $changeProfileDto = new ChangeProfileDto();
        $form = $this->createForm(ChangeProfileType::class, $changeProfileDto);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $changeProfileDto->normalize();
            $user->setFirstName($changeProfileDto->getFirstName());
            $user->setLastName($changeProfileDto->getLastName());
            $entityManager->flush();

            $this->addFlash('success', 'Profile updated.');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('dashboard/edit_profile.html.twig', [
            'form' => $form,
        ]);
    }
}
