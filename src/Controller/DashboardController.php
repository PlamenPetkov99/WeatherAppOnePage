<?php

namespace App\Controller;

use App\Builder\GeoCodeViewBuilder;
use App\Dto\SaveCityDto;
use App\Entity\User;
use App\Repository\SavedCityRepository;
use App\Service\IpService;
use App\Service\SavedCityService;
use App\Service\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class DashboardController extends AbstractController
{
    public function __construct(
        private readonly IpService $ipService,
        private readonly SavedCityRepository $savedCityRepository,
        private readonly WeatherService $weatherService,
    ) {
    }

    #[Route(path: '/dashboard', name: 'app_dashboard_view')]
    public function view(
        Request $request,
        #[CurrentUser] User $user,
    ) {
        $ipAddress = $request->getClientIp();
        $page = $request->query->getInt('page', 1);

        $savedCities = $this->savedCityRepository->getUserSavedCities(
            $user
        );

        $savedCities->setMaxPerPage(4);
        $savedCities->setCurrentPage(
            $request->query->getInt('page', 1)
        );

        $ipLocationViewModel = $this->ipService->findCityByIp('8.8.8.8'); // TODO CHANGE IT LATER

        $weather = $this->weatherService->getWeather(
            GeoCodeViewBuilder::build([
                'city' => $ipLocationViewModel->getCity(),
                'longitude' => $ipLocationViewModel->getLongitude(),
                'latitude' => $ipLocationViewModel->getLatitude(),
                'countryCode' => $ipLocationViewModel->getCountryCode(),
                'countryName' => $ipLocationViewModel->getCountryName(),
            ])
        );

        return $this->render('dashboard/dashboard.html.twig', [
            'ipLocationViewModel' => $ipLocationViewModel,
            'savedCities' => $savedCities,
            'weather' => $weather,
        ]);
    }

    #[Route(path: '/save', name: 'app_saved_city_save', methods: [Request::METHOD_POST])]
    public function toggleFavouriteCity(
        #[MapRequestPayload] SaveCityDto $saveCityDto,
        #[CurrentUser] User $user,
        SavedCityService $savedCityService,
    ): ?Response {
        $isSaved = $savedCityService->addCityToFavourite($saveCityDto, $user);

        if ($isSaved) {
            $this->addFlash('success', 'City added to your favourites.');

            return $this->redirectToRoute('app_dashboard_view');
        }

        $this->addFlash('success', 'City removed from your favourites.');

        return $this->redirectToRoute('app_dashboard_view');
    }
}
