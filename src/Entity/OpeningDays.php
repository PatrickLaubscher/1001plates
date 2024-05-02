<?php

namespace App\Entity;

use App\Repository\OpeningDaysRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpeningDaysRepository::class)]
class OpeningDays
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $midi = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $soir = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Restaurant $restaurant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMidi(): ?int
    {
        return $this->midi;
    }

    public function setMidi(int $midi): static
    {
        $this->midi = $midi;

        return $this;
    }

    public function getSoir(): ?int
    {
        return $this->soir;
    }

    public function setSoir(int $soir): static
    {
        $this->soir = $soir;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): static
    {
        $this->restaurant = $restaurant;

        return $this;
    }
}
