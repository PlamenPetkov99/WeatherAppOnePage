<?php

namespace App\Entity;

use App\Repository\SavedCityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SavedCityRepository::class)]
#[ORM\Table(
    name: 't_saved_city',
    uniqueConstraints: [
        new ORM\UniqueConstraint(
            name: 'unique_user_saved_city',
            columns: ['user_id', 'city_name', 'country_name']
        )
    ]
)]
class SavedCity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(inversedBy: 'savedCities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userId = null;

    #[ORM\Column(name: 'city_name',length: 255)]
    private ?string $cityName = null;

    #[ORM\Column(name: 'country_name',length: 255)]
    private ?string $countryName = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column(name:'created_at')]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now');
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    public function setCityName(string $cityName): static
    {
        $this->cityName = $cityName;

        return $this;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function setCountryName(string $countryName): static
    {
        $this->countryName = $countryName;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
