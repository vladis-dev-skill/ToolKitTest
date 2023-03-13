<?php

declare(strict_types=1);

namespace App\Client\Entity;

use App\Claim\Entity\Claim;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Common\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Client extends User
{
    #[ORM\Column(type: "string", nullable: true)]
    #[Groups(['client:read'])]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: "string", nullable: true)]
    #[Groups(['client:read'])]
    private ?string $address = null;

    #[ORM\OneToMany(mappedBy: "client", targetEntity: Claim::class, cascade: ["persist", "remove"])]
//    #[Groups(['client:read'])]
    private array|Collection $claims;

    public function __construct()
    {
        parent::__construct();

        $this->claims = new ArrayCollection();
    }

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

    /**
     * @param string|null $phoneNumber
     * @return Client
     */
    public function setPhoneNumber(?string $phoneNumber = null): Client
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @param string|null $address
     * @return Client
     */
    public function setAddress(?string $address = null): Client
    {
        $this->address = $address;
        return $this;
    }

    public function getClaims(): Collection|array
    {
        return $this->claims;
    }

    public function setClaims(Collection|array $claims): void
    {
        $this->claims = $claims;
    }

    public function addClaim(Claim $claim): void
    {
        if ($this->claims->contains($claim) === false) {
            $this->claims->add($claim);
            $claim->setClient($this);
        }
    }

    public function removeClaim(Claim $claim): void
    {
        if ($this->claims->contains($claim)) {
            $this->claims->removeElement($claim);
            $claim->setClient(null);
        }
    }
}
