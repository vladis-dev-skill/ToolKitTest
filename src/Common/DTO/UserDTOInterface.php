<?php

declare(strict_types=1);

namespace App\Common\DTO;

interface UserDTOInterface
{
    public const USER_TYPES = [
        self::TYPE_CLIENT,
        self::TYPE_ADMIN,
    ];

    public const TYPE_CLIENT = 'client';

    public const TYPE_ADMIN = 'admin';
}
