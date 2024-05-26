<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\FoodType;
use App\Entity\PriceRange;
use App\Entity\Restaurant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantPrivateEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, ['label' => 'Nom du Restaurant'])
            ->add('description', null, ['label' => 'Description'])
            ->add('phone', null, ['label' => 'Numéro de téléphone'])
            ->add('opening_hours', null, ['label' => 'Horaires d\'ouverture'])
            ->add('address_nb', null, ['label' => 'Numéro de voie'])
            ->add('address', null, ['label' => 'Adresse'])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'label' => 'Ville'
            ])
            ->add('capacityMax', null, ['label' => 'Capacité maximale'])
            ->add('foodType', EntityType::class, [
                'class' => FoodType::class,
                'choice_label' => 'name',
                'label' => 'Type de cuisine'
            ])
            ->add('priceRange', EntityType::class, [
                'class' => PriceRange::class,
                'choice_label' => 'price_range',
                'label' => 'Prix moyen'
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
