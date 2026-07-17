<?php

namespace App\Dto;

class DailyForecastDto
{
    private ?array $time;
    private ?array $weatherCodes;
    private ?array $maxTemperature;
    private ?array $minTemperature;
    private ?array $precipitationProbabilityMax;
    private ?array $windSpeed;
    public function __construct(){}

    public function getTime(): ?array
    {
        return $this->time;
    }

    public function setTime(?array $time): self
    {
        $dates = [];
        foreach($time as $date)
        {
            $dates[] = new \DateTimeImmutable($date);
        }
        $this->time = $dates;
        return $this;
    }

    public function getWeatherCodes(): ?array
    {
        return $this->weatherCodes;
    }

    public function setWeatherCodes(?array $weatherCodes): self
    {
        $this->weatherCodes = $weatherCodes;
        return $this;
    }

    public function getMaxTemperature(): ?array
    {
        return $this->maxTemperature;
    }

    public function setMaxTemperature(?array $maxTemperature): self
    {
        $this->maxTemperature = $maxTemperature;
        return $this;
    }

    public function getMinTemperature(): ?array
    {
        return $this->minTemperature;
    }

    public function setMinTemperature(?array $minTemperature): self
    {
        $this->minTemperature = $minTemperature;
        return $this;
    }

    public function getPrecipitationProbabilityMax(): ?array
    {
        return $this->precipitationProbabilityMax;
    }

    public function setPrecipitationProbabilityMax(?array $precipitationProbabilityMax): self
    {
        $this->precipitationProbabilityMax = $precipitationProbabilityMax;
        return $this;
    }

    public function getWindSpeed(): ?array
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(?array $windSpeed): self
    {
        $this->windSpeed = $windSpeed;
        return $this;
    }

    public function getDescription(int $weatherCode): string
    {
        return WeatherCode::getDescription($weatherCode);
    }

    public function getIcon(int $weatherCode): string
    {
        return WeatherCode::getIconName($weatherCode);
    }

}
