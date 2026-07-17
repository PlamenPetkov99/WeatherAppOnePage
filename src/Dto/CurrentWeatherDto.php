<?php

namespace App\Dto;

class CurrentWeatherDto
{

    private ?\DateTimeImmutable $time;
    private ?int $interval;
    private ?float $temperature;
    private ?float $relativeHumidity;
    private ?float $apparentTemperature;
    private ?int $weatherCode;
    private ?float $windSpeed;
    private ?float $surfacePressure;
    private ?bool $isDay;
    public function __construct(){}

    public function getTime(): ?\DateTimeImmutable
    {
        return $this->time;
    }

    public function setTime(?\DateTimeImmutable $time): self
    {
        $this->time = $time;
        return $this;
    }

    public function getInterval(): ?int
    {
        return $this->interval;
    }

    public function setInterval(?int $interval): self
    {
        $this->interval = $interval;
        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(?float $temperature): self
    {
        $this->temperature = $temperature;
        return $this;
    }

    public function getRelativeHumidity(): ?float
    {
        return $this->relativeHumidity;
    }

    public function setRelativeHumidity(?float $relativeHumidity): self
    {
        $this->relativeHumidity = $relativeHumidity;
        return $this;
    }

    public function getApparentTemperature(): ?float
    {
        return $this->apparentTemperature;
    }

    public function setApparentTemperature(?float $apparentTemperature): self
    {
        $this->apparentTemperature = $apparentTemperature;
        return $this;
    }

    public function getWeatherCode(): ?int
    {
        return $this->weatherCode;
    }

    public function setWeatherCode(?int $weatherCode): self
    {
        $this->weatherCode = $weatherCode;
        return $this;
    }

    public function getWindSpeed(): ?float
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(?float $windSpeed): self
    {
        $this->windSpeed = $windSpeed;
        return $this;
    }

    public function getSurfacePressure(): ?float
    {
        return $this->surfacePressure;
    }

    public function setSurfacePressure(?float $surfacePressure): self
    {
        $this->surfacePressure = $surfacePressure;
        return $this;
    }

    public function getIsDay(): ?bool
    {
        return $this->isDay;
    }

    public function setIsDay(?bool $isDay): self
    {
        $this->isDay = $isDay;
        return $this;
    }

    public function getDescription(): string
    {
        return WeatherCode::getDescription($this->weatherCode);
    }

    public function getIcon(): string
    {
        return WeatherCode::getIconName($this->weatherCode);
    }



}
