<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class SaveCityDto
{
    #[Assert\Length(max: 255)]
    #[Assert\NotBlank(message: 'City name is required')]
    private string $cityName;
    #[Assert\NotBlank(message: 'Country name is required')]
    #[Assert\Length(max: 255)]
    private string $countryName;
    #[Assert\NotBlank(message: 'Latitude is required')]
    #[Assert\Range(min: -90, max: 90)]
    private float $latitude;
    #[Assert\NotBlank(message: 'Longitude is required')]
    #[Assert\Range(min: -180, max: 180)]
    private float $longitude;

    public function __construct()
    {
    }

    public function getCityName(): string
    {
        return $this->cityName;
    }

    public function setCityName(string $cityName): void
    {
        $this->cityName = $cityName;
    }

    public function getCountryName(): string
    {
        return $this->countryName;
    }

    public function setCountryName(string $countryName): void
    {
        $this->countryName = $countryName;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

}
