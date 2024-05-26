<?php

namespace App\EventListener;

use App\Event\RestaurantDeleteEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


final class RestaurantDeleteListener
{

    public function __construct(private EntityManagerInterface $entityManager, private Filesystem $filesystem)
    {}


    #[AsEventListener(event: 'RestaurantDeleteEvent')]
    public function onRestaurantDeleteEvent($event): void
    {
        
        $restaurant = $event->getRestaurant();
        $pictures = $restaurant->getPictures();

        foreach ($pictures as $picture) {

            $this->filesystem->remove(__DIR__ . "/../../public/uploads/pictures/" . $picture->getFilename());
            
            $this->entityManager->remove($picture);
        }

        $this->entityManager->flush();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RestaurantDeleteEvent::NAME => 'onRestaurantDeleteEvent'
        ];
    }

}
