<?php

namespace App\Controller;

use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CharacterController extends AbstractController
{
    #[Route('/listCharacters', name: 'app_character')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $characters = $entityManager->getRepository(Character::class)->findAll();
        return $this->render('character/index.html.twig', [
            'characters' => $characters
        ]);
    }

    #[Route('/character/{id}', name: 'show_character')]
    public function show(Character $character): Response
    {
        return $this->render('character/show.html.twig', [
            'character' => $character
        ]);
    }
}
