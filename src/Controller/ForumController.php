<?php

namespace App\Controller;


use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ForumController extends AbstractController
{
    #[Route('/forum', name: 'app_forum')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $categorys = $entityManager->getRepository(Category::class)->findAll();
        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
            'categorys ' => $categorys
        ]);
    }
}
