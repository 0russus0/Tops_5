<?php

namespace App\Controller\Front;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user', name: 'app_user')]
class UserController extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    #[Route(
        path: '/',
        name: 'front_users_index',
        methods: ['GET']
    )]
    public function index(): Response
    {
        $users = $this->manager->getRepository(User::class)->findAll();
        return $this->render('front/users/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route(
        path: '/home',
        name: 'home',
        methods: ['GET'],)]
    public function users(EntityManagerInterface $manager): Response
    {
        $repUser = $manager->getRepository(User::class);
        $users = $repUser->findBy([], ['createdAt' => 'DESC'], 5);
        return $this->render('front/home/index.html.twig', [
            'users' => $users,
        ]);
    }


}
