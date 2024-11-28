<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`character`')]
class Character
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $fightingStyle = null;

    #[ORM\Column(length: 255)]
    private ?string $nationality = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 0)]
    private ?string $height = null;

    #[ORM\Column]
    private ?int $weight = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $profilPhoto = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $history = null;

    /**
     * @var Collection<int, Blows>
     */
    #[ORM\OneToMany(targetEntity: Blows::class, mappedBy: 'chosenCharacter')]
    private Collection $blows;

    /**
     * @var Collection<int, Tutorial>
     */
    #[ORM\OneToMany(targetEntity: Tutorial::class, mappedBy: 'chosenCharacter')]
    private Collection $tutorials;

    public function __construct()
    {
        $this->blows = new ArrayCollection();
        $this->tutorials = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFightingStyle(): ?string
    {
        return $this->fightingStyle;
    }

    public function setFightingStyle(string $fightingStyle): static
    {
        $this->fightingStyle = $fightingStyle;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): static
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getProfilPhoto(): ?string
    {
        return $this->profilPhoto;
    }

    public function setProfilPhoto(string $profilPhoto): static
    {
        $this->profilPhoto = $profilPhoto;

        return $this;
    }

    public function getHistory(): ?string
    {
        return $this->history;
    }

    public function setHistory(string $history): static
    {
        $this->history = $history;

        return $this;
    }

    /**
     * @return Collection<int, Blows>
     */
    public function getBlows(): Collection
    {
        return $this->blows;
    }

    public function addBlow(Blows $blow): static
    {
        if (!$this->blows->contains($blow)) {
            $this->blows->add($blow);
            $blow->setChosenCharacter($this);
        }

        return $this;
    }

    public function removeBlow(Blows $blow): static
    {
        if ($this->blows->removeElement($blow)) {
            // set the owning side to null (unless already changed)
            if ($blow->getChosenCharacter() === $this) {
                $blow->setChosenCharacter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tutorial>
     */
    public function getTutorials(): Collection
    {
        return $this->tutorials;
    }

    public function addTutorial(Tutorial $tutorial): static
    {
        if (!$this->tutorials->contains($tutorial)) {
            $this->tutorials->add($tutorial);
            $tutorial->setChosenCharacter($this);
        }

        return $this;
    }

    public function removeTutorial(Tutorial $tutorial): static
    {
        if ($this->tutorials->removeElement($tutorial)) {
            // set the owning side to null (unless already changed)
            if ($tutorial->getChosenCharacter() === $this) {
                $tutorial->setChosenCharacter(null);
            }
        }

        return $this;
    }
}
