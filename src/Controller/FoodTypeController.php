<?php

namespace App\Controller;

use App\Entity\FoodType;
use App\Repository\FoodTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FoodTypeController extends AbstractController
{
    #[Route('/type_cuisine/{name}', name: 'app_food_type')]
    public function index(FoodTypeRepository $foodTypeRepository, FoodType $foodType): Response
    {
        $foodTypes = $foodTypeRepository->findAll();
        $restaurants = $foodType->getRestaurants();

        return $this->render('food_type/restaurantList.html.twig', [
            'restaurants' => $restaurants,
            'foodTypes' => $foodTypes
        ]);
    }
}
