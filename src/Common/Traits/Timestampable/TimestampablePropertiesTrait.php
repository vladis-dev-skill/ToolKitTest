<?php

declare(strict_types=1);

namespace App\Common\Traits\Timestampable;

trait TimestampablePropertiesTrait
{
    protected ?\DateTimeInterface $createdAt = null;

    protected ?\DateTimeInterface $updatedAt = null;
}
