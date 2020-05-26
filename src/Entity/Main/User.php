<?php

namespace App\Entity\Main;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="`user`")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;
        
    /**
     * @var \Cities
     *
     * @ORM\ManyToMany(targetEntity="Cities", inversedBy="users")
     */
    private $cities;
    
    /**
     * @ORM\OneToMany(targetEntity="Search", mappedBy="user")
     */
    private $searches;
    
    /**
     * @var \Strategy
     * 
     * @ORM\OneToOne(targetEntity="Strategy", mappedBy="user")
     */
    private $strategy;
    
    public function __construct() {
        parent::__construct();
        $this->groups = new ArrayCollection();
        $this->cities = new ArrayCollection();
        $this->searches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Cities[]
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(Cities $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities[] = $city;
        }

        return $this;
    }

    public function removeCity(Cities $city): self
    {
        if ($this->cities->contains($city)) {
            $this->cities->removeElement($city);
        }

        return $this;
    }

    /**
     * @return Collection|Search[]
     */
    public function getSearches(): Collection
    {
        return $this->searches;
    }

    public function addSearch(Search $search): self
    {
        if (!$this->searches->contains($search)) {
            $this->searches[] = $search;
            $search->setUser($this);
        }

        return $this;
    }

    public function removeSearch(Search $search): self
    {
        if ($this->searches->contains($search)) {
            $this->searches->removeElement($search);
            // set the owning side to null (unless already changed)
            if ($search->getUser() === $this) {
                $search->setUser(null);
            }
        }

        return $this;
    }

    public function getStrategy(): ?Strategy
    {
        return $this->strategy;
    }

    public function setStrategy(?Strategy $strategy): self
    {
        $this->strategy = $strategy;

        // set (or unset) the owning side of the relation if necessary
        $newUser = null === $strategy ? null : $this;
        if ($strategy->getUser() !== $newUser) {
            $strategy->setUser($newUser);
        }

        return $this;
    }
}
