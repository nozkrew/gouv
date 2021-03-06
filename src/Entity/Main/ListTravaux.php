<?php

namespace App\Entity\Main;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListTravauxRepository")
 */
class ListTravaux
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    
    /**
     * @var \Strategy
     *
     * @ORM\OneToMany(targetEntity="Strategy", mappedBy="travaux")
     */
    private $strategies;
    
    /**
     * @var integer
     * 
     * @ORM\Column(name="priceMeter", type="integer")
     */
    private $priceMeter;
    
    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=false)
     */
    private $text;

    public function __construct()
    {
        $this->strategies = new ArrayCollection();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Strategy[]
     */
    public function getStrategies(): Collection
    {
        return $this->strategies;
    }

    public function addStrategy(Strategy $strategy): self
    {
        if (!$this->strategies->contains($strategy)) {
            $this->strategies[] = $strategy;
            $strategy->setTravaux($this);
        }

        return $this;
    }

    public function removeStrategy(Strategy $strategy): self
    {
        if ($this->strategies->contains($strategy)) {
            $this->strategies->removeElement($strategy);
            // set the owning side to null (unless already changed)
            if ($strategy->getTravaux() === $this) {
                $strategy->setTravaux(null);
            }
        }

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getPriceMeter(): ?int
    {
        return $this->priceMeter;
    }

    public function setPriceMeter(int $priceMeter): self
    {
        $this->priceMeter = $priceMeter;

        return $this;
    }
}
