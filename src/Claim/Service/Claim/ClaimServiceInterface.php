<?php
declare(strict_types=1);

namespace App\Claim\Service\Claim;

use App\Claim\Entity\Claim;

interface ClaimServiceInterface
{
    /**
     * @return Claim[]
     * @throws \Exception
     */
    public function allClaims(): array;


}