<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\OpeningDaysRepository;
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



    #[Route('/restaurant/{name}', name: 'app_restaurant_item')]
    public function restaurantItem(Restaurant $restaurant, OpeningDaysRepository $openingDaysRepository, $name): Response
    {
        $openingDays= $openingDaysRepository->findByRestaurantName($name);


        if($openingDays->getMidi() === 63){
            $midiOpeningList = str_split(decbin($openingDays->getMidi()));
            array_unshift($midiOpeningList, "0");
        } elseif ($openingDays->getMidi() === 0){
            $midiOpeningList = array_fill(0, 7, 0);
        } else {
            $midiOpeningList = str_split(decbin($openingDays->getMidi()));
        };
        
        if($openingDays->getSoir() === 63){
            $soirOpeningList = str_split(decbin($openingDays->getSoir()));
            array_unshift($soirOpeningList, "0");
        } else {
            $soirOpeningList = str_split(decbin($openingDays->getSoir()));
        };  

        

        return $this->render('restaurant/restaurant.html.twig', [
            'restaurant' => $restaurant,
            'midiOpening' => $midiOpeningList,
            'soirOpening' => $soirOpeningList
        ]);
    }
}
