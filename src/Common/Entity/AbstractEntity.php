<?php
declare(strict_types=1);

namespace App\Common\Entity;

use App\Common\Traits\Timestampable\TimestampableInterface;
use App\Common\Traits\Timestampable\TimestampableTrait;
use Carbon\CarbonImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use ReflectionClass;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\MappedSuperclass]
#[ORM\HasLifecycleCallbacks]
abstract class AbstractEntity implements TimestampableInterface
{
    use TimestampableTrait;

    #[ORM\Column(type: "string", unique: true), ORM\Id]
    protected ?string $id = null;

    #[ORM\Column(type: "datetime_immutable", nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    #[Groups('user_read')]
    protected ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: "datetime_immutable", nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    #[Groups('user_read')]
    protected ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        try {
            $this->id = Uuid::uuid4()->toString();
        } catch (\Exception $exception) {
        }
    }

    public function __isset(string $name): bool
    {
        /** @noinspection PhpVariableVariableInspection */
        return isset($this->$name);
    }

    #[SerializedName("createdAt")]
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getShortClassName(): string
    {
        $reflectionClass = new ReflectionClass(static::class);

        return $reflectionClass->getShortName();
    }

    #[SerializedName("updatedAt")]
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setId(?string $id = null): self
    {
        $this->id = $id;

        return $this;
    }

    #[ORM\PrePersist, ORM\PreUpdate]
    public function updateTimestamps(): void
    {
        $dateTime = CarbonImmutable::now();

        if (isset($this->createdAt) === false) {
            $this->createdAt = $dateTime;
        }

        $this->updatedAt = $dateTime;
    }

}