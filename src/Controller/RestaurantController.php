<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RestaurantController extends AbstractController
{
    #[Route('/restaurants/{name}', name: 'app_restaurant_list')]
    public function restaurantListName(RestaurantRepository $restaurantRepository, Request $request): Response
    {
        $name = $request->get('name', '');

        if($name === '' || !isset($name))
        {
            $this->addFlash('warning', 'Désolé, le restaurant que vous cherchez n\'a pas été trouvé');
            return $this->redirectToRoute('app_index');
        }

        $restaurants = $restaurantRepository->findRestaurantByName($name);
        
        return $this->render('restaurant/restaurantList.html.twig', [
            'restaurants' => $restaurants,
            'name' => $name
        ]);
    }



    #[Route('/restaurant/{name}', name: 'app_restaurant_record')]
    public function restaurantItem(Restaurant $restaurant): Response
    {
        return $this->render('restaurant/restaurant.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }
}
