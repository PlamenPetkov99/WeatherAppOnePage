<?php

namespace App\Manager;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class AuthRequestManager
{
    public function __construct(
        #[Target('auth.client')] private readonly HttpClientInterface $authClient,
    ) {
    }

    public function register()
    {
    }

    public function login()
    {
    }
}
