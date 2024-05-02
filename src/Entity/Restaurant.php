<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $notationTotal = null;

    #[ORM\Column]
    private ?int $capacityMax = null;

    #[ORM\ManyToOne(inversedBy: 'restaurants')]
    private ?FoodType $foodType = null;

    #[ORM\ManyToOne(inversedBy: 'restaurants')]
    private ?PriceRange $priceRange = null;

    #[ORM\ManyToOne(inversedBy: 'restaurants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    /**
     * @var Collection<int, Menu>
     */
    #[ORM\OneToMany(targetEntity: Menu::class, mappedBy: 'restaurant')]
    private Collection $menus;

    /**
     * @var Collection<int, Plates>
     */
    #[ORM\OneToMany(targetEntity: Plates::class, mappedBy: 'restaurant')]
    private Collection $plates;

    /**
     * @var Collection<int, Pictures>
     */
    #[ORM\OneToMany(targetEntity: Pictures::class, mappedBy: 'restaurant')]
    private Collection $pictures;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->plates = new ArrayCollection();
        $this->pictures = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getNotationTotal(): ?int
    {
        return $this->notationTotal;
    }

    public function setNotationTotal(?int $notationTotal): static
    {
        $this->notationTotal = $notationTotal;

        return $this;
    }

    public function getCapacityMax(): ?int
    {
        return $this->capacityMax;
    }

    public function setCapacityMax(int $capacityMax): static
    {
        $this->capacityMax = $capacityMax;

        return $this;
    }

    public function getFoodType(): ?FoodType
    {
        return $this->foodType;
    }

    public function setFoodType(?FoodType $foodType): static
    {
        $this->foodType = $foodType;

        return $this;
    }

    public function getPriceRange(): ?PriceRange
    {
        return $this->priceRange;
    }

    public function setPriceRange(?PriceRange $priceRange): static
    {
        $this->priceRange = $priceRange;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): static
    {
        if (!$this->menus->contains($menu)) {
            $this->menus->add($menu);
            $menu->setRestaurant($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): static
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getRestaurant() === $this) {
                $menu->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Plates>
     */
    public function getPlates(): Collection
    {
        return $this->plates;
    }

    public function addPlate(Plates $plate): static
    {
        if (!$this->plates->contains($plate)) {
            $this->plates->add($plate);
            $plate->setRestaurant($this);
        }

        return $this;
    }

    public function removePlate(Plates $plate): static
    {
        if ($this->plates->removeElement($plate)) {
            // set the owning side to null (unless already changed)
            if ($plate->getRestaurant() === $this) {
                $plate->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pictures>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Pictures $picture): static
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setRestaurant($this);
        }

        return $this;
    }

    public function removePicture(Pictures $picture): static
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getRestaurant() === $this) {
                $picture->setRestaurant(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

}
