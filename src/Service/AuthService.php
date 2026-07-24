<?php

namespace App\Service;

use App\Manager\AuthRequestManager;

class AuthService
{
    public function __construct(
        private readonly AuthRequestManager $authRequestManager,
    ) {
    }

    public function registerUser(mixed $userToRegister)
    {
    }

    public function loginUser(mixed $cridentials)
    {
    }
}
