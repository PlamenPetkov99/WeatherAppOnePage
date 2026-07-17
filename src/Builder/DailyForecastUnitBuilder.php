<?php

namespace App\Builder;

use App\Dto\DailyForecastUnitsDto;
use App\Dto\WeatherDto;

class DailyForecastUnitBuilder
{
    public static function build(WeatherDto $weatherDto): DailyForecastUnitsDto
    {
        $dailyUnitArray = $weatherDto->getDailyUnits();
        return new DailyForecastUnitsDto()
            ->setWindSpeedUnit($dailyUnitArray['wind_speed_10m_max'])
            ->setWeatherCode($dailyUnitArray['weather_code'])
            ->setTimeUnit($dailyUnitArray['time'])
            ->setTemperatureMinUnit($dailyUnitArray['temperature_2m_min'])
            ->setTemperatureMaxUnit($dailyUnitArray['temperature_2m_max'])
            ->setPrecipitationProbabilityMaxUnit($dailyUnitArray['precipitation_probability_max']);
    }
}
