<?php

declare(strict_types=1);

namespace NowMe\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use NowMe\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="date")
     */
    private \DateTimeInterface $day;

    /**
     * @ORM\Column(type="time")
     */
    private \DateTimeInterface $startTime;

    /**
     * @ORM\Column(type="time")
     */
    private \DateTimeInterface $endTime;

    /**
     * @ORM\ManyToOne(targetEntity="NowMe\Entity\User", inversedBy="services")
     */
    private User $specialist;

    /**
     * @ORM\ManyToOne(targetEntity="NowMe\Entity\User", inversedBy="services")
     */
    private User $user;

    /**
     * @ORM\ManyToOne(targetEntity="NowMe\Entity\Office")
     */
    private Office $office;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="reservations")
     */
    private $service;

    /**
     * @ORM\OneToMany(targetEntity=Payment::class, mappedBy="reservationId")
     */
    private $payments;

    public function __construct()
    {
        $this->payments = new ArrayCollection();
    }


    public function getDay() : \DateTimeInterface
    {
        return $this->day;
    }

    public function setDay(\DateTimeInterface $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getStartTime() : \DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }


    public function getEndTime() : \DateTimeInterface
    {
        return $this->endTime;
    }


    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getSpecialist() : User
    {
        return $this->specialist;
    }

    public function setSpecialist(User $specialist): self
    {
        $this->specialist = $specialist;

        return $this;
    }

    public function getUser() : User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOffice() : Office
    {
        return $this->office;
    }

    public function setOffice(Office $office): self
    {
        $this->office = $office;

        return $this;
    }

    public function getService(): Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection|Payment[]
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payments->contains($payment)) {
            $this->payments[] = $payment;
            $payment->setReservationId($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getReservationId() === $this) {
                $payment->setReservationId(null);
            }
        }

        return $this;
    }
}
