<?php

namespace App\Manager;

use App\Dto\RequestInputDataDto;
use App\Interface\BaseHttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

readonly class WeatherRequestManager implements BaseHttpClientInterface
{
    public function __construct(
        #[Target('weather.client')]
        private HttpClientInterface $weatherClient
    ){}


    public function get(RequestInputDataDto $data): ResponseInterface
    {
        return $this->weatherClient->request(
            Request::METHOD_GET,
            '/v1/forecast',
            [
                'query' => [
                    'latitude' => $data->getLatitude(),
                    'longitude' => $data->getLongtitude(),
                    'current' => implode(',', [
                        'temperature_2m',
                        'relative_humidity_2m',
                        'apparent_temperature',
                        'weather_code',
                        'wind_speed_10m',
                        'wind_direction_10m',
                        'surface_pressure',
                        'is_day',
                    ]),
                    'daily' => implode(',', [
                        'weather_code',
                        'temperature_2m_max',
                        'temperature_2m_min',
                        'precipitation_probability_max',
                        'wind_speed_10m_max',
                    ]),
                    'forecast_days' => 5,
                    'timezone' => 'auto',
                    'models' => 'best_match'
                ]
            ]
        );
    }
}
