<?php

namespace App\Entity;

use App\Repository\DefiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DefiRepository::class)]
class Defi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $reward = null;

    /**
     * @var Collection<int, ParticipationDefi>
     */
    #[ORM\OneToMany(targetEntity: ParticipationDefi::class, mappedBy: 'defi', orphanRemoval: true)]
    private Collection $participationDefis;

    public function __construct()
    {
        $this->participationDefis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getReward(): ?string
    {
        return $this->reward;
    }

    public function setReward(string $reward): static
    {
        $this->reward = $reward;

        return $this;
    }

    /**
     * @return Collection<int, ParticipationDefi>
     */
    public function getParticipationDefis(): Collection
    {
        return $this->participationDefis;
    }

    public function addParticipationDefi(ParticipationDefi $participationDefi): static
    {
        if (!$this->participationDefis->contains($participationDefi)) {
            $this->participationDefis->add($participationDefi);
            $participationDefi->setDefi($this);
        }

        return $this;
    }

    public function removeParticipationDefi(ParticipationDefi $participationDefi): static
    {
        if ($this->participationDefis->removeElement($participationDefi)) {
            // set the owning side to null (unless already changed)
            if ($participationDefi->getDefi() === $this) {
                $participationDefi->setDefi(null);
            }
        }

        return $this;
    }
}
