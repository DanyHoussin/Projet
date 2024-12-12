<?php

namespace App\Service;

use App\Entity\User;

class UserService
{
    private GradeManager $gradeManager;

    public function __construct(GradeManager $gradeManager)
    {
        $this->gradeManager = $gradeManager;
    }

    public function addGradePoints(User $user, int $points): void
    {
        // Ajouter des points de grade
        $user->setGradePoint($user->getGradePoint() + $points);

        // Mettre à jour le grade via le GradeManager
        $this->gradeManager->updateUserGrade($user);
    }
}
