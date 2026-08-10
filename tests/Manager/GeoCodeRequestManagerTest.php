<?php

namespace App\Tests\Manager;

use App\Dto\RequestInputDataDto;
use App\Manager\GeoCodeRequestManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GeoCodeRequestManagerTest extends TestCase
{
    public function testGetMethodMakesCorrectApiCall()
    {

        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        $mockResponse = $this->createMock(ResponseInterface::class);

        $mockHttpClient->expects($this->once())
            ->method('request')
            ->with(
                Request::METHOD_GET,
                '/v1/search',
                [
                    'query' => [
                        'name' => 'London',
                        'count' => 1,
                        'language' => 'en',
                        'format' => 'json'
                    ]
                ]
            )
            ->willReturn($mockResponse);

        $manager = new GeoCodeRequestManager($mockHttpClient);

        $mockRequestInputDataDto = $this->createMock(RequestInputDataDto::class);
        $mockRequestInputDataDto->method('getCity')->willReturn('London');

        $response = $manager->get($mockRequestInputDataDto);

        $this->assertSame($mockResponse, $response);
    }
}
