<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class GeoResponseDto
{
    #[Assert\NotBlank(message: 'Error finding the city')]
    private array $results;
    private float $generationTimeMs;

    public function __construct(){}

    public function getResults(): array
    {
        return $this->results[0];
    }

    public function setResults(array $results): void
    {
        $this->results = $results;
    }

    public function getGenerationTimeMs(): float
    {
        return $this->generationTimeMs;
    }

    public function setGenerationTimeMs(float $generationTimeMs): void
    {
        $this->generationTimeMs = $generationTimeMs;
    }

}
