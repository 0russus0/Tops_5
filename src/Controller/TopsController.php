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
    public function index(ManagerRegistry $doctrine)
    {
        $rep = $doctrine->getRepository(Top::class);
        $tops = $rep->findAll();
        // if using Vue js return a response JS
        // $response = new Response(json_encode($tops));
        // $response->headers->set('Content-Type', 'application/json');
        // return $response;
        return $this->render('tops/index.html.twig', [
            'tops' => $tops,
        ]);
    }

    #[Route('/top/{id}', name: 'app_top')]
    public function show(ManagerRegistry $doctrine, int $id)
    {
        $rep = $doctrine->getRepository(Top::class);
        $top = $rep->find($id);
        // if using Vue js return a response JS
        // $response = new Response(json_encode($top->getTitle()));
        // $response->headers->set('Content-Type', 'application/json');
        // return $response;
        return $this->render('tops/show.html.twig', [
            'top' => $top,
        ]);
    }

    #[Route('/top/create', name: 'create_top')]
    public function create(ManagerRegistry $doctrine, Request $request)
    {
        $em = $doctrine->getManager();
        $top = new Top();
        $top->setTitle($request->title);
        $em->persist($top);
        $em->flush();
        return $top;
    }

    #[Route('/top/edit/{id}', name: 'edit_top')]
    public function edit(ManagerRegistry $doctrine, Request $request)
    {
        $em = $doctrine->getManager();
        $top = new Top();
        $top->setTitle($request->title);
        $em->persist($top);
        $em->flush();
        return $top;
    }
}
