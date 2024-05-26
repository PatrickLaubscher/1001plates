<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\FoodType;
use App\Entity\OpeningDays;
use App\Entity\PriceRange;
use App\Entity\Restaurant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewRestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom du Restaurant'])
            ->add('email', EmailType::class, ['label' => 'Email du restaurant'])
            ->add('password', PasswordType::class, ['label' => 'Votre mot de passe'])
            ->add('siretNb', TextType::class, ['label' => 'Numéro de siret'])
            ->add('phone', TextType::class, ['label' => 'Numéro téléphone'])
            ->add('address_nb', TextType::class, ['label' => 'Numéro de voie'])
            ->add('address', TextType::class, ['label' => 'Type et nom de la voie'])
            ->add('description', TextareaType::class, ['label' => 'Quelques mots sur votre restaurant'])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'label' => 'Ville'
            ])
            ->add('capacityMax', TextType::class, ['label' => 'Votre nombre de couverts'])
            ->add('OpeningHours', TextType::class, ['label' => 'Vos horaires d\'ouverture'])
            ->add('foodType', EntityType::class, [
                'class' => FoodType::class,
                'choice_label' => 'name',
                'label' => 'Type de cuisine'
            ])
            ->add('priceRange', EntityType::class, [
                'class' => PriceRange::class,
                'choice_label' => 'price_range',
                'label' => 'Prix moyen de 1 à 5'
            ])
            ->add('openingDays', EntityType::class, [
                'class' => OpeningDays::class,
                'choice_label' => 'id',
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
