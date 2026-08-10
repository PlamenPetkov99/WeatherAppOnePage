<?php

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class RegisteredValidator extends ConstraintValidator
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var Registered $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        if (!$constraint instanceof Registered) {
            return;
        }

        $user = $this->userRepository->findOneBy(['email' => $value]);
        if (null === $user) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation()
        ;
    }
}
