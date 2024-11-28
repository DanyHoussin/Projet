<?php

namespace App\Controller;

use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $characters = $entityManager->getRepository(Character::class)->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'characters' => $characters
        ]);
    }
}
