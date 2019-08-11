<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhotoAlbumRepository")
 */
class PhotoAlbum
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $album;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Trails", mappedBy="album", cascade={"persist", "remove"})
     */
    private $trails;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->album;
    }

    public function getAlbum(): ?string
    {
        return $this->album;
    }

    public function setAlbum(?string $album): self
    {
        $this->album = $album;

        return $this;
    }


    public function getTrails(): ?Trails
    {
        return $this->trails;
    }

    public function setTrails(?Trails $trails): self
    {
        $this->trails = $trails;

        // set (or unset) the owning side of the relation if necessary
        $newAlbum = $trails === null ? null : $this;
        if ($newAlbum !== $trails->getAlbum()) {
            $trails->setAlbum($newAlbum);
        }

        return $this;
        
    }
    
}
