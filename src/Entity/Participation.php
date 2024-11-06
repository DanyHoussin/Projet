<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipationRepository::class)]
class Participation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'participations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Character $chosenCharacter = null;

    #[ORM\ManyToOne(inversedBy: 'participations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?defi $defi = null;

    #[ORM\Column]
    private ?bool $achievement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getChosenCharacter(): ?Character
    {
        return $this->chosenCharacter;
    }

    public function setChosenCharacter(?Character $chosenCharacter): static
    {
        $this->chosenCharacter = $chosenCharacter;

        return $this;
    }

    public function getDefi(): ?defi
    {
        return $this->defi;
    }

    public function setDefi(?defi $defi): static
    {
        $this->defi = $defi;

        return $this;
    }

    public function isAchievement(): ?bool
    {
        return $this->achievement;
    }

    public function setAchievement(bool $achievement): static
    {
        $this->achievement = $achievement;

        return $this;
    }
}
