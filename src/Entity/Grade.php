<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $gradeName = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $icon = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'grade')]
    private Collection $User;

    #[ORM\Column]
    private ?int $requiredPoints = null;

    public function __construct()
    {
        $this->User = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGradeName(): ?string
    {
        return $this->gradeName;
    }

    public function setGradeName(string $gradeName): static
    {
        $this->gradeName = $gradeName;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): static
    {
        if (!$this->User->contains($user)) {
            $this->User->add($user);
            $user->setGrade($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->User->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getGrade() === $this) {
                $user->setGrade(null);
            }
        }

        return $this;
    }

    public function getRequiredPoints(): ?int
    {
        return $this->requiredPoints;
    }

    public function setRequiredPoints(int $requiredPoints): static
    {
        $this->requiredPoints = $requiredPoints;

        return $this;
    }
}
