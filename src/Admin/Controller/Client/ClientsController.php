<?php
declare(strict_types=1);

namespace App\Admin\Controller\Client;

use App\Admin\Service\Client\ClientsServiceInterface;
use App\Client\Entity\Client;
use App\Common\Annotation\Guid;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: 'api/clients', name: 'api.clients'), IsGranted('ROLE_ADMIN')]
class ClientsController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface         $logger,
        private readonly ClientsServiceInterface $clientService,
    )
    {
    }

    #[Route(path: '', name: '')]
    public function index(SerializerInterface $serializer): Response
    {
        try {
            $clients = $this->clientService->allClient();
            return new Response($serializer->serialize($clients, 'json', ['groups' => 'user_read']));
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
        }

        return $this->json(['message' => 'Something wrong...']);
    }

    /**
     * @param Client|null $user
     * @param SerializerInterface $serializer
     * @return Response
     */
    #[Route(path: '/{id}', name: '.show', requirements: ["id" => Guid::PATTERN])]
    public function show(?Client $user, SerializerInterface $serializer): Response
    {
        if ($user === null) {
            throw new BadRequestHttpException('Client not found!');
        }
        return new Response($serializer->serialize($user, 'json', ['groups' => 'user_read']));
    }

}