<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StrategyRepository")
 */
class Strategy
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $cashflow;
    
     /**
     * @var \ListExploitation
     *
     * @ORM\ManyToMany(targetEntity="ListExploitation", inversedBy="strategies")
     */
    private $exploitations;
    
    /**
     * @var \ListTypeBien
     *
     * @ORM\ManyToMany(targetEntity="ListTypeBien", inversedBy="strategies")
     */
    private $types;
    
    /**
     * @var \ListTravaux
     *
     * @ORM\ManyToOne(targetEntity="ListTravaux", inversedBy="strategies")
     */
    private $travaux;
    
    /**
     * @var \User
     * 
     * @ORM\OneToOne(targetEntity="User", inversedBy="strategy")
     */
    private $user;

    public function __construct()
    {
        $this->exploitations = new ArrayCollection();
        $this->types = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCashflow(): ?int
    {
        return $this->cashflow;
    }

    public function setCashflow(int $cashflow): self
    {
        $this->cashflow = $cashflow;

        return $this;
    }

    /**
     * @return Collection|ListExploitation[]
     */
    public function getExploitations(): Collection
    {
        return $this->exploitations;
    }

    public function addExploitation(ListExploitation $exploitation): self
    {
        if (!$this->exploitations->contains($exploitation)) {
            $this->exploitations[] = $exploitation;
        }

        return $this;
    }

    public function removeExploitation(ListExploitation $exploitation): self
    {
        if ($this->exploitations->contains($exploitation)) {
            $this->exploitations->removeElement($exploitation);
        }

        return $this;
    }

    /**
     * @return Collection|ListTypeBien[]
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(ListTypeBien $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types[] = $type;
        }

        return $this;
    }

    public function removeType(ListTypeBien $type): self
    {
        if ($this->types->contains($type)) {
            $this->types->removeElement($type);
        }

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

    public function getTravaux(): ?ListTravaux
    {
        return $this->travaux;
    }

    public function setTravaux(?ListTravaux $travaux): self
    {
        $this->travaux = $travaux;

        return $this;
    }
}
