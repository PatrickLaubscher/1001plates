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

}
