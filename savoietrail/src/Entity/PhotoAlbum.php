<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhotoAlbumRepository")
 * @Vich\Uploadable
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
     * 
     * @Vich\UploadableField(mapping="album", fileNameProperty="imageName")
     * 
     * @var File
     */
    private $album;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;

    // /**
    //  * @ORM\Column(type="string", length=255, nullable=true)
    //  */
    // private $album;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trails", inversedBy="album")
     */
    private $trails;

    public function getId(): ?int
    {
        return $this->id;
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


    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $album
     */
    public function setAlbum(?File $album = null): void
    {
        $this->album = $album;

    }

    public function getAlbum(): ?File
    {
        return $this->album;
    }
   

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
}
