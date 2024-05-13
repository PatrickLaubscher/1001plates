<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(RestaurantRepository $restaurantRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $itemPerPage = 4;
        $restaurants = $restaurantRepository->paginateRestaurant($page, $itemPerPage);
        $maxPage = ceil($restaurants->getTotalItemCount() / $itemPerPage);

        return $this->render('index/index.html.twig', [
            'controller_name' => 'Accueil',
            'restaurants' => $restaurants,
            'maxPage' => $maxPage,
            'page' => $page
        ]);
    }
}
