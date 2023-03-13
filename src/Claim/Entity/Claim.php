<?php

declare(strict_types=1);

namespace App\Claim\Entity;

use App\Client\Entity\Client;
use App\Common\Entity\AbstractEntity;
use App\Common\Entity\MediaObject;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Claim extends AbstractEntity
{
    #[ORM\Column(type: "string", nullable: true)]
    #[Groups(['claim:read'])]
    private ?string $title = null;

    #[ORM\Column(type: "text", nullable: true)]
    #[Groups(['claim:read'])]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: MediaObject::class)]
    #[ORM\JoinColumn(referencedColumnName: "id", nullable: true, onDelete: "SET NULL")]
    #[Groups('claim:read')]
    private ?MediaObject $file = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'claims')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups('claim:read')]
    private ?Client $client = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Claim
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Claim
    {
        $this->description = $description;
        return $this;
    }

    public function getFile(): ?MediaObject
    {
        return $this->file;
    }

    public function setFile(?MediaObject $file): Claim
    {
        $this->file = $file;
        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): Claim
    {
        $this->client = $client;
        return $this;
    }

}
