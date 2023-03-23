<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV7 as Uuid;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = 'Le Quai Antique';

    #[ORM\Column]
    private ?int $maxGuests = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $businessDays = [];

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $noonOpeningHour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $noonClosingHour = null;

//    #[ORM\Column]
//    private ?int $currentGuests = 0;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $eveningOpeningHour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $eveningClosingHour = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMaxGuests(): ?int
    {
        return $this->maxGuests;
    }

    public function setMaxGuests(int $maxGuests): self
    {
        $this->maxGuests = $maxGuests;

        return $this;
    }

    public function getBusinessDays(): array
    {
        return $this->businessDays;
    }

    public function setBusinessDays(array $businessDays): self
    {
        $this->businessDays = $businessDays;

        return $this;
    }

    public function getNoonOpeningHour(): ?\DateTimeInterface
    {
        return $this->noonOpeningHour;
    }

    public function setNoonOpeningHour(\DateTimeInterface $noonOpeningHour): self
    {
        $this->noonOpeningHour = $noonOpeningHour;

        return $this;
    }

    public function getNoonClosingHour(): ?\DateTimeInterface
    {
        return $this->noonClosingHour;
    }

    public function setNoonClosingHour(\DateTimeInterface $noonClosingHour): self
    {
        $this->noonClosingHour = $noonClosingHour;

        return $this;
    }

//    public function getCurrentGuests(): ?int
//    {
//        return $this->currentGuests;
//    }
//
//    public function setCurrentGuests(int $currentGuests): self
//    {
//        $this->currentGuests = $currentGuests;
//
//        return $this;
//    }

    public function getEveningOpeningHour(): ?\DateTimeInterface
    {
        return $this->eveningOpeningHour;
    }

    public function setEveningOpeningHour(\DateTimeInterface $eveningOpeningHour): self
    {
        $this->eveningOpeningHour = $eveningOpeningHour;

        return $this;
    }

    public function getEveningClosingHour(): ?\DateTimeInterface
    {
        return $this->eveningClosingHour;
    }

    public function setEveningClosingHour(\DateTimeInterface $eveningClosingHour): self
    {
        $this->eveningClosingHour = $eveningClosingHour;

        return $this;
    }
}
