<?php

namespace App\Service;

use App\Dto\CityDto;
use App\ViewModel\GeoCodeViewModel;

class CacheKeyFactoryService
{
    public function __construct()
    {
    }

    public function generateKeyForWeatherService(
        GeoCodeViewModel $geo,
    ): string {
        return sprintf(
            'weather_%s_%s',
            $geo->getLatitude(),
            $geo->getLongitude()
        );
    }

    public function generateKeyForGeoServiceFindByCity(
        CityDto $cityDto,
    ): string {
        return sprintf(
            'city_%s',
            $cityDto->getName(),
        );
    }

    public function generateKeyForGeoServiceFindByCoordinates(
        float $lat,
        float $lng,
    ): string {
        return sprintf(
            'weather_%s_%s',
            $lat,
            $lng
        );
    }
}
