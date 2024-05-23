<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Customer;
use App\Entity\FoodType;
use App\Entity\Menu;
use App\Entity\MenuComposition;
use App\Entity\OpeningDays;
use App\Entity\Pictures;
use App\Entity\Plates;
use App\Entity\PriceRange;
use App\Entity\Restaurant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct()
    {}

    private const RESTO_NB = 30;

    private const PICTURES_NB = 120;

    private const PLATES_NB = 60;

    private const MENU_NB = 40;

    private const CUSTOMERS_NB = 40;

    private const FOOD_TYPES = ['Gastronomique', 'Italienne', 'Espagnole', 'Indienne', 'Chinoise', 'Thaïlandaise', 'Japonaise', 'Mexicaine', 'Africaine', 'Antillaise', 'Brésilienne', 'Végétarienne'];

    private const OPENING_LUNCH = [0, 127, 126, 63, 95];

    private const OPENING_DINNER = [127, 126, 63, 95];


    public function load(ObjectManager $manager): void
    {
        $fileList = file_get_contents('src/data/liste_villes.json');
        $villes = json_decode($fileList, true);

        $faker = \Faker\Factory::create();

        $foodTypes = [];
        $priceRanges = [];
        $customerUsers = [];
        $restaurantUsers = [];
        $cities = [];
        $restaurants = [];
        $menus = [];


        for ($i = 0; $i < self::RESTO_NB; $i++) {
            $city = new City();
            $j = $faker->numberBetween(0, count($villes));
            $city
                ->setName($villes[$j]['Nom_commune'])
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
            $priceRange->setPriceRange(intval($i+1));
            $priceRanges[] = $priceRange;
            $manager->persist($priceRange);
        }


        for ($i = 0; $i < SELF::CUSTOMERS_NB; $i++) {
            $customerUser = new User();
            $customerUser
                ->setEmail($faker->safeEmail())
                ->setRoles(['ROLE_COSTUMER'])
                ->setPassword('test');
            $customerUsers[] = $customerUser;
            $manager->persist($customerUser);
        }

       
        for ($i = 0; $i < SELF::CUSTOMERS_NB; $i++) {
            $customer = new Customer();
            $customer
                    ->setFirstname($faker->word())
                    ->setLastname($faker->word())
                    ->setPhone($faker->randomNumber(9, true))
                    ->setUser($customerUsers[$i]);
            $manager->persist($customer);
        }


        for ($i = 0; $i < SELF::RESTO_NB; $i++) {
            $restaurantUser = new User();
            $restaurantUser
                ->setEmail($faker->safeEmail())
                ->setRoles(['ROLE_RESTAURANT'])
                ->setPassword('test');
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
                ->setAddress($faker->randomElement(['Rue', 'Boulevard', 'Place']) . ' ' . $faker->word())
                ->setAddressNb($faker->randomNumber(2, false))
                ->setPhone($faker->randomNumber(9, true))
                ->setNotationTotal($faker->numberBetween(2, 5))
                ->setCapacityMax($faker->randomNumber(2, true))
                ->setSiretNb($faker->randomNumber(9, true))
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
            $menus[] = $menu;
            $manager->persist($menu);
        }
 
        for ($i = 0; $i < self::PLATES_NB; $i++)  {
            $composition = new MenuComposition();
            $composition->setMenu($faker->randomElement($menus));
            $composition->setName($faker->word());
            $manager->persist($composition);
        }


        for ($i = 0; $i < self::RESTO_NB; $i++)  {
            $opening = new OpeningDays();
            $opening
                    ->setMidi($faker->randomElement(self::OPENING_LUNCH))
                    ->setSoir($faker->randomElement(self::OPENING_DINNER))
                    ->setRestaurant($restaurants[$i]);
            $manager->persist($opening);
        }

        for ($i = 0; $i < self::PICTURES_NB; $i++) {
            $picture = new Pictures;
            $picture
                ->setFilename('restaurant-interior.jpg')
                ->setRestaurant($faker->randomElement($restaurants));
            $manager->persist($picture);
        }


        $regularUser = new User();
        $regularUser
            ->setEmail('john@doe.com')
            ->setRoles(['ROLE_CUSTOMER'])
            ->setPassword('test');
        $manager->persist($regularUser);


        $restaurantUser = new User();
        $restaurantUser
            ->setEmail('labonne@cuisine.com')
            ->setRoles(['ROLE_RESTAURANT'])
            ->setPassword('test');
        $manager->persist($restaurantUser);

        
        $adminUser = new User();
        $adminUser
            ->setEmail('admin@1001plates.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword('test');
        $manager->persist($adminUser);


        $manager->flush();
    }

}
