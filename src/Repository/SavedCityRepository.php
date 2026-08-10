<?php

namespace App\Repository;

use App\Entity\SavedCity;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Security\Core\User\UserInterface;

class SavedCityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SavedCity::class);
    }

    public function isSaved(
        UserInterface|User $user,
        ?string $cityName,
        ?string $countryName,
    ): bool
    {
        return null !== $this->findOneBy([
                'userId' => $user,
                'cityName' => $cityName,
                'countryName' => $countryName,
            ]);
    }

    public function getUserSavedCities(User|UserInterface $user): Pagerfanta
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->where('c.userId = :user')
            ->setParameter('user', $user)
            ->orderBy('c.createdAt', 'DESC');

        return new Pagerfanta(
            new QueryAdapter($queryBuilder)
        );
    }
}
