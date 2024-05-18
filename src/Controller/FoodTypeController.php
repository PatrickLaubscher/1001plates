<?php

namespace App\Controller;

use App\Entity\FoodType;
use App\Repository\FoodTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class FoodTypeController extends AbstractController
{
    #[Route('/type_cuisine/{name}', name: 'app_food_type')]
    public function foodType(FoodTypeRepository $foodTypeRepository, FoodType $foodType): Response
    {
        $foodTypes = $foodTypeRepository->findAll();
        $restaurants = $foodType->getRestaurants();

        return $this->render('food_type/restaurantList.html.twig', [
            'restaurants' => $restaurants,
            'foodTypes' => $foodTypes
        ]);
    }


    #[Route('{cityName}/type_cuisine/{name}', name: 'app_food_type_city')]
    public function foodTypeByCity(FoodTypeRepository $foodTypeRepository, FoodType $foodType, string $cityName): Response
    {
        $foodTypes = $foodTypeRepository->findAllByCity($cityName);
        $restaurants = $foodType->getRestaurants();

        return $this->render('food_type/restaurantList.html.twig', [
            'restaurants' => $restaurants,
            'foodTypes' => $foodTypes
        ]);
    }

}
