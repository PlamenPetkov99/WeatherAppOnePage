<?php

namespace App\Controller;

use App\Service\AuthService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    #[Route(
        path: '/login',
        name: 'app_login',
    )]
    public function login(): Response
    {
        return new Response('login page');
    }

    #[Route(
        path: '/register',
        name: 'app_register',
    )]
    public function register(): Response
    {
        return new Response('register page');
    }

    #[Route(
        path: '/logout',
        name: 'app_logout',
    )]
    public function logout(): Response
    {
        return new Response('logout page');
    }
}
