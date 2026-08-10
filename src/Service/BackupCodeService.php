<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;
use Scheb\TwoFactorBundle\Security\TwoFactor\Backup\BackupCodeManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class BackupCodeService implements BackupCodeManagerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        #[Autowire(env: 'APP_SECRET')]
        private readonly string $secret,
    ) {
    }

    public function generateBackupCodes(User $user): array
    {
        $plainCodes = [];
        $hashedCodes = [];
        for ($i = 0; $i < 10; ++$i) {
            $code = bin2hex(random_bytes(5));
            $plainCodes[] = $code;
            $hashedCodes[] = $this->hash($code);
        }

        $user->setBackupCodes($hashedCodes);

        $this->em->persist($user);
        $this->em->flush();

        return $plainCodes;
    }

    public function isBackupCode(object $user, string $code): bool
    {
        if (!$user instanceof User) {
            return false;
        }

        return null !== $this->findMatchingHash($user, $code);
    }

    public function invalidateBackupCode(object $user, string $code): void
    {
        if (!$user instanceof User) {
            return;
        }

        $matchingHash = $this->findMatchingHash($user, $code);
        if (null === $matchingHash) {
            return;
        }

        $remainingCodes = array_values(array_filter(
            $user->getBackupCodes() ?? [],
            static fn (string $storedHash): bool => !hash_equals($storedHash, $matchingHash)
        ));

        $user->setBackupCodes($remainingCodes);
        $this->em->flush();
    }

    private function findMatchingHash(User $user, string $code): ?string
    {
        $candidateHash = $this->hash($code);
        foreach ($user->getBackupCodes() ?? [] as $storedHash) {
            if (hash_equals($storedHash, $candidateHash)) {
                return $storedHash;
            }
        }

        return null;
    }

    private function hash(string $code): string
    {
        return hash_hmac('sha256', $code, $this->secret);
    }
}
