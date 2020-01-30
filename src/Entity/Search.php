<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchRepository")
 */
class Search
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
    private $priceMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $surfaceMin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriceMax(): ?int
    {
        return $this->priceMax;
    }

    public function setPriceMax(int $priceMax): self
    {
        $this->priceMax = $priceMax;

        return $this;
    }

    public function getSurfaceMin(): ?int
    {
        return $this->surfaceMin;
    }

    public function setSurfaceMin(int $surfaceMin): self
    {
        $this->surfaceMin = $surfaceMin;

        return $this;
    }
}
