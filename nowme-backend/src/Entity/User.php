<?php

declare(strict_types=1);

namespace NowMe\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;
use Symfony\Component\Security\Core\User\UserInterface;
use Webmozart\Assert\Assert;

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
     * @ORM\OneToMany(targetEntity="NowMe\Entity\Service", mappedBy="specialist")
     */
    private $services;

    /**
     * @ORM\OneToMany(targetEntity="NowMe\Entity\Reservation", mappedBy="specialist")
     */
    private $specialistReservations;

    /**
     * @ORM\OneToMany(targetEntity="NowMe\Entity\Reservation", mappedBy="user")
     */
    private $userReservations;

    /**
     * @ORM\Column(type="json")
     * @var array<string>
     */
    private array $roles = [];

    /**
     * @ORM\ManyToMany(targetEntity="NowMe\Entity\Office", inversedBy="specialists")
     */
    private $offices;

    /**
     * @ORM\OneToMany(targetEntity="NowMe\Entity\Availability", mappedBy="specjalist")
     */
    private $availabilities;

    /**
     * @ORM\OneToMany(targetEntity=Opinions::class, mappedBy="user")
     */
    private $opinions;

    /**
     * @ORM\OneToMany(targetEntity=Opinions::class, mappedBy="specjalist")
     */
    private $opinionsAbout;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $phoneNumber;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->offices = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->specialistReservations = new ArrayCollection();
        $this->userReservations = new ArrayCollection();
        $this->availabilities = new ArrayCollection();
        $this->opinions = new ArrayCollection();
        $this->opinionsAbout = new ArrayCollection();
    }

    public static function create(
        string $username,
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        string $emailConfirmToken,
        string $phoneNumber
    ): User {
        $self = new self();
        $self->username = $username;
        $self->email = $email;
        $self->password = $password;
        $self->firstName = $firstName;
        $self->lastName = $lastName;
        $self->emailConfirmToken = $emailConfirmToken;
        $self->phoneNumber = $phoneNumber;

        return $self;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function phoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function fullName(): string
    {
        return \sprintf('%s %s', $this->firstName(), $this->lastName());
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
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

    public function assignAs(string $role): void
    {
        if (in_array($role, $this->roles, true)) {
            return;
        }

        $this->roles[] = $role;
    }

    public function getRoles(): array
    {
        return array_unique($this->roles);
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getSpecialistReservations()
    {
        return $this->specialistReservations;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getUserReservations()
    {
        return $this->userReservations;
    }

    public function assignOffices(array $offices): void
    {
        Assert::allIsInstanceOf($offices, Office::class);

        foreach ($offices as $office) {
            if ($this->offices->contains($office)) {
                continue;
            }

            $this->offices->add($office);
            $office->addSpecialist($this);
        }
    }

    public function addOffice(Office $office): void
    {
        if ($this->offices->contains($office)) {
            return;
        }

        $this->offices->add($office);
        $office->addSpecialist($this);
    }

    /**
     * @return Collection|Availability[]
     */
    public function getAvailabilities()
    {
        return $this->availabilities;
    }

    public function addAvailability(Availability $availability): self
    {
        if (!$this->availabilities->contains($availability)) {
            $this->availabilities[] = $availability;
            $availability->setSpecjalist($this);
        }

        return $this;
    }

    public function removeAvailability(Availability $availability): self
    {
        if ($this->availabilities->removeElement($availability)) {
            // set the owning side to null (unless already changed)
            if ($availability->getSpecjalist() === $this) {
                $availability->setSpecjalist(null);
            }
        }

        return $this;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|Opinions[]
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }

    public function addOpinion(Opinions $opinion): self
    {
        if (!$this->opinions->contains($opinion)) {
            $this->opinions[] = $opinion;
            $opinion->setUser($this);
        }

        return $this;
    }

    public function removeOpinion(Opinions $opinion): self
    {
        if ($this->opinions->removeElement($opinion)) {
            // set the owning side to null (unless already changed)
            if ($opinion->getUser() === $this) {
                $opinion->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Opinions[]
     */
    public function getOpinionsAbout(): Collection
    {
        return $this->opinionsAbout;
    }

    public function addOpinionsAbout(Opinions $opinionsAbout): self
    {
        if (!$this->opinionsAbout->contains($opinionsAbout)) {
            $this->opinionsAbout[] = $opinionsAbout;
            $opinionsAbout->setSpecjalist($this);
        }

        return $this;
    }

    public function removeOpinionsAbout(Opinions $opinionsAbout): self
    {
        if ($this->opinionsAbout->removeElement($opinionsAbout)) {
            // set the owning side to null (unless already changed)
            if ($opinionsAbout->getSpecjalist() === $this) {
                $opinionsAbout->setSpecjalist(null);
            }
        }

        return $this;
    }
}