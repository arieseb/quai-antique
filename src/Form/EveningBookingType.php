<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\User;
use App\Repository\RestaurantRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EveningBookingType extends AbstractType
{
    private RestaurantRepository $restaurantRepository;
    private TokenStorageInterface $token;

    public function __construct(RestaurantRepository $restaurantRepository, TokenStorageInterface $token)
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->token = $token;
    }

    public function eveningHours(): array
    {
        $restaurant = $this->restaurantRepository->findOneBy(['name' => 'Le Quai Antique']);
        $eveningHours = [];
        $open = $restaurant->getEveningOpeningHour()->format('H');
        $close = $restaurant->getEveningClosingHour()->format('H');
        for ($i = $open; $i < $close; $i++) {
            $eveningHours[] = $i;
        }
        return $eveningHours;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bookingDate', DateType::class, [
                'widget' => 'single_text',
                'input' => 'datetime',
            ])
            ->add('eveningBookingTime', TimeType::class, [
                'input' => 'datetime',
                'widget' => 'choice',
                'minutes' => [00, 15, 30, 45],
                'hours' =>  $this->eveningHours(),
            ])
//            ->add('allergies', CollectionType::class, [
//                'entry_type' => AllergyType::class,
//            ])
            ->add('guestNumber', NumberType::class, [
                'scale' => 0,
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
                'empty_data' => $this->token->getToken()->getUser()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
