<?php

namespace App\Service;

use App\Builder\RequestInputDataDtoBuilder;
use App\Dto\CityDto;
use App\Dto\WeatherDto;
use App\Factory\WeatherViewModelFactory;
use App\Manager\WeatherRequestManager;
use App\ViewModel\GeoCodeViewModel;
use App\ViewModel\WeatherViewModel;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class WeatherService
{
    public function __construct(
        private readonly WeatherRequestManager      $weatherRequestManager,
        private readonly ParseService               $parser,
        private readonly RequestInputDataDtoBuilder $requestInputDataDtoBuilder,
        private readonly WeatherViewModelFactory    $weatherFactory,
        private readonly CacheKeyFactory            $cacheKeyFactory,
        private readonly CacheInterface             $cache,
    ){}

    public function getWeather(
        GeoCodeViewModel $geoCodeView,
    ): WeatherViewModel
    {

        return $this->cache->get(
            $this->cacheKeyFactory->generateKeyForWeatherService($geoCodeView),
            function (ItemInterface $item) use ($geoCodeView)
            {
                $item->expiresAfter(300);

                $response = $this->fetchWeather($geoCodeView);

                $weatherDto = $this->parser->parseFromArray(
                    $response->toArray(),
                    WeatherDto::class
                );

                dump('im in the callback');

                return $this->weatherFactory->buildWeather(
                    $geoCodeView,
                    $weatherDto
                );
            }
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
