<?php

namespace App\Controller;


use App\Entity\Post;
use App\Entity\Topic;
use App\Entity\Category;
use App\Form\NewPostType;
use App\Form\NewTopicType;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/errorPage', name: 'show_errorForum')]
    public function errorPage(EntityManagerInterface $entityManager): Response
    {
        return $this->render('forum/error.html.twig');
    }

    #[Route('/listPostsInTopic/{id}', name: 'show_listPostsInTopic')]
    public function listPosts(Topic $topic, Request $request, UserService $userService, Security $security, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
    
        $formPost = $this->createForm(NewPostType::class, $post);
        $formPost->handleRequest($request);
    
        if ($formPost->isSubmitted() && $formPost->isValid()) {
            // Récupérer l'utilisateur connecté
            $user = $security->getUser();
            $post->setUser($user); // Définir l'utilisateur
            $post->setTopic($topic); // Defini le topic
            // Définir la date actuelle
            $post->setCreationDateMessage(new \DateTime());
    
            // Sauvegarder dans la base de données
            $entityManager->persist($post);
            $entityManager->flush();
            
            $userService->addGradePoints($user, 10);
            
            return $this->redirectToRoute('show_listPostsInTopic', ['id' => $post->getTopic()->getId()]);
        }
    
        return $this->render('forum/posts.html.twig', [
            'newPost' => $formPost->createView(),
            'topic' => $topic,
            'posts' => $topic->getPosts()
        ]);
    }

    #[Route('/newTopicInCategory/{id}', name: 'show_newTopicInCategory')]
    public function newTopic(Category $category, Request $request, UserService $userService, Security $security, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $topic = new Topic();
    
        $formTopic = $this->createForm(NewTopicType::class, $topic);
        $formPost = $this->createForm(NewPostType::class, $post);
        $formTopic->handleRequest($request);
        $formPost->handleRequest($request);
    
        if ($formTopic->isSubmitted() && $formTopic->isValid()) {
            // Récupérer l'utilisateur connecté
            $user = $security->getUser();
            $topic->setUser($user); // Définir l'utilisateur
            $topic->setCategory($category); // Définir le category
            // Définir la date actuelle
            $topic->setCreationDateTopic(new \DateTime());
            $topic->setLocked(false);
            
            // Sauvegarder dans la base de données
            $entityManager->persist($topic);
            $entityManager->flush();

            $post->setUser($user); // Définir l'utilisateur
            $post->setTopic($topic); // Defini le topic
            // Définir la date actuelle
            $post->setCreationDateMessage(new \DateTime());
        
            // Sauvegarder dans la base de données
            $entityManager->persist($post);
            $entityManager->flush();

            $userService->addGradePoints($user, 20);

            return $this->redirectToRoute('show_listTopicsInCategory', ['id' => $topic->getCategory()->getId()]);
        }
    
        return $this->render('forum/newTopic.html.twig', [
            'newTopic' => $formTopic->createView(),
            'newPost' => $formPost->createView(),
            'category' => $category
        ]);
    }

    #[Route('/topic/delete/{id}', name: 'delete_topic', methods: ['POST'])]
    public function deleteTopic(Request $request, Topic $topic, Security $security, EntityManagerInterface $entityManager): Response
    {
        if ($security->getUser() == $topic->getUser() || $security->isGranted('ROLE_ADMIN')) {
            // Protection contre la suppression accidentelle via un token CSRF
            if ($this->isCsrfTokenValid('delete'.$topic->getId(), $request->request->get('_token'))) {
                $entityManager->remove($topic);
                $entityManager->flush();

                $this->addFlash('success', 'Topic supprimé avec succès.');
            }
        }

        return $this->redirectToRoute('show_listTopicsInCategory', ['id' => $topic->getCategory()->getId()]);
    }

    #[Route('/post/delete/{id}', name: 'delete_post', methods: ['POST'])]
    public function deletePost(Request $request, Post $post, Security $security, EntityManagerInterface $entityManager): Response
    {
        if ($security->getUser() == $post->getUser() || $security->isGranted('ROLE_ADMIN')) {
            
            if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
                $entityManager->remove($post);
                $entityManager->flush();
            }
        }

        return $this->redirectToRoute('show_listPostsInTopic', ['id' => $post->getTopic()->getId()]);
    }

    #[Route('/post/lock/{id}', name: 'lockOrUnlockTopic', methods: ['POST'])]
    public function lockOrUnLockTopic(Request $request, Topic $topic, Security $security, EntityManagerInterface $entityManager): Response
    {
        if ($security->isGranted('ROLE_ADMIN')) {
            // Protection contre la suppression accidentelle via un token CSRF
            if ($this->isCsrfTokenValid('lock'.$topic->getId(), $request->request->get('_token'))) {
                
                
                if ($topic->isLocked() == false) {
                    $topic->setLocked(!$topic->isLocked());
                    $entityManager->flush();
                } else {
                    $topic->setLocked(!$topic->isLocked());
                    $entityManager->flush();
                }

            }
        }

        return $this->redirectToRoute('show_listPostsInTopic', ['id' => $topic->getId()]);
    }

}
