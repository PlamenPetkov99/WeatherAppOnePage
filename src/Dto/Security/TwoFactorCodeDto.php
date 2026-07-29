<?php

namespace App\Dto\Security;

use Scheb\TwoFactorBundle\Security\TwoFactor\Validator\Constraints\UserGoogleTotpCode;
use Symfony\Component\Validator\Constraints as Assert;

class TwoFactorCodeDto
{
    #[Assert\NotBlank(message: 'Code is required')]
    #[Assert\Length(exactly: 6, exactMessage: 'Code must be 6 characters long')]
    #[UserGoogleTotpCode(message: 'The authentication code is invalid')]
    private string $code;

    public function __construct()
    {
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }
}
