<?php

declare(strict_types=1);

namespace NowMe\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @GeneratedValue
     */
    private int $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $username;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $email;
    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=512, unique=true, nullable=true)
     */
    private ?string $emailConfirmToken;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $emailConfirmedAt = null;

    /**
     * @ORM\Column(type="string", length=512, nullable=true, unique=true)
     */
    private ?string $resetPasswordToken = null;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Service::class, mappedBy="specjalist")
     * @ORM\JoinColumn(nullable=true)
     */
    private $services;

    /**
     * @ORM\ManyToMany (targetEntity=Office::class, mappedBy="specjalists")
     * @ORM\JoinColumn(nullable=true)
     */
    private $offices;

    /**
     * @var string[]
     */
    private array $roles;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->offices = new ArrayCollection();
    }

    public static function create(
        string $username,
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        string $emailConfirmToken
    ): User {
        $self = new self();
        $self->username = $username;
        $self->email = $email;
        $self->password = $password;
        $self->firstName = $firstName;
        $self->lastName = $lastName;
        $self->emailConfirmToken = $emailConfirmToken;
        $self->createdAt = new \DateTimeImmutable();

        return $self;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function setResetPasswordToken(string $resetPasswordToken): void
    {
        $this->resetPasswordToken = $resetPasswordToken;
    }

    public function resetPassword(string $token, string $encodePassword): void
    {
        if ($token !== $this->resetPasswordToken) {
            throw new \InvalidArgumentException('Invalid reset password token');
        }

        $this->password = $encodePassword;
        $this->resetPasswordToken = null;
    }

    public function confirmEmail(string $token): void
    {
        if ($this->emailConfirmedAt !== null) {
            return;
        }

        if ($token !== $this->emailConfirmToken) {
            throw new \InvalidArgumentException('Invalid confirm e-mail token');
        }

        $this->emailConfirmToken = null;
        $this->emailConfirmedAt = new \DateTimeImmutable();
    }

    public function changeRole(string $role): void
    {
        if (in_array($role, $this->roles, true)) {
            return;
        }

        $this->roles[] = $role;
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->setSpecjalist($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getSpecjalist() === $this) {
                $service->setSpecjalist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Office[]
     */
    public function getOffices(): Collection
    {
        return $this->offices;
    }

    public function addOffice(Office $office): self
    {
        if (!$this->offices->contains($office)) {
            $this->offices[] = $office;
        }

        return $this;
    }

    public function removeOffice(Office $office): self
    {
        $this->offices->removeElement($office);

        return $this;
    }

    public function getRoles()
    {
        // TODO: Implement getRoles() method.
    }

    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
