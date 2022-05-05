<?php

namespace App\Controller;

use App\Entity\Top;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $rep = $doctrine->getRepository(Top::class);
        $tops = $rep->findBy([], ['createdAt' => 'DESC'], 5);
        return $this->render('pages/home/index.html.twig', [
            'tops' => $tops,
        ]);
    }
}
