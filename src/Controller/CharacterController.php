<?php

namespace App\Controller;

use App\Entity\Blows;
use App\Entity\Character;
use App\Form\AddBlowsType;
use App\Form\NewCharacterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
            'character' => $character,
            'blows' => $character->getBlows()
        ]);
    }

    #[Route('/character/{id}/addBlows', name: 'addBlows_character')]
    public function addBlowsForCharacter(Request $request, EntityManagerInterface $entityManager, Character $character): Response
    {

        $blows = new Blows();
        $blows->setChosenCharacter($character);
        $formAddBlows = $this->createForm(AddBlowsType::class, $blows, [
            'character' => $character, // Passez le personnage dans les options du formulaire
        ]);
        $formAddBlows->handleRequest($request);

        if ($formAddBlows->isSubmitted() && $formAddBlows->isValid()) {
            

            $entityManager->persist($blows);
            $entityManager->flush();

            return $this->redirectToRoute('show_character', ['id' => $character->getId()]);
        }

        return $this->render('character/addBlowsForCharacter.html.twig', [
            'addBlows' => $formAddBlows->createView(),
            'character' => $character,
        ]);
    }

    #[Route('/newCharacter', name: 'add_character')]
    public function newCharacter(Request $request, EntityManagerInterface $entityManager): Response
    {
        $character = new Character();
    
        $formCharacter = $this->createForm(NewCharacterType::class, $character);
        $formCharacter->handleRequest($request);
    
        if ($formCharacter->isSubmitted() && $formCharacter->isValid()) {
            
            // Sauvegarder dans la base de données
            $entityManager->persist($character);
            $entityManager->flush();

            return $this->redirectToRoute('app_character');
        }
    
        return $this->render('character/newCharacter.html.twig', [
            'newCharacter' => $formCharacter->createView(),
        ]);
    }

}
