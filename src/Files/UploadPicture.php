<?php

namespace App\Files;

use App\Entity\Pictures;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\PicturesRepository;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;

class UploadPicture {

    public function __construct(
        private SluggerInterface $slugger,
        private RestaurantRepository $restaurantRepository,
        private PicturesRepository $picturesRepository,
        private EntityManagerInterface $em,
    ) {
    }


    /**
     * 
     * 
     */
    public function uploadPicture (UploadedFile $file, object $restaurant, object $form): void 
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newfilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {

            $file->move(
                'uploads/pictures/',
                $newfilename
            );
            
            $restaurantPicturesList = $restaurant->getPictures();
            $isDuplicate = false;
            foreach ($restaurantPicturesList as $picture)
            if (str_contains($picture->getFilename(), $safeFilename)) {
                unlink(__DIR__ . "/../../public/uploads/pictures/" . $picture->getFilename());
                $isDuplicate = true;
            }

            if($isDuplicate == true) {

                $picture->setFilename($newfilename);
                $picture->setRestaurant($restaurant);
                $restaurant->addPicture($picture);
    
                $this->em->persist($picture);
                $this->em->persist($restaurant);
                $this->em->flush();

            } else {

                $newPicture = new Pictures();
                $newPicture->setFilename($newfilename);
                $newPicture->setRestaurant($restaurant);
                $restaurant->addPicture($newPicture);
    
                $this->em->persist($newPicture);
                $this->em->persist($restaurant);
                $this->em->flush();

            }


        } catch (FileException $e) {
            $form->addError(new FormError("Erreur lors de l'upload du fichier"));
        }
      

    }


}