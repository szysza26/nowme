<?php

namespace NowMe\Entity;

use NowMe\Repository\OpinionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OpinionsRepository::class)
 */
class Opinions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $stars;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="opinions")
     */
    private $user;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="opinionsAbout")
     */
    private $specjalist;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStars(): ?int
    {
        return $this->stars;
    }

    public function setStars(int $stars): self
    {
        $this->stars = $stars;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
