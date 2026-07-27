<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProfileController extends AbstractController
{
    #[Route(
        path: '/profile',
        name: 'app_profile'
    )]
    public function profile(
        SessionInterface $session,
    ): Response {
        return $this->render('dashboard/profile.html.twig', [
        ]);
    }
}
