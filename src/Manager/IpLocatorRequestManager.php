<?php

namespace App\Manager;

use App\Dto\RequestInputDataDto;
use App\Interface\BaseHttpClientInterface;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

readonly class IpLocatorRequestManager implements BaseHttpClientInterface
{
    public function __construct(
        #[Target('ip_locator.client')]
        private HttpClientInterface $ipLocatorClient,
    ) {
    }

    public function get(RequestInputDataDto $data): ResponseInterface
    {
        return $this->ipLocatorClient->request(
            method: Request::METHOD_GET,
            url: "/{$data->getIpAddress()}/json",
            options: []
        );
    }
}
