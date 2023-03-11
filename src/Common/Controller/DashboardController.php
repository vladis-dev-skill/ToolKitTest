<?php

declare(strict_types=1);

namespace App\Common\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "/api", name: "api")]
class DashboardController extends AbstractController
{
    #[Route(path: "/dashboard", name: ".dashboard")]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to Dashboard!',
        ]);
    }
}
