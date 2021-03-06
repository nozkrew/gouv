<?php

namespace App\Entity\Main;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cities
 *
 * @ORM\Table(name="cities", indexes={@ORM\Index(name="cities_department_code_foreign", columns={"department_code"})})
 * @ORM\Entity(repositoryClass="App\Repository\CitiesRepository")
 */
class Cities
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="insee_code", type="string", length=5, nullable=true)
     */
    private $inseeCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zip_code", type="string", length=5, nullable=true)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var float
     *
     * @ORM\Column(name="gps_lat", type="float", precision=16, scale=14, nullable=false)
     */
    private $gpsLat;

    /**
     * @var float
     *
     * @ORM\Column(name="gps_lng", type="float", precision=17, scale=14, nullable=false)
     */
    private $gpsLng;

    /**
     * @var string|null
     *
     * @ORM\Column(name="department_code", type="string", length=3)
     */
    private $departmentCode;
    
    /**
     * @var \Prices
     *
     * @ORM\OneToOne(targetEntity="Prices", mappedBy="city")
     */
    private $price;
    
    /**
     * @var \Population
     *
     * @ORM\OneToOne(targetEntity="Population", mappedBy="city")
     */
    private $population;
    
    /**
     * @ORM\OneToMany(targetEntity="IndicatorValue", mappedBy="city")
     */
    private $indicatorValues;
    
    /**
     * @var \User
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="cities")
     */
    private $users;
    
    /**
     * @var \Search
     *
     * @ORM\ManyToMany(targetEntity="Search", mappedBy="cities")
     */
    private $searches;

    public function __construct()
    {
        $this->indicators = new ArrayCollection();
        $this->indicatorValues = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->searches = new ArrayCollection();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInseeCode(): ?string
    {
        return $this->inseeCode;
    }

    public function setInseeCode(?string $inseeCode = null): self
    {
        $this->inseeCode = $inseeCode;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name = null): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getGpsLat(): ?float
    {
        return $this->gpsLat;
    }

    public function setGpsLat(float $gpsLat): self
    {
        $this->gpsLat = $gpsLat;

        return $this;
    }

    public function getGpsLng(): ?float
    {
        return $this->gpsLng;
    }

    public function setGpsLng(float $gpsLng): self
    {
        $this->gpsLng = $gpsLng;

        return $this;
    }

    public function getDepartmentCode(): ?string
    {
        return $this->departmentCode;
    }

    public function setDepartmentCode(string $departmentCode): self
    {
        $this->departmentCode = $departmentCode;

        return $this;
    }

    public function getPrice(): ?Prices
    {
        return $this->price;
    }

    public function setPrice(?Prices $price): self
    {
        $this->price = $price;

        // set (or unset) the owning side of the relation if necessary
        $newCity = $price === null ? null : $this;
        if ($newCity !== $price->getCity()) {
            $price->setCity($newCity);
        }

        return $this;
    }

    public function getPopulation(): ?Population
    {
        return $this->population;
    }

    public function setPopulation(?Population $population): self
    {
        $this->population = $population;

        // set (or unset) the owning side of the relation if necessary
        $newCity = $population === null ? null : $this;
        if ($newCity !== $population->getCity()) {
            $population->setCity($newCity);
        }

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
            $indicatorValue->setCity($this);
        }

        return $this;
    }

    public function removeIndicatorValue(IndicatorValue $indicatorValue): self
    {
        if ($this->indicatorValues->contains($indicatorValue)) {
            $this->indicatorValues->removeElement($indicatorValue);
            // set the owning side to null (unless already changed)
            if ($indicatorValue->getCity() === $this) {
                $indicatorValue->setCity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
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
        }

        return $this;
    }

    public function removeSearch(Search $search): self
    {
        if ($this->searches->contains($search)) {
            $this->searches->removeElement($search);
        }

        return $this;
    }

}
