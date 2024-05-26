<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\NewRestaurantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function indexRegister(): Response
    {
        return $this->render('register/indexRegister.html.twig', [
            'title' => 'Créer un compte'
        ]);
    }


    #[Route('/register/new_restaurant', name: 'app_register_restaurant')]
    public function restaurantRegister(Request $request, EntityManagerInterface $entityManager): Response
    {
        $restaurant = new Restaurant;
        $form = $this->createForm(NewRestaurantType::class, $restaurant);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $restaurant = $form->getData();

            $restaurant->setRoles(['ROLE_RESTAURANT']);

            $entityManager->persist($restaurant);
            $entityManager->flush();

            $this->addFlash('success', 'Votre compte restaurant a bien été créé');
            return $this->redirectToRoute('app_register_success');           
        } 
        
        return $this->render('register/newRestaurantRegister.html.twig', [
            'title' => 'Nouveau restaurant',
            'form' => $form,
        ]);
    }


    #[Route('/register/new_customer', name: 'app_register_customer')]
    public function customerRegister(): Response
    {


        return $this->render('register/newCustomerRegister.html.twig', [
            'title' => 'Nouveau client'
        ]);
    }


    #[Route('/register/success', name: 'app_register_success')]
    public function RegisterSucess(): Response
    {
        return $this->render('register/registerSuccess.html.twig', [
            'title' => 'Nouveau compte créé'
        ]);
    }
}
