<?php

declare(strict_types=1);

namespace App\Common\Repository;

use App\Common\Entity\User;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    protected function getEntityClass(): string
    {
        return User::class;
    }
}
