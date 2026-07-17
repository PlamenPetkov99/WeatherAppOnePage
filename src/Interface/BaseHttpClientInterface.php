<?php

namespace App\Interface;



use App\Dto\RequestInputDataDto;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface BaseHttpClientInterface
{
    public function get(
        RequestInputDataDto $data
    ): ResponseInterface;
}
