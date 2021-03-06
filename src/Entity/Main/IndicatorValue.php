<?php

namespace App\Entity\Main;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IndicatorValueRepository")
 */
class IndicatorValue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $tabData = [];
    
    /**
     * @ORM\ManyToOne(targetEntity="Cities", inversedBy="indicatorValues")
     */
    private $city;
    
    /**
     * @ORM\ManyToOne(targetEntity="Indicator", inversedBy="indicatorValues")
     */
    private $indicator;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTabData(): ?array
    {
        return $this->tabData;
    }

    public function setTabData(array $tabData): self
    {
        $this->tabData = $tabData;

        return $this;
    }

    public function getCity(): ?Cities
    {
        return $this->city;
    }

    public function setCity(?Cities $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getIndicator(): ?Indicator
    {
        return $this->indicator;
    }

    public function setIndicator(?Indicator $indicator): self
    {
        $this->indicator = $indicator;

        return $this;
    }
}
