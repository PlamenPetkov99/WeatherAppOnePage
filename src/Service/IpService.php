<?php

namespace App\Service;

use App\Builder\RequestInputDataDtoBuilder;
use App\Dto\IpLocationResponseDto;
use App\Exception\CityNotFoundException;
use App\Manager\IpLocatorRequestManager;
use App\ViewModel\IpLocationViewModel;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

readonly class IpService
{
    public function __construct(
        private IpLocatorRequestManager $ipLocatorRequestManager,
        private RequestInputDataDtoBuilder $requestInputDataDtoBuilder,
        private CacheKeyFactoryService $cacheKeyFactory,
        private CacheInterface $cache,
        private ValidatorInterface $validator,
        private ParseService $parser,
    ) {
    }

    public function findCityByIp(string $ipAddress): IpLocationViewModel
    {
        return $this->cache->get(
            $this->cacheKeyFactory->generateKeyForIpLocator($ipAddress),
            function (ItemInterface $item) use ($ipAddress) {
                $item->expiresAfter(300);

                $ipLocation = $this->ipLocatorRequestManager->get(
                    $this->requestInputDataDtoBuilder
                        ->withIpAddress($ipAddress)
                        ->build()
                );

                $ipLocatorResponseDto = $this->parser->parseFromJson($ipLocation->getContent(), IpLocationResponseDto::class);

                $errors = $this->validator->validate($ipLocatorResponseDto);

                if (count($errors) > 0) {
                    throw new CityNotFoundException('City is not found.');
                }

                return $this->parser->parseFromObject($ipLocatorResponseDto, IpLocationViewModel::class);
            }
        );
    }
}
