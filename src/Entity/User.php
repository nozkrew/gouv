<?php

namespace App\Entity;

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
    
    public function __construct() {
        parent::__construct();
        $this->cities = new ArrayCollection();
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
}
