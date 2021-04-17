<?php

declare(strict_types=1);

namespace NowMe\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\ManyToMany(targetEntity="User", mappedBy="offices")
     */
    private $specialists;

    public function __construct()
    {
        $this->specialists = new ArrayCollection();
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

    public function addSpecialist(User $specialist): void
    {
        if ($this->specialists->contains($specialist)) {
            return;
        }

        $this->specialists->add($specialist);
        $specialist->addOffice($this);
    }
}
