<?php
declare(strict_types=1);

namespace App\Claim\Controller;

use App\Claim\Service\Claim\ClaimServiceInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: 'api/claims', name: 'api.claims'), IsGranted('ROLE_CLIENT')]
final class ClaimController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface       $logger,
        private readonly ClaimServiceInterface $claimService
    )
    {
    }

    #[Route(path: '', name: '', methods: ["GET"])]
    public function index(SerializerInterface $serializer): Response
    {
        try {
            $clients = $this->claimService->allClaims();
            return new Response($serializer->serialize($clients, 'json', ['groups' => 'claim_read']));
        } catch (\Exception $e) {
            $this->logger->warning($e->getMessage(), ['exception' => $e]);
            return $this->json(['message' => $e->getMessage()]);
        }
    }

}