<?php

namespace App\Entity;

use App\Repository\PriceRangeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PriceRangeRepository::class)]
class PriceRange
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $price_range = null;

    /**
     * @var Collection<int, Restaurant>
     */
    #[ORM\OneToMany(targetEntity: Restaurant::class, mappedBy: 'priceRange')]
    private Collection $restaurants;

    public function __construct()
    {
        $this->restaurants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriceRange(): ?int
    {
        return $this->price_range;
    }

    public function setPriceRange(int $price_range): static
    {
        $this->price_range = $price_range;

        return $this;
    }

    /**
     * @return Collection<int, Restaurant>
     */
    public function getRestaurants(): Collection
    {
        return $this->restaurants;
    }

    public function addRestaurant(Restaurant $restaurant): static
    {
        if (!$this->restaurants->contains($restaurant)) {
            $this->restaurants->add($restaurant);
            $restaurant->setPriceRange($this);
        }

        return $this;
    }

    public function removeRestaurant(Restaurant $restaurant): static
    {
        if ($this->restaurants->removeElement($restaurant)) {
            // set the owning side to null (unless already changed)
            if ($restaurant->getPriceRange() === $this) {
                $restaurant->setPriceRange(null);
            }
        }

        return $this;
    }
}
