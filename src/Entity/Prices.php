<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PricesRepository")
 */
class Prices
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $priceMeter;
    
    /**
     * @var \Cities
     *
     * @ORM\OneToOne(targetEntity="Cities", inversedBy="price")
     * @ORM\JoinColumn(name="city", referencedColumnName="id")
     */
    private $city;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPriceMeter(): ?int
    {
        return $this->priceMeter;
    }

    public function setPriceMeter(?int $priceMeter): self
    {
        $this->priceMeter = $priceMeter;

        return $this;
    }
}
