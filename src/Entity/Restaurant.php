<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant extends User
{

    #[ORM\Column(length: 255)]
    #[Groups(['restaurant:read'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $phone = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $address_nb = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $notationTotal = null;

    #[ORM\Column]
    private ?int $capacityMax = null;

    #[ORM\ManyToOne(inversedBy: 'restaurants')]
    #[Groups(['restaurant:read'])]
    private ?FoodType $foodType = null;

    #[ORM\ManyToOne(inversedBy: 'restaurants')]
    private ?PriceRange $priceRange = null;

    #[ORM\ManyToOne(inversedBy: 'restaurants')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['restaurant:read'])]
    private ?City $city = null;

    #[ORM\Column]
    private ?int $siretNb = null;

    /**
     * @var Collection<int, Menu>
     */
    #[ORM\OneToMany(targetEntity: Menu::class, mappedBy: 'restaurant', cascade: ['remove'])]
    private Collection $menus;

    #[ORM\OneToOne(mappedBy: 'restaurant', cascade: ['persist', 'remove'])]
    private ?OpeningDays $openingDays = null;

    /**
     * @var Collection<int, Pictures>
     */
    #[ORM\OneToMany(targetEntity: Pictures::class, mappedBy: 'restaurant', cascade: ['remove'])]
    private Collection $pictures;

    /**
     * @var Collection<int, Plates>
     */
    #[ORM\OneToMany(targetEntity: Plates::class, mappedBy: 'restaurant', cascade: ['remove'])]
    private Collection $plates;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $OpeningHours = null;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->pictures = new ArrayCollection();
        $this->plates = new ArrayCollection();
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

    public function getAddressNb(): ?int
    {
        return $this->address_nb;
    }

    public function setAddressNb(int $address_nb): static
    {
        $this->address_nb = $address_nb;

        return $this;
    }

    public function getSiretNb(): ?int
    {
        return $this->siretNb;
    }

    public function setSiretNb(int $siretNb): static
    {
        $this->siretNb = $siretNb;

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

    public function getOpeningDays(): ?OpeningDays
    {
        return $this->openingDays;
    }

    public function setOpeningDays(OpeningDays $openingDays): static
    {
        // set the owning side of the relation if necessary
        if ($openingDays->getRestaurant() !== $this) {
            $openingDays->setRestaurant($this);
        }

        $this->openingDays = $openingDays;

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

    public function getOpeningHours(): ?string
    {
        return $this->OpeningHours;
    }

    public function setOpeningHours(?string $OpeningHours): static
    {
        $this->OpeningHours = $OpeningHours;

        return $this;
    }

}
