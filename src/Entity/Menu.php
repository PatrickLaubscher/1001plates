<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, MenuComposition>
     */
    #[ORM\OneToMany(targetEntity: MenuComposition::class, mappedBy: 'Menu')]
    private Collection $menuCompositions;

    #[ORM\ManyToOne(inversedBy: 'menus')]
    private ?Restaurant $restaurant = null;

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

    /**
     * @return Collection<int, MenuComposition>
     */
    public function getMenuCompositions(): Collection
    {
        return $this->menuCompositions;
    }

    public function addMenuComposition(MenuComposition $menuComposition): static
    {
        if (!$this->menuCompositions->contains($menuComposition)) {
            $this->menuCompositions->add($menuComposition);
            $menuComposition->setMenu($this);
        }

        return $this;
    }

    public function removeMenuComposition(MenuComposition $menuComposition): static
    {
        if ($this->menuCompositions->removeElement($menuComposition)) {
            // set the owning side to null (unless already changed)
            if ($menuComposition->getMenu() === $this) {
                $menuComposition->setMenu(null);
            }
        }

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
