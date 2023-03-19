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
    private ?\DateTimeInterface $openingHour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closingHour = null;

    #[ORM\Column]
    private ?int $currentGuests = 0;

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

    public function getOpeningHour(): ?\DateTimeInterface
    {
        return $this->openingHour;
    }

    public function setOpeningHour(\DateTimeInterface $openingHour): self
    {
        $this->openingHour = $openingHour;

        return $this;
    }

    public function getClosingHour(): ?\DateTimeInterface
    {
        return $this->closingHour;
    }

    public function setClosingHour(\DateTimeInterface $closingHour): self
    {
        $this->closingHour = $closingHour;

        return $this;
    }

    public function getCurrentGuests(): ?int
    {
        return $this->currentGuests;
    }

    public function setCurrentGuests(int $currentGuests): self
    {
        $this->currentGuests = $currentGuests;

        return $this;
    }
}
