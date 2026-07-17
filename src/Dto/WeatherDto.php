<?php

namespace App\Dto;

class WeatherDto
{
    private ?float $latitude;
    private ?float $longitude;
    private ?float $generationtimeMs;
    private ?int $utcOffsetSeconds;
    private ?string $timezone;
    private ?string $timezoneAbbreviation;
    private ?float $elevation;
    private ?array $currentUnits;
    private ?array $current;
    private ?array $daily;
    private ?array $dailyUnits;

    public function __construct(){}

    public function getDaily(): array
    {
        return $this->daily;
    }

    public function setDaily(array $daily): void
    {
        $this->daily = $daily;
    }

    public function getDailyUnits(): array
    {
        return $this->dailyUnits;
    }

    public function setDailyUnits(array $dailyUnits): void
    {
        $this->dailyUnits = $dailyUnits;
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

    public function getGenerationtimeMs(): float
    {
        return $this->generationtimeMs;
    }

    public function setGenerationtimeMs(float $generationtimeMs): void
    {
        $this->generationtimeMs = $generationtimeMs;
    }

    public function getUtcOffsetSeconds(): int
    {
        return $this->utcOffsetSeconds;
    }

    public function setUtcOffsetSeconds(int $utcOffsetSeconds): void
    {
        $this->utcOffsetSeconds = $utcOffsetSeconds;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): void
    {
        $this->timezone = $timezone;
    }

    public function getTimezoneAbbreviation(): string
    {
        return $this->timezoneAbbreviation;
    }

    public function setTimezoneAbbreviation(string $timezoneAbbreviation): void
    {
        $this->timezoneAbbreviation = $timezoneAbbreviation;
    }

    public function getElevation(): float
    {
        return $this->elevation;
    }

    public function setElevation(float $elevation): void
    {
        $this->elevation = $elevation;
    }

    public function getCurrentUnits(): array
    {
        return $this->currentUnits;
    }

    public function setCurrentUnits(array $currentUnits): void
    {
        $this->currentUnits = $currentUnits;
    }

    public function getCurrent(): array
    {
        return $this->current;
    }

    public function setCurrent(array $current): void
    {
        $this->current = $current;
    }
}
