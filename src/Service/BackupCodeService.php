<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;
use Symfony\Component\Security\Core\User\UserInterface;

class BackupCodeService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    ) {
    }

    /**
     * @throws RandomException
     */
    public function generateBackupCodes(User|UserInterface $user): array
    {
        $plainCodes = [];
        for ($i = 0; $i < 10; ++$i) {
            $code = bin2hex(random_bytes(5));
            $plainCodes[] = $code;
            $user->addBackupCode(hash_hmac('sha256', $code, $_ENV['APP_SECRET'] ?? ''));
        }
        $this->em->persist($user);
        $this->em->flush();

        return $plainCodes;
    }

    // Verify codes
    public function verify(User|UserInterface $user, string $code): void
    {
    }

    // Consume
    public function consume(User|UserInterface $user, string $code): void
    {
    }

    // Regenerate codes
    public function regenerate(User|UserInterface $user): void
    {
    }

    // Hash codes
    public function hash(string $code): string
    {
    }
}
