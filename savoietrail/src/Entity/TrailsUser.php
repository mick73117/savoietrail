<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrailsUserRepository")
 */
class TrailsUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $favori;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trails", inversedBy="trailsUsers")
     */
    private $trails;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="trailsUsers")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFavori(): ?bool
    {
        return $this->favori;
    }

    public function setFavori(): ?int
    {
        $this->favori = $favori;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getTrails(): ?Trails
    {
        return $this->trails;
    }

    public function setTrails(?Trails $trails): self
    {
        $this->trails = $trails;

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
}
