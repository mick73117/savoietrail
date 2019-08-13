<?php

namespace App\Entity ;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser ;
use Doctrine\ORM\Mapping as ORM ;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trails", mappedBy="user")
     */
    private $trails;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrailsUser", mappedBy="user")
     */
    private $trailsUsers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrailsComments", mappedBy="user")
     */
    private $trailsComments;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Forum", mappedBy="user")
     */
    private $post;

    public function __construct ()
    {
        parent :: __construct ();
        $this->trailsuser = new ArrayCollection();
        $this->trailscomments = new ArrayCollection();
        $this->photoalbum = new ArrayCollection();
        $this->forum = new ArrayCollection();
        $this->trails = new ArrayCollection();
        $this->trailsUsers = new ArrayCollection();
        $this->trailsComments = new ArrayCollection();
        // your own logic
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Trails[]
     */
    public function getTrails(): Collection
    {
        return $this->trails;
    }

    public function addTrail(Trails $trail): self
    {
        if (!$this->trails->contains($trail)) {
            $this->trails[] = $trail;
            $trail->setUser($this);
        }

        return $this;
    }

    public function removeTrail(Trails $trail): self
    {
        if ($this->trails->contains($trail)) {
            $this->trails->removeElement($trail);
            // set the owning side to null (unless already changed)
            if ($trail->getUser() === $this) {
                $trail->setUser(null);
            }
        }

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
            $trailsUser->setUser($this);
        }

        return $this;
    }

    public function removeTrailsUser(TrailsUser $trailsUser): self
    {
        if ($this->trailsUsers->contains($trailsUser)) {
            $this->trailsUsers->removeElement($trailsUser);
            // set the owning side to null (unless already changed)
            if ($trailsUser->getUser() === $this) {
                $trailsUser->setUser(null);
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
            $trailsComment->setUser($this);
        }

        return $this;
    }

    public function removeTrailsComment(TrailsComments $trailsComment): self
    {
        if ($this->trailsComments->contains($trailsComment)) {
            $this->trailsComments->removeElement($trailsComment);
            // set the owning side to null (unless already changed)
            if ($trailsComment->getUser() === $this) {
                $trailsComment->setUser(null);
            }
        }

        return $this;
    }

    public function getPost(): ?Forum
    {
        return $this->post;
    }

    public function setPost(?Forum $post): self
    {
        $this->post = $post;

        // set (or unset) the owning side of the relation if necessary
        $newUser = $post === null ? null : $this;
        if ($newUser !== $post->getUser()) {
            $post->setUser($newUser);
        }

        return $this;
    }

   
}