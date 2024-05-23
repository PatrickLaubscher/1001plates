<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\RestaurantPrivateEditType;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/restaurant/private')]
class RestaurantPrivateController extends AbstractController
{
    private $restaurantUser;
    public function __construct(private SecurityController $securityController) 
    {}


    #[Route('/accueil', name: 'app_restaurant_private_accueil', methods: ['GET'])]
    public function show(RestaurantRepository $restaurantRepository): Response
    {
        $user = $this->securityController->getUser();
        $this->restaurantUser = $restaurantRepository->findRestaurantByEmailUser($user->getUserIdentifier());

        return $this->render('restaurant_private/accueil.html.twig', [
            'restaurant' => $this->restaurantUser
        ]);
    }

    
    #[Route('/modification/{id}', name: 'app_restaurant_private_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Restaurant $restaurant, EntityManagerInterface $entityManager): Response
    {

        $this->denyAccessUnlessGranted('RESTO_EDIT', $restaurant);     

        $form = $this->createForm(RestaurantPrivateEditType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_restaurant_private_accueil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('restaurant_private/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form,
        ]);
    }


    #[Route('/delete', name: 'app_restaurant_private_delete', methods: ['POST'])]
    public function delete(Request $request, Restaurant $restaurant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restaurant->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($restaurant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_restaurant_private_accueil', [], Response::HTTP_SEE_OTHER);
    }
}
