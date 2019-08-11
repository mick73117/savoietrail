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

    // /**
    //  * @ORM\OneToOne(targetEntity="App\Entity\Forum", mappedBy="user")
    //  */
    // private $forum;

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
     * @return Collection|Trailsuser[]
     */
    public function getTrailsuser(): Collection
    {
        return $this->trailsuser;
    }

    public function addTrailsuser(Trailsuser $trailsuser): self
    {
        if (!$this->trailsuser->contains($trailsuser)) {
            $this->trailsuser[] = $trailsuser;
            $trailsuser->setUser($this);
        }

        return $this;
    }

    public function removeTrailsuser(Trailsuser $trailsuser): self
    {
        if ($this->trailsuser->contains($trailsuser)) {
            $this->trailsuser->removeElement($trailsuser);
            // set the owning side to null (unless already changed)
            if ($trailsuser->getUser() === $this) {
                $trailsuser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Trailscomments[]
     */
    public function getTrailscomments(): Collection
    {
        return $this->trailscomments;
    }

    public function addTrailscomment(Trailscomments $trailscomment): self
    {
        if (!$this->trailscomments->contains($trailscomment)) {
            $this->trailscomments[] = $trailscomment;
            $trailscomment->setUser($this);
        }

        return $this;
    }

    public function removeTrailscomment(Trailscomments $trailscomment): self
    {
        if ($this->trailscomments->contains($trailscomment)) {
            $this->trailscomments->removeElement($trailscomment);
            // set the owning side to null (unless already changed)
            if ($trailscomment->getUser() === $this) {
                $trailscomment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Photoalbum[]
     */
    public function getPhotoalbum(): Collection
    {
        return $this->photoalbum;
    }

    public function addPhotoalbum(Photoalbum $photoalbum): self
    {
        if (!$this->photoalbum->contains($photoalbum)) {
            $this->photoalbum[] = $photoalbum;
            $photoalbum->setUser($this);
        }

        return $this;
    }

    public function removePhotoalbum(Photoalbum $photoalbum): self
    {
        if ($this->photoalbum->contains($photoalbum)) {
            $this->photoalbum->removeElement($photoalbum);
            // set the owning side to null (unless already changed)
            if ($photoalbum->getUser() === $this) {
                $photoalbum->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Forum[]
     */
    public function getForum(): Collection
    {
        return $this->forum;
    }

    public function addForum(Forum $forum): self
    {
        if (!$this->forum->contains($forum)) {
            $this->forum[] = $forum;
            $forum->setUser($this);
        }

        return $this;
    }

    public function removeForum(Forum $forum): self
    {
        if ($this->forum->contains($forum)) {
            $this->forum->removeElement($forum);
            // set the owning side to null (unless already changed)
            if ($forum->getUser() === $this) {
                $forum->setUser(null);
            }
        }

        return $this;
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

    public function setForum(?Forum $forum): self
    {
        $this->forum = $forum;

        // set (or unset) the owning side of the relation if necessary
        $newUser = $forum === null ? null : $this;
        if ($newUser !== $forum->getUser()) {
            $forum->setUser($newUser);
        }

        return $this;
    }
}