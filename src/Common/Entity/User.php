<?php
declare(strict_types=1);

namespace App\Common\Entity;

use App\Admin\Entity\Admin;
use App\Client\Entity\Client;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity, ORM\Table(name: "`user`"), UniqueEntity(fields: ["email"])]
#[ORM\InheritanceType("SINGLE_TABLE"), ORM\DiscriminatorColumn(name: "user_type", type: "string")]
#[ORM\DiscriminatorMap(['user' => User::class, 'admin' => Admin::class, 'client' => Client::class])]
class User extends AbstractEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(type: "string", unique: true)]
    #[Groups('user_read')]
    private string $email;

    #[ORM\Column(type: "string", nullable: true)]
    private ?string $password = null;

    private ?string $plainPassword = null;

    /**
     * @var  string[]
     */
    #[ORM\Column(type: "json")]
    #[Groups('user_read')]
    private array $roles = [];

    public function __toString(): string
    {
        return $this->email;
    }

    public function addRole(string $role): self
    {
        if (\in_array($role, $this->roles, true) === false) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(string $role): self
    {
        if (\in_array($role, $this->roles, true)) {
            unset($this->roles[$role]);
        }

        return $this;
    }

    /**
     * @return array|string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function hasRole(string $role): bool
    {
        return \in_array($role, $this->roles, true);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword = null): User
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return User
     */
    public function setPassword(?string $password = null): User
    {
        $this->password = $password;
        return $this;
    }

}