<?php

namespace App\Manager;

use App\Dto\RequestInputDataDto;
use App\Interface\BaseHttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ReverseGeoCodeRequestManager implements BaseHttpClientInterface
{
    public function __construct(
        #[Target('geo_code_reverse.client')]
        private readonly HttpClientInterface $reverseGeoCodeClient
    ){}
    public function get(RequestInputDataDto $data): ResponseInterface
    {
        return $this->reverseGeoCodeClient->request(
            Request::METHOD_GET,
            '/data/reverse-geocode-client',
            [
                'query' => [
                    'latitude' => $data->getLatitude(),
                    'longitude' => $data->getLongtitude(),
                    'localityLanguage' => 'en'
                ],
            ]
        );
    }
}
