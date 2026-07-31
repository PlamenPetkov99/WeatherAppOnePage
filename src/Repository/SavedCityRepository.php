<?php

namespace App\Repository;

use App\Entity\SavedCity;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<SavedCity>
 */
class SavedCityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SavedCity::class);
    }

    //    /**
    //     * @return SavedCity[] Returns an array of SavedCity objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SavedCity
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

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
