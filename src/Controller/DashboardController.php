<?php

namespace App\Controller;

use App\Service\IpService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    public function __construct(
        private readonly IpService $ipService,
    ) {
    }

    #[Route(path: '/dashboard', name: 'app_dashboard_view')]
    public function view(
        Request $request,
    ) {
        $ipAddress = $request->getClientIp();

        $ipLocationViewModel = $this->ipService->findCityByIp('8.8.8.8'); // TODO REMOVE THE HARDCODED IP ADDRESS

        return $this->render('dashboard/dashboard.html.twig', [
            'ipLocationViewModel' => $ipLocationViewModel,
        ]);
    }
}
