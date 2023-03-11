<?php

declare(strict_types=1);

namespace App\Common\Security;

interface RolesInterface
{
    /**
     * @var string[]
     */
    public const ALL_ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_CLIENT
    ];

    /**
     * @var string
     */
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @var string
     */
    public const ROLE_CLIENT = 'ROLE_CLIENT';
}
