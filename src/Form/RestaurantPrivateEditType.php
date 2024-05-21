<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\FoodType;
use App\Entity\PriceRange;
use App\Entity\Restaurant;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantPrivateEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('phone')
            ->add('address')
            ->add('notationTotal')
            ->add('capacityMax')
            ->add('address_nb')
            ->add('foodType', EntityType::class, [
                'class' => FoodType::class,
                'choice_label' => 'id',
            ])
            ->add('priceRange', EntityType::class, [
                'class' => PriceRange::class,
                'choice_label' => 'id',
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'id',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
