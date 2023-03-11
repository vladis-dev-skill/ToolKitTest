<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use App\Admin\Service\Client\ClientsServiceInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: 'api/clients', name: 'api.clients'), IsGranted('ROLE_ADMIN')]
final class ShowAllClientController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface         $logger,
        private readonly ClientsServiceInterface $clientService,
    )
    {
    }

    #[Route(path: '', name: '', methods: ["GET"])]
    public function index(SerializerInterface $serializer): Response
    {
        try {
            $clients = $this->clientService->allClient();
            return new Response($serializer->serialize($clients, 'json', ['groups' => 'user_read']));
        } catch (\Exception $e) {
            $this->logger->warning($e->getMessage(), ['exception' => $e]);
            return $this->json(['message' => $e->getMessage()]);
        }
    }
}
