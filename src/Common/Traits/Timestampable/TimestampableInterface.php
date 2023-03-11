<?php

declare(strict_types=1);

namespace App\Common\Traits\Timestampable;

interface TimestampableInterface
{
    /**
     * @return void
     */
    public function updateTimestamps(): void;

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface;

    /**
     * @param \DateTimeInterface|null $createdAt
     *
     * @return void
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt = null): void;

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface;

    /**
     * @param \DateTimeInterface|null $updatedAt
     *
     * @return void
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt = null): void;
}
