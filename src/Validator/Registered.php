<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class Registered extends Constraint
{
    public string $message = 'This email is already registered. Try to login.';

    public function __construct(
        public string $mode = 'strict',
        ?array $groups = null,
        mixed $payload = null,
    ) {
        parent::__construct([], $groups, $payload);
    }
}
