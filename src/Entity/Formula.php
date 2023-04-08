<?php

namespace App\Entity;

use App\Repository\FormulaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormulaRepository::class)]
class Formula
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\Regex(
        pattern: '/^([a-zA-Z-\' ]){1,100}$/',
        message: 'Doit contenir des caractères alphabétiques,des tirets et des apostrophes'
    )]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^([a-zA-Z-\'() ]){1,100}$/',
        message: 'Doit contenir des caractères alphabétiques,des tirets et des apostrophes'
    )]
    private ?string $period = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    #[Assert\Regex(
        pattern: '/^\d{1,3}((,|.){1}\d{1,2})?$/',
        message: 'Ne peut contenir qu\'un nombre entier ou décimal'
    )]
    private ?string $price = null;

    #[ORM\ManyToOne(inversedBy: 'formulas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Menu $menu = null;

    public function getId(): ?int
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPeriod(): ?string
    {
        return $this->period;
    }

    public function setPeriod(string $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }
}
