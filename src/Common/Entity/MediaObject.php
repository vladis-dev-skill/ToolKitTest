<?php

declare(strict_types=1);

namespace App\Common\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity, Vich\Uploadable]
class MediaObject extends AbstractEntity
{
    #[ORM\Column(type: "string", nullable: true)]
    #[Groups("media_object_read")]
    private ?string $contentUrl = null;

    #[Assert\NotNull(groups: ["media_object_create"])]
    #[Vich\UploadableField(mapping: "media_object", fileNameProperty: "filePath")]
    private ?File $file = null;

    #[ORM\Column(type: "string", nullable: true)]
    private ?string $filePath = null;

    public function __toString()
    {
        return $this->filePath;
    }

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setContentUrl(?string $contentUrl = null): void
    {
        $this->contentUrl = $contentUrl;
    }

    public function setFile(?File $file = null): void
    {
        $this->file = $file;
        if ($file) {
            $this->updatedAt = new \DateTimeImmutable('now');
        }
    }

    public function setFilePath(?string $filePath = null): void
    {
        $this->filePath = $filePath;
    }
}
