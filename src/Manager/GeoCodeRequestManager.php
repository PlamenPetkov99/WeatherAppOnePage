<?php

namespace App\Manager;


use App\Dto\RequestInputDataDto;
use App\Interface\BaseHttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GeoCodeRequestManager implements BaseHttpClientInterface
{
    public function __construct(
        #[Target('geo_code.client')]
        private readonly HttpClientInterface $geoCodeClient
    ){}
    public function get(
        RequestInputDataDto $data
    ): ResponseInterface
    {
        return $this->geoCodeClient->request(
            Request::METHOD_GET,
            '/v1/search',
            [
                'query' => [
                    'name' => $data->getCity(),
                    'count' => 1,
                    'language' => 'en',
                    'format' => 'json'
                ]
            ]
        );
    }
}
