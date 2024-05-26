<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\MenuComposition;
use App\Entity\Pictures;
use App\Entity\Plates;
use App\Entity\Restaurant;
use App\Files\UploadPicture;
use App\Form\MenuCompositionType;
use App\Form\MenusEditType;
use App\Form\PlatesEditType;
use App\Form\RestaurantPrivateEditType;
use App\Form\UploadPicturesRestaurantType;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/restaurant/private')]
class RestaurantPrivateController extends AbstractController
{
    public function __construct(private SecurityController $securityController) 
    {}


    #[Route('/accueil', name: 'app_restaurant_private_accueil', methods: ['GET'])]
    public function show(): Response
    {
        $user = $this->securityController->getUser();

        return $this->render('restaurant_private/accueil.html.twig', [
            'restaurant' => $user
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


    #[Route('/modification/pictures/{id}', name: 'app_restaurant_private_pictures', methods: ['GET', 'POST'])]
    public function editPictures(Request $request, Restaurant $restaurant, UploadPicture $uploadPicture, int $id): Response
    {
        $this->denyAccessUnlessGranted('RESTO_EDIT', $restaurant);     
        
        
        $form = $this->createForm(UploadPicturesRestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $files = $form->get('pictures')->getData();

            foreach ($files as $file) {
                $uploadPicture->uploadPicture($file, $restaurant, $form);
            }
               
                $this->addFlash('success', 'Chargement d\'image(s) réalisé');
                return $this->redirectToRoute('app_restaurant_private_pictures', ['id' => $id]);
            } 
            
        return $this->render('restaurant_private/addPictures.html.twig', [
            'form' => $form,
            'restaurant' => $restaurant
        ]);
    }


    #[Route('/modification/pictures/{id}/delete', name: 'app_restaurant_delete_picture', methods: ['POST'])]
    public function deletePicture(Pictures $picture, EntityManagerInterface $entityManager): Response
    {

        $restoId = $picture->getRestaurant()->getId();
        $entityManager->remove($picture);
        $entityManager->flush();
        
        $this->addFlash('success', 'L\'image a bien été supprimée');
        return $this->redirectToRoute('app_restaurant_private_pictures', ['id' => $restoId]);
    }


    #[Route('/modification/plates/{id}', name: 'app_restaurant_private_plates', methods: ['GET', 'POST'])]
    public function editPlates(Request $request, Restaurant $restaurant, EntityManagerInterface $entityManager, int $id): Response
    {
        $this->denyAccessUnlessGranted('RESTO_EDIT', $restaurant);     
        
        
        $form = $this->createForm(PlatesEditType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $plateName = $form->get('plates')->getData();

                $newPlate = new Plates();
                $newPlate->setName($plateName);
                $newPlate->setRestaurant($restaurant);
                $restaurant->addPlate($newPlate);
    
                $entityManager->persist($newPlate);
                $entityManager->persist($restaurant);
                $entityManager->flush();

                $this->addFlash('success', 'Votre plat a bien été rajouté');
                return $this->redirectToRoute('app_restaurant_private_plates', ['id' => $id]);
                        
            } 
            
        return $this->render('restaurant_private/editPlates.html.twig', [
            'form' => $form,
            'restaurant' => $restaurant
        ]);
    }

    #[Route('/modification/plates/{id}/delete', name: 'app_restaurant_delete_plate', methods: ['POST'])]
    public function deletePlates(Plates $plate, EntityManagerInterface $entityManager): Response
    {

        $restoId = $plate->getRestaurant()->getId();
        $entityManager->remove($plate);
        $entityManager->flush();
        
        $this->addFlash('success', 'Le plat a bien été supprimé');
        return $this->redirectToRoute('app_restaurant_private_plates', ['id' => $restoId]);
    }
    

    #[Route('/modification/menus/{id}', name: 'app_restaurant_private_menus', methods: ['GET', 'POST'])]
    public function editMenus(Request $request, Restaurant $restaurant, EntityManagerInterface $entityManager, int $id): Response
    {
        $this->denyAccessUnlessGranted('RESTO_EDIT', $restaurant);     
        
        $form = $this->createForm(MenusEditType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $menuName = $form->get('menus')->getData();

                $newMenu = new Menu();
                $newMenu->setName($menuName);
                $newMenu->setRestaurant($restaurant);
                $restaurant->addMenu($newMenu);
    
                $entityManager->persist($newMenu);
                $entityManager->persist($restaurant);
                $entityManager->flush();

                $this->addFlash('success', 'Votre menu a bien été rajouté');
                return $this->redirectToRoute('app_restaurant_private_menus', ['id' => $id]);
                        
            } 
            
        return $this->render('restaurant_private/editMenus.html.twig', [
            'form' => $form,
            'restaurant' => $restaurant
        ]);
    }


    #[Route('/modification/menus/{id}/delete', name: 'app_restaurant_delete_menu', methods: ['POST'])]
    public function deleteMenu(Menu $menu, EntityManagerInterface $entityManager): Response
    {

        $restoId = $menu->getRestaurant()->getId();
        $entityManager->remove($menu);
        $entityManager->flush();
        
        $this->addFlash('success', 'Le menu a bien été supprimé');
        return $this->redirectToRoute('app_restaurant_private_menus', ['id' => $restoId]);
    }


    #[Route('/modification/menus/{id}/composition', name: 'app_restaurant_private_menu_composition', methods: ['GET', 'POST'])]
    public function editMenuComposition(Request $request, Restaurant $restaurant, EntityManagerInterface $entityManager, MenuRepository $menuRepository, int $id): Response
    {
        $idMenu = $request->query->get('idMenu');
        $menu = $menuRepository->findOneBy(['id' => $idMenu]);

        $this->denyAccessUnlessGranted('RESTO_EDIT', $restaurant);
        $this->denyAccessUnlessGranted('MENU_EDIT', $menu);
             
        $form = $this->createForm(MenuCompositionType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $compositionName = $form->get('menuCompositions')->getData();

                $menuComposition = new MenuComposition();
                $menuComposition->setName($compositionName );
                $menuComposition->setMenu($menu);
                $menu->addMenuComposition($menuComposition);
    
                $entityManager->persist($menuComposition);
                $entityManager->persist($menu);
                $entityManager->flush();

                $this->addFlash('success', 'Votre nouveau plat a bien été rajouté');
                return $this->redirectToRoute('app_restaurant_private_menu_composition', ['id' => $id, 'idMenu' => $idMenu]);
                        
            } 
            
        return $this->render('restaurant_private/editMenuCompositions.html.twig', [
            'form' => $form,
            'menu' => $menu
        ]);
    }


    #[Route('/modification/composition/{id}/delete', name: 'app_restaurant_delete_composition', methods: ['POST'])]
    public function deleteComposition(MenuComposition $menuComposition, EntityManagerInterface $entityManager): Response
    {
        $nameMenu = $menuComposition->getMenu()->getName();
        $restoId = $menuComposition->getMenu()->getRestaurant()->getId();
        $entityManager->remove($menuComposition);
        $entityManager->flush();
        
        $this->addFlash('success', 'Le plat a bien été supprimé');
        return $this->redirectToRoute('app_restaurant_private_menu_composition', ['id' => $restoId, 'name' => $nameMenu]);
    }

}
