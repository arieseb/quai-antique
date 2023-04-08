<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThanOrEqual(
        value :'today',
        message: 'Impossible de réserver une date déjà passée'
    )]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $noonBookingTime = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\Column]
    #[Assert\Positive(
        message: 'Vous devez saisir une valeur positive'
    )]
    private ?int $guestNumber = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $eveningBookingTime = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BookingDate $bookingDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $allergies = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNoonBookingTime(): ?\DateTimeInterface
    {
        return $this->noonBookingTime;
    }

    public function setNoonBookingTime(\DateTimeInterface $noonBookingTime): self
    {
        $this->noonBookingTime = $noonBookingTime;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getGuestNumber(): ?int
    {
        return $this->guestNumber;
    }

    public function setGuestNumber(int $guestNumber): self
    {
        $this->guestNumber = $guestNumber;

        return $this;
    }

    public function getEveningBookingTime(): ?\DateTimeInterface
    {
        return $this->eveningBookingTime;
    }

    public function setEveningBookingTime(\DateTimeInterface $eveningBookingTime): self
    {
        $this->eveningBookingTime = $eveningBookingTime;

        return $this;
    }

    public function getBookingDate(): ?BookingDate
    {
        return $this->bookingDate;
    }

    public function setBookingDate(?BookingDate $bookingDate): self
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    public function getAllergies(): ?string
    {
        return $this->allergies;
    }

    public function setAllergies(?string $allergies): self
    {
        $this->allergies = $allergies;

        return $this;
    }
}
