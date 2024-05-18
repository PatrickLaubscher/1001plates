<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/restaurant/edit/')]
class RestaurantCrudController extends AbstractController
{
    private $restaurantUser;
    public function __construct(private SecurityController $securityController, private RestaurantRepository $restaurantRepository) 
    {
        $this->restaurantRepository = $restaurantRepository;
        $user = $this->securityController->getUser();
        $this->restaurantUser = $this->restaurantRepository->findRestaurantByEmailUser($user->getUserIdentifier());

    }


    #[Route('/', name: 'app_restaurant_crud_show', methods: ['GET'])]
    public function show(): Response
    {
        return $this->render('restaurant_crud/show.html.twig', [
            'restaurant' => $this->restaurantUser
        ]);
    }

    #[Route('/edit', name: 'app_restaurant_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Restaurant $restaurant, EntityManagerInterface $entityManager): Response
    {
        $restaurant = new Restaurant;
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_restaurant_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('restaurant_crud/edit.html.twig', [
            'restaurant' => $this->restaurantUser,
            'form' => $form,
        ]);
    }

    #[Route('/delete', name: 'app_restaurant_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Restaurant $restaurant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restaurant->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($restaurant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_restaurant_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
