<?php

namespace App\Controller;

use App\Entity\Top;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class TopsController extends AbstractController
{
    #[Route('/tops', name: 'app_tops')]
    public function index(): Response
    {
        return $this->render('tops/index.html.twig', [
            'controller_name' => 'TopsController',
        ]);
    }

    #[Route('/top/:id', name: 'app_top')]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $rep = $doctrine->getRepository(Top::class);
        $top = $rep->find($id);
        return $top;
    }

    #[Route('/top/add', name: 'add_top')]
    public function add(ManagerRegistry $doctrine, Request $request)
    {
        $em = $doctrine->getManager();
        $top = new Top();
        $top->setTitle($request->title);
        $em->persist($top);
        $em->flush();
        return $top;
    }
}
