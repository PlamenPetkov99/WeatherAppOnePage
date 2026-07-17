<?php

namespace App\Factory;

use App\Builder\CurrentWeatherBuilder;
use App\Builder\CurrentWeatherUnitsBuilder;
use App\Builder\DailyForecastBuilder;
use App\Builder\DailyForecastUnitBuilder;
use App\Dto\WeatherDto;
use App\ViewModel\GeoCodeViewModel;
use App\ViewModel\WeatherViewModel;

class WeatherViewModelFactory
{
    public function __construct(){}
    public function buildWeather(
        GeoCodeViewModel $geoCodeViewModel,
        WeatherDto $weatherDto
    ): WeatherViewModel
    {
        return new WeatherViewModel()
            ->setGeoCodeViewModel($geoCodeViewModel)
            ->setDailyForecastUnitsDto(DailyForecastUnitBuilder::build($weatherDto))
            ->setDailyForecastDto(DailyForecastBuilder::build($weatherDto))
            ->setCurrentWeatherUnitsDto(CurrentWeatherUnitsBuilder::build($weatherDto))
            ->setCurrentWeatherDto(CurrentWeatherBuilder::build($weatherDto));
    }
}
