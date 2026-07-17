<?php

namespace App\Dto;

class RequestInputDataDto
{
    public function __construct(
        private ?float $latitude,
        private ?float $longtitude,
        private ?string $city,
    ){}

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLongtitude(): ?float
    {
        return $this->longtitude;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }


}
