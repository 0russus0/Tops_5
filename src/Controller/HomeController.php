<?php

namespace App\Controller;

use App\Entity\Top;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(EntityManagerInterface $manager): Response
    {
        $rep = $manager->getRepository(Top::class);
        $tops = $rep->findBy([], ['createdAt' => 'DESC'], 5);
        return $this->render('pages/home/index.html.twig', [
            'tops' => $tops,
        ]);
    }
}
