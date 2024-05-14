<?php

namespace App\Controller;

use App\Entity\Restaurant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RestaurantController extends AbstractController
{
    #[Route('/restaurant/{id}', name: 'app_restaurant_record')]
    public function index(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/restaurant.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }
}
