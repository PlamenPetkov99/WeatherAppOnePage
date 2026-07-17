<?php

namespace App\Service;

use App\Builder\GeoCodeViewBuilder;
use App\Builder\RequestInputDataDtoBuilder;
use App\Dto\CityDto;
use App\Dto\GeoResponseDto;
use App\Exception\CityNotFoundException;
use App\Manager\GeoCodeRequestManager;
use App\Manager\ReverseGeoCodeRequestManager;
use App\ViewModel\GeoCodeViewModel;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GeoService
{
    public function __construct(
        private readonly GeoCodeRequestManager $geoCodeRequestManager,
        private readonly ReverseGeoCodeRequestManager $reverseGeoCodeRequestManager,
        private readonly RequestInputDataDtoBuilder $requestInputDataDtoBuilder,
        private readonly ParseService $parser,
        private readonly ValidatorInterface $validator,
    ){}
    public function findByCity(CityDto $cityDto): GeoCodeViewModel
    {
        $location = $this->geoCodeRequestManager->get(
            $this->requestInputDataDtoBuilder
                ->withCity($cityDto->getName())
                ->build()
        );

        $geoResponseDto = $this->parser->parseFromJson($location->getContent(), GeoResponseDto::class);

        $errors = $this->validator->validate($geoResponseDto);

        if (count($errors) > 0) {
            throw new CityNotFoundException('City is not found.');
        }

        return $this->parser->parseFromArray($geoResponseDto->getResults(), GeoCodeViewModel::class);
    }

    public function findByCoordinates(
        float $lat,
        float $lng
    ): GeoCodeViewModel
    {
        $reversedLocation = $this->reverseGeoCodeRequestManager->get(
            $this->requestInputDataDtoBuilder
                ->withLatitude($lat)
                ->withLongtitude($lng)
                ->build()
        );

        return GeoCodeViewBuilder::build($reversedLocation->toArray());
    }

}
