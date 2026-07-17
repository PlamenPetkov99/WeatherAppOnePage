<?php

namespace App\Dto;

class CurrentWeatherUnitsDto
{
    private ?string $time;
    private ?string $interval;
    private ?string $temperatureUnit;
    private ?string $relativeHumidityUnit;
    private ?string $apparentTemperatureUnit;
    private ?string $weatherCode;
    private ?string $windSpeedUnit;
    private ?string $surfacePressureUnit;
    private ?string $isDayUnit = '';
    public function __construct(){}

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(?string $time): self
    {
        $this->time = $time;
        return $this;
    }

    public function getInterval(): ?string
    {
        return $this->interval;
    }

    public function setInterval(?string $interval): self
    {
        $this->interval = $interval;
        return $this;
    }

    public function getTemperatureUnit(): ?string
    {
        return $this->temperatureUnit;
    }

    public function setTemperatureUnit(?string $temperatureUnit): self
    {
        $this->temperatureUnit = $temperatureUnit;
        return $this;
    }

    public function getRelativeHumidityUnit(): ?string
    {
        return $this->relativeHumidityUnit;
    }

    public function setRelativeHumidityUnit(?string $relativeHumidityUnit): self
    {
        $this->relativeHumidityUnit = $relativeHumidityUnit;
        return $this;
    }

    public function getApparentTemperatureUnit(): ?string
    {
        return $this->apparentTemperatureUnit;
    }

    public function setApparentTemperatureUnit(?string $apparentTemperatureUnit): self
    {
        $this->apparentTemperatureUnit = $apparentTemperatureUnit;
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

    public function getWindSpeedUnit(): ?string
    {
        return $this->windSpeedUnit;
    }

    public function setWindSpeedUnit(?string $windSpeedUnit): self
    {
        $this->windSpeedUnit = $windSpeedUnit;
        return $this;
    }

    public function getSurfacePressureUnit(): ?string
    {
        return $this->surfacePressureUnit;
    }

    public function setSurfacePressureUnit(?string $surfacePressureUnit): self
    {
        $this->surfacePressureUnit = $surfacePressureUnit;
        return $this;
    }

}
