<?php

namespace App\Entity;

use App\Repository\MenuCompositionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuCompositionRepository::class)]
class MenuComposition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'menuCompositions')]
    private ?Menu $Menu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->Menu;
    }

    public function setMenu(?Menu $Menu): static
    {
        $this->Menu = $Menu;

        return $this;
    }
}
