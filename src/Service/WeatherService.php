<?php

namespace App\Service;

use App\Builder\RequestInputDataDtoBuilder;
use App\Dto\CityDto;
use App\Dto\WeatherDto;
use App\Factory\WeatherViewModelFactory;
use App\Manager\WeatherRequestManager;
use App\ViewModel\GeoCodeViewModel;
use App\ViewModel\WeatherViewModel;
use Symfony\Contracts\HttpClient\ResponseInterface;

class WeatherService
{
    public function __construct(
        private readonly GeoService $geoService,
        private readonly WeatherRequestManager $weatherRequestManager,
        private readonly ParseService $parser,
        private readonly RequestInputDataDtoBuilder $requestInputDataDtoBuilder,
        private readonly WeatherViewModelFactory $weatherFactory,
    ){}

    public function getWeather(GeoCodeViewModel $geoCodeView): WeatherViewModel
    {
        $weatherResponse = $this->fetchWeather($geoCodeView);

        $weatherDto = $this->parser->parseFromArray($weatherResponse->toArray(), WeatherDto::class);

        return $this->weatherFactory->buildWeather(
            $geoCodeView,
            $weatherDto
        );
    }

    private function fetchWeather(GeoCodeViewModel $geoCodeViewModel): ResponseInterface
    {
        return $this->weatherRequestManager->get(
            $this->requestInputDataDtoBuilder
                ->withLatitude($geoCodeViewModel->getLatitude())
                ->withLongtitude($geoCodeViewModel->getLongitude())
                ->build()
        );
    }

}
