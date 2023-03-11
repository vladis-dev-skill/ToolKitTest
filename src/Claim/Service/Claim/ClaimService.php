<?php
declare(strict_types=1);

namespace App\Claim\Service\Claim;

use App\Claim\Entity\Claim;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ClaimService implements ClaimServiceInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @return Claim[]
     */
    public function allClaims(): array
    {
        $claims = $this->entityManager->getRepository(Claim::class)->findAll();

        if (count($claims) <= 0) {
            throw new BadRequestHttpException('No clients found!');
        }

        return $claims;
    }
}