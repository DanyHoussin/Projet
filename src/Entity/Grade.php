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
    private Collection $users;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'grade')]
    private Collection $usersList;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->usersList = new ArrayCollection();
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
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setGrade($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getGrade() === $this) {
                $user->setGrade(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsersList(): Collection
    {
        return $this->usersList;
    }

    public function addUsersList(User $usersList): static
    {
        if (!$this->usersList->contains($usersList)) {
            $this->usersList->add($usersList);
            $usersList->setGrade($this);
        }

        return $this;
    }

    public function removeUsersList(User $usersList): static
    {
        if ($this->usersList->removeElement($usersList)) {
            // set the owning side to null (unless already changed)
            if ($usersList->getGrade() === $this) {
                $usersList->setGrade(null);
            }
        }

        return $this;
    }
}
