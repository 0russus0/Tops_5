<?php

namespace App\Controller\Front;

use App\Entity\Top;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(EntityManagerInterface $manager): Response
    {
        $repTops = $manager->getRepository(Top::class);
        $tops = $repTops->findBy([], ['createdAt' => 'DESC'], 5);
        $repUser = $manager->getRepository(User::class);
        $users = $repUser->findBy([], ['createdAt' => 'DESC'], 5);
        return $this->render('front/home/index.html.twig', [
            'tops' => $tops,
            'users' => $users,
        ]);
    }
}
