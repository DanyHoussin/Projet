<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $pseudo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ["default" => "CURRENT_TIMESTAMP"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(type: Types::TEXT, options: ["default" => "../img/profil_icon.png"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?string $profilPhoto = null;

    #[ORM\Column]
    private bool $isVerified = false;

    /**
     * @var Collection<int, ParticipationTournoi>
     */
    #[ORM\OneToMany(targetEntity: ParticipationTournoi::class, mappedBy: 'user')]
    private Collection $participationTournois;

    /**
     * @var Collection<int, ParticipationDefi>
     */
    #[ORM\OneToMany(targetEntity: ParticipationDefi::class, mappedBy: 'user')]
    private Collection $participationDefis;

    #[ORM\Column(type: 'integer', options: ["default" => 0])]
    #[ORM\JoinColumn(nullable: false)]
    private ?int $gradePoint = 0;

    #[ORM\ManyToOne]
    private ?Character $favoriteCharacter = null;

    #[ORM\ManyToOne(inversedBy: 'User')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Grade $grade = null;

    /**
     * @var Collection<int, Badge>
     */
    #[ORM\ManyToMany(targetEntity: Badge::class, inversedBy: 'users')]
    private Collection $Badges;

    public function __construct()
    {
        $this->participationTournois = new ArrayCollection();
        $this->participationDefis = new ArrayCollection();
        $this->Badges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

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

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, ParticipationTournoi>
     */
    public function getParticipationTournois(): Collection
    {
        return $this->participationTournois;
    }

    public function addParticipationTournoi(ParticipationTournoi $participationTournoi): static
    {
        if (!$this->participationTournois->contains($participationTournoi)) {
            $this->participationTournois->add($participationTournoi);
            $participationTournoi->setUser($this);
        }

        return $this;
    }

    public function removeParticipationTournoi(ParticipationTournoi $participationTournoi): static
    {
        if ($this->participationTournois->removeElement($participationTournoi)) {
            // set the owning side to null (unless already changed)
            if ($participationTournoi->getUser() === $this) {
                $participationTournoi->setUser(null);
            }
        }

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
            $participationDefi->setUser($this);
        }

        return $this;
    }

    public function removeParticipationDefi(ParticipationDefi $participationDefi): static
    {
        if ($this->participationDefis->removeElement($participationDefi)) {
            // set the owning side to null (unless already changed)
            if ($participationDefi->getUser() === $this) {
                $participationDefi->setUser(null);
            }
        }

        return $this;
    }

    public function getGradePoint(): ?int
    {
        return $this->gradePoint;
    }

    public function setGradePoint(int $gradePoint): static
    {
        $this->gradePoint = $gradePoint;

        return $this;
    }

    public function getFavoriteCharacter(): ?Character
    {
        return $this->favoriteCharacter;
    }

    public function setFavoriteCharacter(?Character $favoriteCharacter): static
    {
        $this->favoriteCharacter = $favoriteCharacter;

        return $this;
    }

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(?Grade $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function updateGrade(EntityManagerInterface $entityManager): void
    {
        // Récupérez tous les grades ordonnés par points minimum requis
        $grades = $entityManager->getRepository(Grade::class)->findBy([], ['requiredPoints' => 'ASC']);

        foreach ($grades as $grade) {
            if ($this->gradePoint >= $grade->getRequiredPoints()) {
                $this->setGrade($grade);
            }
        }
    }

    /**
     * @return Collection<int, Badge>
     */
    public function getBadges(): Collection
    {
        return $this->Badges;
    }

    public function addBadge(Badge $badge): static
    {
        if (!$this->Badges->contains($badge)) {
            $this->Badges->add($badge);
        }

        return $this;
    }

    public function removeBadge(Badge $badge): static
    {
        $this->Badges->removeElement($badge);

        return $this;
    }

}
