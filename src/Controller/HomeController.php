<?php

namespace App\Controller;

use App\Entity\Character;
use App\Service\SteamGameNewsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager, SteamGameNewsService $steamGameNewsService): Response
    {
        $characters = $entityManager->getRepository(Character::class)->findAll();
        $newsGame = $steamGameNewsService->getGameNewsWithImages(1778820, 6);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'characters' => $characters,
            'newsGame' => $newsGame,
        ]);
    }
}
