<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Character;
use App\Form\EditProfilType;
use App\Service\UserService;
use App\Form\EditGradePointType;
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
    public function userInfo(User $user, EntityManagerInterface $entityManager): Response
    {
        $favoriteCharacter = null;
        if ($user->getFavoriteCharacter()) {
            $favoriteCharacter = $user->getFavoriteCharacter();
        }
        return $this->render('profil/user.html.twig', [
            'user' => $user,
            'favoriteCharacter' => $favoriteCharacter,

        ]);
    }

    #[Route('/monprofil', name: 'show_myprofil')]
    public function myUserInfo(Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = $security->getUser();

        $favoriteCharacter = null;
        if ($user->getFavoriteCharacter()) {
            $favoriteCharacter = $entityManager->getRepository(Character::class)->find($user->getFavoriteCharacter());
        }
        return $this->render('profil/user.html.twig', [
            'user' => $user,
            'favoriteCharacter' => $favoriteCharacter,
        ]);
    }

    #[Route('/editProfil', name: 'edit_myprofil')]
    public function editUserInfo(Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = $security->getUser();

        $formEditProfil = $this->createForm(EditProfilType::class, $user);
        $formEditProfil->handleRequest($request);

        if ($formEditProfil->isSubmitted() && $formEditProfil->isValid()) {
            
            // Sauvegarder dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('show_myprofil');
        }
        $user = $security->getUser();
        return $this->render('profil/editUser.html.twig', [
            'editProfil' => $formEditProfil->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/profil/{id}/editGradePoint', name: 'edit_gradePoint')]
    public function editGradePoint(Request $request, Security $security, UserService $userService, EntityManagerInterface $entityManager, User $user): Response
    {

        $formEditGradePoint = $this->createForm(EditGradePointType::class, $user);
        $formEditGradePoint->handleRequest($request);

        if ($formEditGradePoint->isSubmitted() && $formEditGradePoint->isValid()) {
            
            // Sauvegarder dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            $userService->addGradePoints($user, 0);

            return $this->redirectToRoute('show_profil', ['id' => $user->getId()]);
        }
        return $this->render('profil/editGradePoint.html.twig', [
            'editGradePoint' => $formEditGradePoint->createView(),
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

