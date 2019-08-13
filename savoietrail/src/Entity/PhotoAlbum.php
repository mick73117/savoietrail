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
     * @ORM\ManyToOne(targetEntity="App\Entity\Trails", inversedBy="album", cascade={"persist", "remove"})
     */
    private $trails;

    public function getId(): ?int
    {
        return $this->id;
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

        return $this;
    }

   
   
    
}
