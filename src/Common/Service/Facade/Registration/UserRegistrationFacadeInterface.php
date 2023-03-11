<?php

declare(strict_types=1);

namespace App\Common\Service\Facade\Registration;

use App\Common\DTO\UserDTOInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserRegistrationFacadeInterface
{
    /**
     * @param UserDTOInterface $user
     * @return UserInterface
     * @throws \Exception
     */
    public function registerUser(UserDTOInterface $user): UserInterface;
}
