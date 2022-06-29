<?php

namespace App\Controller\Front;

use App\Entity\Top;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(EntityManagerInterface $manager): Response
    {
                $rep = $manager->getRepository(Top::class);
                $tops = $rep->findBy([], ['createdAt' => 'DESC'], 5);
                return $this->render('front/home/index.html.twig', [
                    'tops' => $tops,
                ]);
    }
}
