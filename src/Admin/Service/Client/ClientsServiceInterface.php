<?php

declare(strict_types=1);

namespace App\Admin\Service\Client;

use Symfony\Component\Security\Core\User\UserInterface;

interface ClientsServiceInterface
{
    /**
     * @return UserInterface[]
     * @throws \Exception
     */
    public function allClient(): array;
}
