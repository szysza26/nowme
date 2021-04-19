<?php

namespace NowMe\Entity;

use NowMe\Repository\AvailabilityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvailabilityRepository::class)
 */
class Availability
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $hour_from;

    /**
     * @ORM\Column(type="time")
     */
    private $hour_to;

    /**
     * @ORM\ManyToOne(targetEntity=Office::class, inversedBy="availabilities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $office;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="availabilities")
     */
    private $specjalist;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHourFrom(): ?\DateTimeInterface
    {
        return $this->hour_from;
    }

    public function setHourFrom(\DateTimeInterface $hour_from): self
    {
        $this->hour_from = $hour_from;

        return $this;
    }

    public function getHourTo(): ?\DateTimeInterface
    {
        return $this->hour_to;
    }

    public function setHourTo(\DateTimeInterface $hour_to): self
    {
        $this->hour_to = $hour_to;

        return $this;
    }

    public function getOffice(): ?Office
    {
        return $this->office;
    }

    public function setOffice(?Office $office): self
    {
        $this->office = $office;

        return $this;
    }

    public function getSpecjalist(): ?User
    {
        return $this->specjalist;
    }

    public function setSpecjalist(?User $specjalist): self
    {
        $this->specjalist = $specjalist;

        return $this;
    }
}
