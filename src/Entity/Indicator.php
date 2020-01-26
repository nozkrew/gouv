<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IndicatorRepository")
 */
class Indicator
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
    private $title;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $unity;
    
    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\IndicatorValue", mappedBy="indicator")
     */
    private $indicatorValues;
    

    public function __construct()
    {
        $this->values = new ArrayCollection();
        $this->indicatorValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUnity(): ?string
    {
        return $this->unity;
    }

    public function setUnity(string $unity): self
    {
        $this->unity = $unity;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|IndicatorValue[]
     */
    public function getIndicatorValues(): Collection
    {
        return $this->indicatorValues;
    }

    public function addIndicatorValue(IndicatorValue $indicatorValue): self
    {
        if (!$this->indicatorValues->contains($indicatorValue)) {
            $this->indicatorValues[] = $indicatorValue;
            $indicatorValue->setIndicator($this);
        }

        return $this;
    }

    public function removeIndicatorValue(IndicatorValue $indicatorValue): self
    {
        if ($this->indicatorValues->contains($indicatorValue)) {
            $this->indicatorValues->removeElement($indicatorValue);
            // set the owning side to null (unless already changed)
            if ($indicatorValue->getIndicator() === $this) {
                $indicatorValue->setIndicator(null);
            }
        }

        return $this;
    }
}
