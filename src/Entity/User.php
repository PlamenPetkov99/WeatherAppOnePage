<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface, TwoFactorInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $googleAuthenticatorSecret = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $temperatureUnit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $windSpeedUnit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $timeFormat = null;

    #[ORM\OneToMany(targetEntity: SavedCity::class, mappedBy: 'userId', cascade: ['persist'], orphanRemoval: true)]
    private Collection $savedCities;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $backupCodes = [];

    public function __construct()
    {

        $this->setCreatedAt(new \DateTimeImmutable('now'));
        $this->savedCities = new ArrayCollection();
        $this->backupCodes = [];
        $this->windSpeedUnit = 'km/h';
        $this->temperatureUnit = 'Celsius';
        $this->timeFormat = '24h';

    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    public function isGoogleAuthenticatorEnabled(): bool
    {
        return null !== $this->googleAuthenticatorSecret;
    }

    public function getGoogleAuthenticatorUsername(): ?string
    {
        return $this->email;
    }

    public function getGoogleAuthenticatorSecret(): ?string
    {
        return $this->googleAuthenticatorSecret;
    }

    public function setGoogleAuthenticatorSecret(?string $googleAuthenticatorSecret): static
    {
        $this->googleAuthenticatorSecret = $googleAuthenticatorSecret;

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getNames(): ?string
    {
        if ($this->firstName && $this->lastName) {
            return $this->firstName.' '.$this->lastName;
        }

        return null;
    }

    public function getTemperatureUnit(): ?string
    {
        return $this->temperatureUnit;
    }

    public function setTemperatureUnit(?string $temperatureUnit): static
    {
        $this->temperatureUnit = $temperatureUnit;

        return $this;
    }

    public function getWindSpeedUnit(): ?string
    {
        return $this->windSpeedUnit;
    }

    public function setWindSpeedUnit(?string $windSpeedUnit): static
    {
        $this->windSpeedUnit = $windSpeedUnit;

        return $this;
    }

    public function getTimeFormat(): ?string
    {
        return $this->timeFormat;
    }

    public function setTimeFormat(?string $timeFormat): static
    {
        $this->timeFormat = $timeFormat;

        return $this;
    }

    public function getSavedCities(): Collection
    {
        return $this->savedCities;
    }

    public function addSavedCity(SavedCity $savedCity): static
    {
        if (!$this->savedCities->contains($savedCity)) {
            $this->savedCities->add($savedCity);
            $savedCity->setUserId($this);
        }

        return $this;
    }

    public function removeSavedCity(SavedCity $savedCity): static
    {
        if ($this->savedCities->removeElement($savedCity)) {

            if ($savedCity->getUserId() === $this) {
                $savedCity->setUserId(null);
            }
        }

        return $this;
    }

    public function addBackupCode(string $backupCode): void
    {
        if (!in_array($backupCode, $this->backupCodes, true)) {
            $this->backupCodes[] = $backupCode;
        }
    }

    public function getBackupCodes(): ?array
    {
        return $this->backupCodes;
    }

    public function setBackupCodes(?array $backupCodes): static
    {
        $this->backupCodes = $backupCodes;

        return $this;
    }
}
