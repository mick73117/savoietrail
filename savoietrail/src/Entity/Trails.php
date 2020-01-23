<?php

namespace App\Entity;

use App\Entity\PhotoAlbum;
use App\Entity\TrailsUser;
use App\Entity\TrailsComments;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Synfonfony\Component\Validator\Contraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrailsRepository")
 */
class Trails
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveau;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $denivele;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $altitude_de_depart;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $altitude_d_arrivee;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $temps_a_la_montee;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $temps_a_la_descente;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $temps_total;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="trails")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrailsUser", mappedBy="trails")
     */
    private $trailsUsers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrailsComments", mappedBy="trails")
     */
    private $trailsComments;

    /**
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PhotoAlbum", mappedBy="trails", cascade={"persist", "remove"})
     */
    private $album;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gpx;

    public function __construct()
    {
        $this->trailsUsers = new ArrayCollection();
        $this->trailsComments = new ArrayCollection();
        $this->setDate(new \DateTime());
        $this->setenabled(0);
        $this->album = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(?int $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDenivele(): ?int
    {
        return $this->denivele;
    }

    public function setDenivele(?int $denivele): self
    {
        $this->denivele = $denivele;

        return $this;
    }

    public function getAltitudeDeDepart(): ?int
    {
        return $this->altitude_de_depart;
    }

    public function setAltitudeDeDepart(?int $altitude_de_depart): self
    {
        $this->altitude_de_depart = $altitude_de_depart;

        return $this;
    }

    public function getAltitudeDArrivee(): ?int
    {
        return $this->altitude_d_arrivee;
    }

    public function setAltitudeDArrivee(?int $altitude_d_arrivee): self
    {
        $this->altitude_d_arrivee = $altitude_d_arrivee;

        return $this;
    }

    public function getTempsALaMontee(): ?int
    {
        return $this->temps_a_la_montee;
    }

    public function setTempsALaMontee(?int $temps_a_la_montee): self
    {
        $this->temps_a_la_montee = $temps_a_la_montee;

        return $this;
    }

    public function getTempsALaDescente(): ?int
    {
        return $this->temps_a_la_descente;
    }

    public function setTempsALaDescente(?int $temps_a_la_descente): self
    {
        $this->temps_a_la_descente = $temps_a_la_descente;

        return $this;
    }

    public function getTempsTotal(): ?int
    {
        return $this->temps_total;
    }

    public function setTempsTotal(?int $temps_total): self
    {
        $this->temps_total = $temps_total;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getGpx(): ?string
    {
        return $this->gpx;
    }

    public function setGpx(?string $gpx): self
    {
        $this->gpx = $gpx;

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

    /**
     * @return Collection|TrailsUser[]
     */
    public function getTrailsUsers(): Collection
    {
        return $this->trailsUsers;
    }

    public function addTrailsUser(TrailsUser $trailsUser): self
    {
        if (!$this->trailsUsers->contains($trailsUser)) {
            $this->trailsUsers[] = $trailsUser;
            $trailsUser->setTrails($this);
        }

        return $this;
    }

    public function removeTrailsUser(TrailsUser $trailsUser): self
    {
        if ($this->trailsUsers->contains($trailsUser)) {
            $this->trailsUsers->removeElement($trailsUser);
            // set the owning side to null (unless already changed)
            if ($trailsUser->getTrails() === $this) {
                $trailsUser->setTrails(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TrailsComments[]
     */
    public function getTrailsComments(): Collection
    {
        return $this->trailsComments;
    }

    public function addTrailsComment(TrailsComments $trailsComment): self
    {
        if (!$this->trailsComments->contains($trailsComment)) {
            $this->trailsComments[] = $trailsComment;
            $trailsComment->setTrails($this);
        }

        return $this;
    }

    public function removeTrailsComment(TrailsComments $trailsComment): self
    {
        if ($this->trailsComments->contains($trailsComment)) {
            $this->trailsComments->removeElement($trailsComment);
            // set the owning side to null (unless already changed)
            if ($trailsComment->getTrails() === $this) {
                $trailsComment->setTrails(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PhotoAlbum[]
     */
    public function getAlbum(): Collection
    {
        return $this->album;
    }

    public function addAlbum(PhotoAlbum $album): self
    {
        if (!$this->album->contains($album)) {
            $this->album[] = $album;
            $album->setTrails($this);
        }

        return $this;
    }

    public function removeAlbum(PhotoAlbum $album): self
    {
        if ($this->album->contains($album)) {
            $this->album->removeElement($album);
            // set the owning side to null (unless already changed)
            if ($album->getTrails() === $this) {
                $album->setTrails(null);
            }
        }

        return $this;
    }

 public function setTrails(?Trails $trails): self
    {
        $this->trails = $trails;

        return $this;
    }
   
}
