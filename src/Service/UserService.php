<?php

namespace App\Service;

use App\Dto\Security\LoginUserDto;
use App\Dto\Security\RegisterUserDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ObjectMapperInterface $objectMapper,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function registerUser(RegisterUserDto $registerUserDto)
    {
        $userToRegister = $this->objectMapper->map($registerUserDto, User::class);
        $userToRegister->setPassword($this->passwordHasher->hashPassword($userToRegister, $registerUserDto->getPassword()));
        $this->entityManager->persist($userToRegister);
        $this->entityManager->flush();
    }

    public function login(LoginUserDto $loginUserDto): ?User
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $loginUserDto->getEmail()]);

        if (!$user) {
            return null;
        }

        if (!$this->passwordHasher->isPasswordValid($user, $loginUserDto->getPassword())) {
            return null;
        }

        return $user;
    }
}
