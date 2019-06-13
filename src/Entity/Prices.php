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
    private $apartmentSale;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $apartmentRental;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $houseSale;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $houseRental;
    
    /**
     * @var \Cities
     *
     * @ORM\ManyToOne(targetEntity="Cities")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="city", referencedColumnName="id")
     * })
     */
    private $city;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApartmentSale(): ?int
    {
        return $this->apartmentSale;
    }

    public function setApartmentSale(?int $apartmentSale): self
    {
        $this->apartmentSale = $apartmentSale;

        return $this;
    }

    public function getApartmentRental(): ?int
    {
        return $this->apartmentRental;
    }

    public function setApartmentRental(?int $apartmentRental): self
    {
        $this->apartmentRental = $apartmentRental;

        return $this;
    }

    public function getHouseSale(): ?int
    {
        return $this->houseSale;
    }

    public function setHouseSale(?int $houseSale): self
    {
        $this->houseSale = $houseSale;

        return $this;
    }

    public function getHouseRental(): ?int
    {
        return $this->houseRental;
    }

    public function setHouseRental(?int $houseRental): self
    {
        $this->houseRental = $houseRental;

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
}
