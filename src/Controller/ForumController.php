<?php

namespace App\Controller;


use App\Entity\Topic;
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
            'categorys' => $categorys
        ]);
    }

    #[Route('/listTopicsInCategory/{id}', name: 'show_listTopicsInCategory')]
    public function show(Category $category): Response
    {
        return $this->render('forum/topics.html.twig', [
            'category' => $category,
            'topics' => $category->getTopics()
        ]);
    }

    #[Route('/listPostsInTopic/{id}', name: 'show_listPostsInTopic')]
    public function listPosts(Topic $topic): Response
    {
        return $this->render('forum/posts.html.twig', [
            'topic' => $topic,
            'posts' => $topic->getPosts()
        ]);
    }
}
