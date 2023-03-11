<?php

declare(strict_types=1);

namespace App\Client\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Common\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Client extends User
{
    #[ORM\Column(type: "string", nullable: true)]
    #[Groups('user_read')]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: "string", nullable: true)]
    #[Groups('user_read')]
    private ?string $address = null;

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }
}
