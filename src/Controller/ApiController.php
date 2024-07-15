<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    #[Route('/restaurants', name: 'restaurants')]
    public function articles(RestaurantRepository $restaurantRepository): Response
    {
        return $this->json(
            $restaurantRepository->findAll(),
            context: ['groups' => 'restaurant:read']
        );
    }
}

