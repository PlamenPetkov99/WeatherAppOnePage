<?php

namespace App\Controller;

use App\Dto\CityDto;
use App\Entity\User;
use App\Exception\CityNotFoundException;
use App\Form\SearchWeatherType;
use App\Manager\MapManager;
use App\Repository\SavedCityRepository;
use App\Service\GeoService;
use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

final class IndexController extends AbstractController
{
    public function __construct(
        private readonly MapManager $mapManager,
        private readonly GeoService $geoService,
        private readonly WeatherService $weatherService,
        private readonly SavedCityRepository $savedCityRepository,
    ) {
    }

    #[Route('/', name: 'app_index')]
    public function index(
        Request $request,
        #[MapQueryParameter] ?float $lat,
        #[MapQueryParameter] ?float $lng,
    ): Response {
        $cityDto = new CityDto();
        $form = $this->createForm(SearchWeatherType::class, $cityDto);
        $form->handleRequest($request);
        $weather = null;

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $geoCodeView = $this->geoService->findByCity($cityDto);
                usleep(200000);
                $weather = $this->weatherService->getWeather($geoCodeView);
            } catch (CityNotFoundException $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        } elseif (null !== $lat && null !== $lng) {
            $geoCodeView = $this->geoService->findByCoordinates($lat, $lng);
            usleep(200000);
            $weather = $this->weatherService->getWeather($geoCodeView);

            $form->get('name')->setData($geoCodeView->getName());
        }

        $isSaved = false;
        if ($this->getUser() instanceof UserInterface) {
            $isSaved = $this->savedCityRepository->isSaved(
                $this->getUser(),
                $weather?->getGeoCodeViewModel()->getName(),
                $weather?->getGeoCodeViewModel()->getCountry()
            );
        }

        return $this->render('index/index.html.twig', [
            'form' => $form,
            'weather' => $weather,
            'map' => $this->mapManager->buildMap(),
            'isSaved' => $isSaved,
        ], new Response(null, 200));
    }
}
