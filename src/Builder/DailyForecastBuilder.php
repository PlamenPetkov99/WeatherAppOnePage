<?php

namespace App\Builder;

use App\Dto\DailyForecastDto;
use App\Dto\WeatherDto;

class DailyForecastBuilder
{
    public static function build(WeatherDto $weatherDto): DailyForecastDto
    {
        $dailyArrays = $weatherDto->getDaily();
        return new DailyForecastDto()
            ->setWindSpeed($dailyArrays['wind_speed_10m_max'])
            ->setWeatherCodes($dailyArrays['weather_code'])
            ->setTime($dailyArrays['time'])
            ->setPrecipitationProbabilityMax($dailyArrays['precipitation_probability_max'])
            ->setMinTemperature($dailyArrays['temperature_2m_min'])
            ->setMaxTemperature($dailyArrays['temperature_2m_max']);
    }
}
