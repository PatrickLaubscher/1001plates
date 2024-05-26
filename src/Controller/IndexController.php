<?php

namespace App\Controller;

use App\Form\GetCityNameType;
use App\Form\GetNameRestaurantType;
use App\Repository\FoodTypeRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(FoodTypeRepository $foodTypeRepository, RestaurantRepository $restaurantRepository, Request $request): Response
    {        

        $formRestoName = $this->createForm(GetNameRestaurantType::class);
        $formRestoName->handleRequest($request);

        if ($formRestoName->isSubmitted() && $formRestoName->isValid()) {

            $data = $formRestoName->getData();
            $name = $data['name'];

            return $this->redirectToRoute('app_restaurant_list', ['name' => $name]);

        }

        $formCityName = $this->createForm(GetCityNameType::class, null, ['method' => 'GET']);
        $formCityName->handleRequest($request);

        if ($formCityName->isSubmitted() && $formCityName->isValid()) {

            $data = $formCityName->getData();
            $city=$data['city'];

            return $this->redirectToRoute('app_index_city', ['cityName' => $city->getName()]);

        }

        $foodTypes = $foodTypeRepository->findAll();
        $page = $request->query->getInt('page', 1);
        $itemPerPage = 4;
        $restaurants = $restaurantRepository->paginateRestaurant($page, $itemPerPage);
        $maxPage = ceil($restaurants->getTotalItemCount() / $itemPerPage);


        return $this->render('index/index.html.twig', [
            'title' => 'Accueil',
            'formRestoName' => $formRestoName,
            'formCityName' => $formCityName,
            'restaurants' => $restaurants,
            'maxPage' => $maxPage,
            'page' => $page,
            'foodTypes' => $foodTypes
        ]);
    }


    #[Route('/ville/{cityName}', name: 'app_index_city')]

    public function indexCity(string $cityName, FoodTypeRepository $foodTypeRepository, RestaurantRepository $restaurantRepository, Request $request) 
    {

        $foodTypes = $foodTypeRepository->findAllByCity($cityName);
        $page = $request->query->getInt('page', 1);
        $itemPerPage = 4;
        $restaurants = $restaurantRepository->paginateRestaurantByCity($page, $itemPerPage, $cityName);
        $maxPage = ceil($restaurants->getTotalItemCount() / $itemPerPage);

        $formRestoName = $this->createForm(GetNameRestaurantType::class);
        $formRestoName->handleRequest($request);

        if ($formRestoName->isSubmitted() && $formRestoName->isValid()) {

            $data = $formRestoName->getData();
            $name = $data['name'];

            return $this->redirectToRoute('app_restaurant_list', ['name' => $name]);

        }

    
        return $this->render('index/index.html.twig', [
            'title' => $cityName,
            'restaurants' => $restaurants,
            'formRestoName' => $formRestoName,
            'maxPage' => $maxPage,
            'page' => $page,
            'foodTypes' => $foodTypes,
            'cityName' => $cityName
        ]);


    }

}
