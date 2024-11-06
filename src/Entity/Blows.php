<?php

namespace App\Entity;

use App\Repository\BlowsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlowsRepository::class)]
class Blows
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $movelist = null;

    #[ORM\ManyToOne(inversedBy: 'blows')]
    #[ORM\JoinColumn(nullable: false)]
    private ?character $chosenCharacter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMovelist(): ?string
    {
        return $this->movelist;
    }

    public function setMovelist(string $movelist): static
    {
        $this->movelist = $movelist;

        return $this;
    }

    public function getChosenCharacter(): ?character
    {
        return $this->chosenCharacter;
    }

    public function setChosenCharacter(?character $chosenCharacter): static
    {
        $this->chosenCharacter = $chosenCharacter;

        return $this;
    }
}
