<?php

namespace App\Form;

use App\Entity\Booking;
use App\Repository\RestaurantRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function __construct(RestaurantRepository $restaurantRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
    }

    public function noonHours(): array
    {
        $restaurant = $this->restaurantRepository->findOneBy(['name' => 'Le Quai Antique']);
        $noonHours = [];
        $open = $restaurant->getNoonOpeningHour()->format('H');
        $close = $restaurant->getNoonClosingHour()->format('H');
        for ($i = $open; $i < $close; $i++) {
            $noonHours[] = $i;
        }
        return $noonHours;
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
            ->add('noonBookingTime', TimeType::class, [
                'input' => 'datetime',
                'widget' => 'choice',
                'minutes' => [00, 15, 30, 45],
                'hours' =>  $this->noonHours(),
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
