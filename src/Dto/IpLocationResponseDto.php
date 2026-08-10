<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class IpLocationResponseDto
{
    private ?string $ip;
    private ?string $network;
    private ?string $version;
    #[Assert\NotBlank(message: 'Error finding the city name')]
    private ?string $city;
    private ?string $region;
    private ?string $regionCode;
    private ?string $country;
    #[Assert\NotBlank(message: 'Error finding the country name')]
    private ?string $countryName;
    private ?string $countryCode;
    private ?string $countryCodeIso3;
    private ?string $countryCapital;
    private ?string $countryTld;
    private ?string $continentCode;
    private ?bool $inEu;
    private ?string $postal;
    #[Assert\NotBlank(message: 'Error finding the latitude')]
    private ?float $latitude;
    #[Assert\NotBlank(message: 'Error finding the longitude')]
    private ?float $longitude;
    #[Assert\NotBlank(message: 'Error finding the timezone')]
    private ?string $timezone;
    private ?string $utcOffset;
    private ?string $countryCallingCode;
    private ?string $currency;
    private ?string $currencyName;
    private ?string $languages;
    private ?float $countryArea;
    private ?int $countryPopulation;
    private ?string $asn;
    private ?string $org;

    public function __construct()
    {
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): void
    {
        $this->ip = $ip;
    }

    public function getNetwork(): ?string
    {
        return $this->network;
    }

    public function setNetwork(?string $network): void
    {
        $this->network = $network;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): void
    {
        $this->version = $version;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    public function getRegionCode(): ?string
    {
        return $this->regionCode;
    }

    public function setRegionCode(?string $regionCode): void
    {
        $this->regionCode = $regionCode;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function setCountryName(?string $countryName): void
    {
        $this->countryName = $countryName;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    public function getCountryCodeIso3(): ?string
    {
        return $this->countryCodeIso3;
    }

    public function setCountryCodeIso3(?string $countryCodeIso3): void
    {
        $this->countryCodeIso3 = $countryCodeIso3;
    }

    public function getCountryCapital(): ?string
    {
        return $this->countryCapital;
    }

    public function setCountryCapital(?string $countryCapital): void
    {
        $this->countryCapital = $countryCapital;
    }

    public function getCountryTld(): ?string
    {
        return $this->countryTld;
    }

    public function setCountryTld(?string $countryTld): void
    {
        $this->countryTld = $countryTld;
    }

    public function getContinentCode(): ?string
    {
        return $this->continentCode;
    }

    public function setContinentCode(?string $continentCode): void
    {
        $this->continentCode = $continentCode;
    }

    public function getInEu(): ?bool
    {
        return $this->inEu;
    }

    public function setInEu(?bool $inEu): void
    {
        $this->inEu = $inEu;
    }

    public function getPostal(): ?string
    {
        return $this->postal;
    }

    public function setPostal(?string $postal): void
    {
        $this->postal = $postal;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(?string $timezone): void
    {
        $this->timezone = $timezone;
    }

    public function getUtcOffset(): ?string
    {
        return $this->utcOffset;
    }

    public function setUtcOffset(?string $utcOffset): void
    {
        $this->utcOffset = $utcOffset;
    }

    public function getCountryCallingCode(): ?string
    {
        return $this->countryCallingCode;
    }

    public function setCountryCallingCode(?string $countryCallingCode): void
    {
        $this->countryCallingCode = $countryCallingCode;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }

    public function getCurrencyName(): ?string
    {
        return $this->currencyName;
    }

    public function setCurrencyName(?string $currencyName): void
    {
        $this->currencyName = $currencyName;
    }

    public function getLanguages(): ?string
    {
        return $this->languages;
    }

    public function setLanguages(?string $languages): void
    {
        $this->languages = $languages;
    }

    public function getCountryArea(): ?float
    {
        return $this->countryArea;
    }

    public function setCountryArea(?float $countryArea): void
    {
        $this->countryArea = $countryArea;
    }

    public function getCountryPopulation(): ?int
    {
        return $this->countryPopulation;
    }

    public function setCountryPopulation(?int $countryPopulation): void
    {
        $this->countryPopulation = $countryPopulation;
    }

    public function getAsn(): ?string
    {
        return $this->asn;
    }

    public function setAsn(?string $asn): void
    {
        $this->asn = $asn;
    }

    public function getOrg(): ?string
    {
        return $this->org;
    }

    public function setOrg(?string $org): void
    {
        $this->org = $org;
    }

}
