<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    #[Route('/profils', name: 'app_profils')]
    public function usersList(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'users' => $users,

        ]);
    }

    #[Route('/profil/{id}', name: 'show_profil')]
    public function userInfo(User $user): Response
    {
        return $this->render('profil/user.html.twig', [
            'controller_name' => 'ProfilController',
            'user' => $user,

        ]);
    }

    #[Route('/profil/delete/{id}', name: 'profil_delete', methods: ['POST', 'DELETE'])]
    public function deleteUser(Request $request, EntityManagerInterface $entityManager, User $user, Security $security): Response
    {
        if ($security->isGranted('ROLE_ADMIN') || $security->getUser() === $user) {
            $entityManager->remove($user);
            $entityManager->flush();

        $this->addFlash('success', 'Utilisateur supprimé avec succès');

        }
        return $this->redirectToRoute('app_profils');
    }
}

