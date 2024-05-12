<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Customer;
use App\Entity\FoodType;
use App\Entity\Menu;
use App\Entity\Plates;
use App\Entity\PriceRange;
use App\Entity\Restaurant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {}

    private const RESTO_NB = 50;

    private const PLATES_NB = 80;

    private const MENU_NB = 60;

    private const FOOD_TYPES = ['Gastronomique', 'Italienne', 'Espagnole', 'Indienne', 'Chinoise', 'Thaïlandaise', 'Japonaise', 'Mexicaine', 'Africaine', 'Antillaise', 'Brésilienne', 'Végétarienne'];

    private const CUSTOMERS_NB = 30;

    public function load(ObjectManager $manager): void
    {
        $fileList = file_get_contents('../data/liste_ville.json');
        $villes = json_decode($fileList, true);

        $faker = \Faker\Factory::create();

        $foodTypes = [];
        $priceRanges = [];
        $customerUsers = [];
        $restaurantUsers = [];
        $cities = [];
        $restaurants = [];


        for ($i = 0; $i < self::RESTO_NB; $i++) {
            $city = new City();
            $j = $faker->randomNumber(0, count($villes));
            $city
                ->setName($villes[$j]['Nom_commune'] )
                ->setCp($villes[$j]['Code_postal']);
            $cities[]=$city;
            $manager->persist($city);
        }
        

        foreach(self::FOOD_TYPES as $foodTypeName) {
            $foodType = new FoodType();
            $foodType->setName($foodTypeName);
            $foodTypes[] = $foodType;
            $manager->persist($foodType);
        }

        for ($i = 0; $i < 5; $i++)  {
            $priceRange = new PriceRange();
            $priceRange->setPriceRange($i);
            $priceRanges[] = $priceRange;
            $manager->persist($priceRange);
        }


        for ($i = 0; $i < SELF::CUSTOMERS_NB; $i++) {
            $customerUser = new User();
            $customerUser
                ->setEmail($faker->safeEmail())
                ->setRoles(['ROLE_COSTUMER'])
                ->setPassword($this->hasher->hashPassword($customerUser, 'test'));
            $customerUsers[] = $customerUser;
            $manager->persist($customerUser);
        }

       
        for ($i = 0; $i < SELF::CUSTOMERS_NB; $i++) {
            $customer = new Customer();
            $customer
                    ->setFirstname($faker->word())
                    ->setLastname($faker->word())
                    ->setUser($customerUsers[$i]);
            $manager->persist($customer);
        }


        for ($i = 0; $i < SELF::RESTO_NB; $i++) {
            $restaurantUser = new User();
            $restaurantUser
                ->setEmail($faker->safeEmail())
                ->setRoles(['ROLE_RESTAURANT'])
                ->setPassword($this->hasher->hashPassword($restaurantUser, 'test'));
            $restaurantUsers[] = $restaurantUser;
            $manager->persist($restaurantUser);
        }

        for($i = 0; $i < self::RESTO_NB; $i++) {
            $restaurant = new Restaurant();
            $restaurant
                ->setName($faker->word())
                ->setDescription($faker->paragraph())
                ->setFoodType($faker->randomElement($foodTypes))
                ->setPriceRange($faker->randomElement($priceRanges))
                ->setCity($faker->randomElement($cities))
                ->setAddress($faker->randomNumber(2, false). $faker->randomElement(['Rue', 'Boulevard', 'Place']) . $faker->word())
                ->setPhone('0' . $faker->randomNumber(9, true))
                ->setNotationTotal($faker->numberBetween(2, 5))
                ->setCapacityMax($faker->randomNumber(2, false))
                ->setUser($restaurantUsers[$i]);
            $restaurants[] = $restaurant;
            $manager->persist($restaurant);
        }

        
        for ($i = 0; $i < self::PLATES_NB; $i++)  {
            $plate = new Plates();
            $plate->setName($faker->word());
            $plate->setRestaurant($faker->randomElement($restaurants));
            $manager->persist($plate);
        }


        for ($i = 0; $i < self::MENU_NB; $i++)  {
            $menu = new Menu();
            $menu->setName($faker->word());
            $menu->setRestaurant($faker->randomElement($restaurants));
            $manager->persist($menu);
        }




        $regularUser = new User();
        $regularUser
            ->setEmail('john@doe.com')
            ->setRoles(['ROLE_CUSTOMER'])
            ->setPassword($this->hasher->hashPassword($regularUser, 'test'));

        $manager->persist($regularUser);


        $restaurantUser = new User();
        $restaurantUser
            ->setEmail('labonne@cuisine.com')
            ->setRoles(['ROLE_RESTAURANT'])
            ->setPassword($this->hasher->hashPassword($restaurantUser, 'test'));

        $manager->persist($restaurantUser);

        
        $adminUser = new User();
        $adminUser
            ->setEmail('admin@1001plates.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->hasher->hashPassword($adminUser, 'test'));

        $manager->persist($adminUser);


        $manager->flush();
    }

}
