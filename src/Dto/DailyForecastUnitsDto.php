<?php

namespace App\Dto;

class DailyForecastUnitsDto
{
    private ?string $timeUnit;
    private ?string $weatherCode;
    private ?string $temperatureMaxUnit;
    private ?string $temperatureMinUnit;
    private ?string $precipitationProbabilityMaxUnit;
    private ?string $windSpeedUnit;

    public function __construct(){}

    public function getTimeUnit(): ?string
    {
        return $this->timeUnit;
    }

    public function setTimeUnit(?string $timeUnit): self
    {
        $this->timeUnit = $timeUnit;
        return $this;
    }

    public function getWeatherCode(): ?string
    {
        return $this->weatherCode;
    }

    public function setWeatherCode(?string $weatherCode): self
    {
        $this->weatherCode = $weatherCode;
        return $this;
    }

    public function getTemperatureMaxUnit(): ?string
    {
        return $this->temperatureMaxUnit;
    }

    public function setTemperatureMaxUnit(?string $temperatureMaxUnit): self
    {
        $this->temperatureMaxUnit = $temperatureMaxUnit;
        return $this;
    }

    public function getTemperatureMinUnit(): ?string
    {
        return $this->temperatureMinUnit;
    }

    public function setTemperatureMinUnit(?string $temperatureMinUnit): self
    {
        $this->temperatureMinUnit = $temperatureMinUnit;
        return $this;
    }

    public function getPrecipitationProbabilityMaxUnit(): ?string
    {
        return $this->precipitationProbabilityMaxUnit;
    }

    public function setPrecipitationProbabilityMaxUnit(?string $precipitationProbabilityMaxUnit): self
    {
        $this->precipitationProbabilityMaxUnit = $precipitationProbabilityMaxUnit;
        return $this;
    }

    public function getWindSpeedUnit(): ?string
    {
        return $this->windSpeedUnit;
    }

    public function setWindSpeedUnit(?string $windSpeedUnit): self
    {
        $this->windSpeedUnit = $windSpeedUnit;
        return $this;
    }



}
