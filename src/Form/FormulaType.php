<?php

namespace App\Form;

use App\Entity\Formula;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormulaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description',  TextareaType::class)
            ->add('period', TextType::class)
            ->add('price', MoneyType::class, [
                'currency' => false,
            ])
            ->add('menu', EntityType::class, [
                'class' => 'App\Entity\Menu',
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formula::class,
        ]);
    }
}
//TODO : Formulaire de suppression des formules