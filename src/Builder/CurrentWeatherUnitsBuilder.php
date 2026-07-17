<?php

namespace App\Builder;

use App\Dto\CurrentWeatherUnitsDto;
use App\Dto\WeatherDto;

class CurrentWeatherUnitsBuilder
{
    public static function build(WeatherDto $weatherDto): CurrentWeatherUnitsDto
    {
        $currentUnits = $weatherDto->getCurrentUnits();
        return new CurrentWeatherUnitsDto()
            ->setApparentTemperatureUnit($currentUnits['apparent_temperature'])
            ->setInterval($currentUnits['interval'])
            ->setRelativeHumidityUnit($currentUnits['relative_humidity_2m'])
            ->setSurfacePressureUnit($currentUnits['surface_pressure'])
            ->setTemperatureUnit($currentUnits['temperature_2m'])
            ->setTime($currentUnits['time'])
            ->setWeatherCode($currentUnits['weather_code'])
            ->setWindSpeedUnit($currentUnits['wind_speed_10m']);
    }
}
