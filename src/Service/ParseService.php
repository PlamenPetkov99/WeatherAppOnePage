<?php

namespace App\Service;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ParseService
{
    public function __construct(
        private readonly DenormalizerInterface $denormalizer,
        private readonly SerializerInterface $serializer,
    ){}

    public function parseFromJson
    (
        string $jsonInput,
        string $to,
    )
    {
        return $this->serializer->deserialize($jsonInput, $to, 'json');
    }

    public function parseFromArray
    (
        array $arrayInput,
        string $to
    )
    {
        return $this->denormalizer->denormalize($arrayInput, $to,'array');
    }
}
