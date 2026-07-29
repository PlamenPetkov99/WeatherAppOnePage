<?php

namespace App\Dto\Security;

use Symfony\Component\Validator\Constraints as Assert;

class LoginUserDto
{
    #[Assert\NotBlank(message: 'Email is required')]
    #[Assert\Email(message: 'Email is invalid')]
    private string $email;

    #[Assert\NotBlank(message: 'Password is required')]
    #[Assert\Length(min: 6, minMessage: 'Password must be at least 6 characters')]
    private string $password;

    private ?string $rememberMe = null;

    private string $_token;

    public function getToken(): string
    {
        return $this->_token;
    }

    public function setToken(string $token): void
    {
        $this->_token = $token;
    }



    public function getRememberMe(): ?string
    {
        return $this->rememberMe;
    }

    public function setRememberMe(?string $rememberMe): void
    {
        $this->rememberMe = $rememberMe;
    }

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
