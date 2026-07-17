<?php

namespace App\Builder;

use App\Dto\CurrentWeatherDto;
use App\Dto\WeatherDto;

class CurrentWeatherBuilder
{
    public static function build(WeatherDto $weatherDto): ?CurrentWeatherDto
    {
        $currentWeather = $weatherDto->getCurrent();
        if(!$currentWeather)
        {
            return null;
        }
        return new CurrentWeatherDto()
            ->setApparentTemperature($currentWeather['apparent_temperature'])
            ->setInterval($currentWeather['interval'])
            ->setIsDay($currentWeather['is_day'])
            ->setRelativeHumidity($currentWeather['relative_humidity_2m'])
            ->setSurfacePressure($currentWeather['surface_pressure'])
            ->setTemperature($currentWeather['temperature_2m'])
            ->setTime(new \DateTimeImmutable($currentWeather['time']))
            ->setWeatherCode($currentWeather['weather_code'])
            ->setWindSpeed($currentWeather['wind_speed_10m']);
    }
}
