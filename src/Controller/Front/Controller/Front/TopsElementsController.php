<?php

namespace App\Controller\Front\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopsElementsController extends AbstractController
{
    #[Route('/tops/elements', name: 'app_tops_elements')]
    public function index(): Response
    {
        return $this->render('tops_elements/index.html.twig', [
            'controller_name' => 'TopsElementsController',
        ]);
    }
}
