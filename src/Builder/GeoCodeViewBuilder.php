<?php

namespace App\Builder;

use App\ViewModel\GeoCodeViewModel;

class GeoCodeViewBuilder
{
    public function __construct(){}

    public static function build(array $data): GeoCodeViewModel
    {
        return new GeoCodeViewModel()
            ->setName($data['city'])
            ->setLongitude($data['longitude'])
            ->setLatitude($data['latitude'])
            ->setCountryCode($data['countryCode'])
            ->setCountry($data['countryName']);
    }
}
