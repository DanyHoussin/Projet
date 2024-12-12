<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\GradeRepository;
use Doctrine\ORM\EntityManagerInterface;

class GradeManager
{
    private GradeRepository $gradeRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(GradeRepository $gradeRepository, EntityManagerInterface $entityManager)
    {
        $this->gradeRepository = $gradeRepository;
        $this->entityManager = $entityManager;
    }

    public function updateUserGrade(User $user): void
    {
        // Récupérer tous les grades triés par points requis (ascendant)
        $grades = $this->gradeRepository->findBy([], ['requiredPoints' => 'ASC']);

        // Trouver le grade correspondant
        foreach ($grades as $grade) {
            if ($user->getGradePoint() >= $grade->getRequiredPoints()) {
                $user->setGrade($grade);
            }
        }

        // Sauvegarder l'utilisateur
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
