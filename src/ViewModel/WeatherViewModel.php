<?php

namespace App\ViewModel;

use App\Dto\CurrentWeatherDto;
use App\Dto\CurrentWeatherUnitsDto;
use App\Dto\DailyForecastDto;
use App\Dto\DailyForecastUnitsDto;

class WeatherViewModel
{

    private ?CurrentWeatherDto $currentWeatherDto;
    private ?CurrentWeatherUnitsDto $currentWeatherUnitsDto;
    private ?GeoCodeViewModel $geoCodeViewModel;
    private ?DailyForecastDto $dailyForecastDto;
    private ?DailyForecastUnitsDto $dailyForecastUnitsDto;
    public function __construct(){}

    public function getCurrentWeatherDto(): ?CurrentWeatherDto
    {
        return $this->currentWeatherDto;
    }

    public function setCurrentWeatherDto(?CurrentWeatherDto $currentWeatherDto): self
    {
        $this->currentWeatherDto = $currentWeatherDto;
        return $this;
    }

    public function getCurrentWeatherUnitsDto(): ?CurrentWeatherUnitsDto
    {
        return $this->currentWeatherUnitsDto;
    }

    public function setCurrentWeatherUnitsDto(?CurrentWeatherUnitsDto $currentWeatherUnitsDto): self
    {
        $this->currentWeatherUnitsDto = $currentWeatherUnitsDto;
        return $this;
    }

    public function getGeoCodeViewModel(): ?GeoCodeViewModel
    {
        return $this->geoCodeViewModel;
    }

    public function setGeoCodeViewModel(?GeoCodeViewModel $geoCodeViewModel): self
    {
        $this->geoCodeViewModel = $geoCodeViewModel;
        return $this;
    }

    public function getDailyForecastDto(): ?DailyForecastDto
    {
        return $this->dailyForecastDto;
    }

    public function setDailyForecastDto(?DailyForecastDto $dailyForecastDto): self
    {
        $this->dailyForecastDto = $dailyForecastDto;
        return $this;
    }

    public function getDailyForecastUnitsDto(): ?DailyForecastUnitsDto
    {
        return $this->dailyForecastUnitsDto;
    }

    public function setDailyForecastUnitsDto(?DailyForecastUnitsDto $dailyForecastUnitsDto): self
    {
        $this->dailyForecastUnitsDto = $dailyForecastUnitsDto;
        return $this;
    }

}
