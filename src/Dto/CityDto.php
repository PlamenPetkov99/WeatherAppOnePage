<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CityDto
{
    #[Assert\NotBlank(message: 'City name is required')]
    private ?string $name = null;

    private ?float $latitude = null;

    private ?float $longitude = null;

    private ?string $timezone = null;

    private ?int $population = null;

    private array $postcodes = [];

    private ?string $country = null;

    public function __construct(){}

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(?string $timezone): void
    {
        $this->timezone = $timezone;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(?int $population): void
    {
        $this->population = $population;
    }

    public function getPostcodes(): array
    {
        return $this->postcodes;
    }

    public function setPostcodes(array $postcodes): void
    {
        $this->postcodes = $postcodes;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

}
