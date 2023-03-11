<?php

declare(strict_types=1);

namespace App\Admin\Service\Client;

use App\Client\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\User\UserInterface;

class ClientsService implements ClientsServiceInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @return UserInterface[]
     */
    public function allClient(): array
    {
        $clients = $this->entityManager->getRepository(Client::class)->findAll();

        if (count($clients) <= 0) {
            throw new BadRequestHttpException('No clients found!');
        }

        return $clients;
    }
}
