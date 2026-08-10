<?php

namespace App\Dto\Security;

use App\Validator\Registered;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterUserDto
{
    #[Assert\NotBlank(message: 'Email is required')]
    #[Assert\Email(message: 'Email is invalid')]
    #[Registered]
    private string $email;

    #[Assert\NotBlank(message: 'Password is required')]
    #[Assert\Length(min: 6, minMessage: 'Password must be at least 6 characters')]
    private string $password;
    public function __construct()
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

}
