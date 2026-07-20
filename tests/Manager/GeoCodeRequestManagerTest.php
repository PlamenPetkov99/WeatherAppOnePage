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
        // Mock the HttpClientInterface
        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        $mockResponse = $this->createMock(ResponseInterface::class);

        // Configure the mock to expect a specific call
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

        // Create an instance of GeoCodeRequestManager with the mocked client
        $manager = new GeoCodeRequestManager($mockHttpClient);

        // Mock the RequestInputDataDto
        $mockRequestInputDataDto = $this->createMock(RequestInputDataDto::class);
        $mockRequestInputDataDto->method('getCity')->willReturn('London');

        // Call the get method
        $response = $manager->get($mockRequestInputDataDto);

        // Assert that the response is the mocked response
        $this->assertSame($mockResponse, $response);
    }
}
