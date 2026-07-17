<?php

namespace App\Builder;

use App\Dto\RequestInputDataDto;

class RequestInputDataDtoBuilder
{
    private ?float $latitude = 0;
    private ?float $longtitude = 0;
    private ?string $city = '';

    public function withLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function withLongtitude(?float $longtitude): self
    {
        $this->longtitude = $longtitude;
        return $this;
    }

    public function withCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }


    public function build(): RequestInputDataDto
    {
        return new RequestInputDataDto(
            latitude: $this->latitude,
            longtitude: $this->longtitude,
            city: $this->city,
        );
    }
}
