<?php

namespace App\Form;

use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateRestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('maxGuests', NumberType::class, [
                'scale' => 0,
                'html5' => true,
            ])
            ->add('noonOpeningHour', TimeType::class, [
                'input' => 'datetime',
                'with_minutes' => false
            ])
            ->add('noonClosingHour',TimeType::class, [
                'input' => 'datetime',
                'with_minutes' => false
            ])
            ->add('eveningOpeningHour', TimeType::class, [
                'input' => 'datetime',
                'with_minutes' => false
            ])
            ->add('eveningClosingHour',TimeType::class, [
                'input' => 'datetime',
                'with_minutes' => false
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
