<?php

namespace App\ViewModel;

class GeoCodeViewModel
{
    private ?string $name = 'default';
    private ?float $latitude = 0.0;
    private ?float $longitude = 0.0;
    private ?float $elevation = 0.0;
    private ?string $feature_code = 'default';
    private ?string $country_code = 'default';
    private ?string $timezone = 'default';
    private ?int $population = 0;
    private ?array $postcodes = [];
    private ?string $country = 'default';

    public function __construct(){}



    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getElevation(): float
    {
        return $this->elevation;
    }

    public function setElevation(float $elevation): self
    {
        $this->elevation = $elevation;
        return $this;
    }

    public function getFeatureCode(): string
    {
        return $this->feature_code;
    }

    public function setFeatureCode(string $feature_code): self
    {
        $this->feature_code = $feature_code;
        return $this;
    }

    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    public function setCountryCode(string $country_code): self
    {
        $this->country_code = $country_code;
        return $this;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): self
    {
        $this->timezone = $timezone;
        return $this;
    }

    public function getPopulation(): int
    {
        return $this->population;
    }

    public function setPopulation(int $population): self
    {
        $this->population = $population;
        return $this;
    }

    public function getPostcodes(): array
    {
        return $this->postcodes;
    }

    public function setPostcodes(array $postcodes): self
    {
        $this->postcodes = $postcodes;
        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }
}
