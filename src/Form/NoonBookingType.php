<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\User;
use App\Repository\RestaurantRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NoonBookingType extends AbstractType
{
    private RestaurantRepository $restaurantRepository;
    private UserRepository $userRepository;
    private TokenStorageInterface $token;

    public function __construct(RestaurantRepository $restaurantRepository, TokenStorageInterface $token, UserRepository $userRepository)
    {
        $this->restaurantRepository = $restaurantRepository;
        $this->userRepository= $userRepository;
        $this->token = $token;
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

    public function defaultGuests(): int
    {
        if ($this->token->getToken()->getUser() !== null) {
            $user = $this->userRepository->findOneBy(['email' => $this->token->getToken()->getUserIdentifier()]);
            return $user->getDefaultGuests();
        } else {
            return 1;
        }
    }

    public function defaultAllergies(): ?string
    {
        if($this->token->getToken()->getUser() !== null) {
            $user = $this->userRepository->findOneBy(['email' => $this->token->getToken()->getUserIdentifier()]);
            return $user->getAllergies();
        } else {
            return null;
        }
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date',DateType::class, [
                'widget' => 'single_text',
                'input' => 'datetime',
                'data' => new \DateTime(),
            ])
            ->add('noonBookingTime', TimeType::class, [
                'input' => 'datetime',
                'widget' => 'choice',
                'minutes' => [00, 15, 30, 45],
                'hours' =>  $this->noonHours(),
            ])
            ->add('allergies', TextType::class, [
                'data' => $this->defaultAllergies(),
            ])
            ->add('guestNumber', NumberType::class, [
                'scale' => 0,
                'data' => $this->defaultGuests(),
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
                'data' => $this->token->getToken()->getUser()
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
