<?php

namespace App\Event;

use App\Entity\Restaurant;
use Symfony\Contracts\EventDispatcher\Event;

class RestaurantDeleteEvent extends Event
{
    public const NAME = 'restaurant.delete';

    public function __construct(private Restaurant $restaurant)
    {
    }

    public function getRestaurant(): Restaurant
    {
        return $this->restaurant;
    }


}