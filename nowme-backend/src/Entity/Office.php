<?php

declare(strict_types=1);

namespace NowMe\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @ORM\Entity
 */
final class Office
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @GeneratedValue
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $houseNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zip;

    /**
     * @ORM\ManyToMany(targetEntity=Service::class, mappedBy="offices")
     */
    private $services;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    public function getStreet() : string
    {
        return $this->street;
    }

    public function setStreet(string $street) : self
    {
        $this->street = $street;

        return $this;
    }

    public function getHouseNumber() : string
    {
        return $this->houseNumber;
    }

    public function setHouseNumber(string $houseNumber) : self
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    public function getCity() : string
    {
        return $this->city;
    }

    public function setCity(string $city) : self
    {
        $this->city = $city;

        return $this;
    }

    public function getZip() : string
    {
        return $this->zip;
    }

    public function setZip(string $zip) : self
    {
        $this->zip = $zip;

        return $this;
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
            $service->addOffice($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            $service->removeOffice($this);
        }

        return $this;
    }
}
