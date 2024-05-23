<?php

namespace App\Controller;

use App\Entity\FoodType;
use App\Form\GetCityNameType;
use App\Repository\FoodTypeRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class FoodTypeController extends AbstractController
{
    #[Route('/type_cuisine/{name}', name: 'app_food_type')]
    public function foodType(FoodTypeRepository $foodTypeRepository, FoodType $foodType, Request $request): Response
    {
        $foodTypes = $foodTypeRepository->findAll();
        $restaurants = $foodType->getRestaurants();

        $formCityName = $this->createForm(GetCityNameType::class, null, ['method' => 'GET']);
        $formCityName->handleRequest($request);

        if ($formCityName->isSubmitted() && $formCityName->isValid()) {

            $data = $formCityName->getData();
            $city=$data['city'];

            return $this->redirectToRoute('app_index_city', ['cityName' => $city->getName()]);

        }


        return $this->render('food_type/restaurantList.html.twig', [
            'restaurants' => $restaurants,
            'foodTypes' => $foodTypes,
            'formCityName' => $formCityName
        ]);
    }


    #[Route('{cityName}/type_cuisine/{name}', name: 'app_food_type_city')]
    public function foodTypeByCity(FoodTypeRepository $foodTypeRepository, RestaurantRepository $restaurantRepository, string $cityName, string $name): Response
    {

        $foodTypes = $foodTypeRepository->findAllByCity($cityName);
        $restaurants = $restaurantRepository->findAllRestaurantByCityAndFoodType($cityName, $name);

        return $this->render('food_type/restaurantList.html.twig', [
            'restaurants' => $restaurants,
            'foodTypes' => $foodTypes
        ]);
    }

}
