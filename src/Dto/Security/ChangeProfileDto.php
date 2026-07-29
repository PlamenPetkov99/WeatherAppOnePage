<?php

namespace App\Dto\Security;

use Symfony\Component\Validator\Constraints as Assert;

class ChangeProfileDto
{
    #[Assert\NotBlank(message: 'First name is required')]
    private string $firstName;
    #[Assert\NotBlank(message: 'Last name is required')]
    private string $lastName;

    public function __construct()
    {
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function normalize(): void
    {
        $this->firstName = ucfirst(strtolower($this->firstName));
        $this->lastName = ucfirst(strtolower($this->lastName));
    }

}
