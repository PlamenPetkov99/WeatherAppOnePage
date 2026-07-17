<?php

namespace App\Exception;

final class CityNotFoundException extends \RuntimeException
{
    public function __construct(
        string $message = 'City not found.',
        int $code = 0,
        ?\Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
