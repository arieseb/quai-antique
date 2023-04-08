<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\User;
use App\Repository\RestaurantRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
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

    public function defaultGuests(): int
    {
        if ($this->token->getToken() !== null) {
            $user = $this->userRepository->findOneBy(['email' => $this->token->getToken()->getUserIdentifier()]);
            return $user->getDefaultGuests();
        } else {
            return 1;
        }
    }

    public function defaultAllergies(): ?string
    {
        if($this->token->getToken() !== null) {
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
            ->add('allergies', TextType::class, [
                'data' => $this->defaultAllergies(),
                'required' => false,
            ])
            ->add('guestNumber', NumberType::class, [
                'scale' => 0,
                'html5' => true,
                'data' => $this->defaultGuests(),
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
