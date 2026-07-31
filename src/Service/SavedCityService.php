<?php

namespace App\Service;


use App\Dto\SaveCityDto;
use App\Entity\SavedCity;
use App\Entity\User;
use App\Repository\SavedCityRepository;
use Doctrine\ORM\EntityManagerInterface;

class SavedCityService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ParseService $parser,
        private readonly SavedCityRepository $savedCityRepository,
    )
    {
    }

    public function addCityToFavourite(
        SaveCityDto $savedCityDto,
        User $user,
    ): bool
    {
        $savedCity = $this->savedCityRepository->findOneBy([
            'userId'=>$user,
            'cityName' => $savedCityDto->getCityName(),
            'countryName' => $savedCityDto->getCountryName()
        ]);

        if ($savedCity instanceof SavedCity) {

            $this->entityManager->remove($savedCity);
            $this->entityManager->flush();

            return false;
        }

        $cityToSave = $this->parser->parseFromObject($savedCityDto,SavedCity::class);
        assert($cityToSave instanceof  SavedCity);
        $cityToSave->setUserId($user);

        $this->entityManager->persist($cityToSave);
        $this->entityManager->flush();
        return true;
    }


}
