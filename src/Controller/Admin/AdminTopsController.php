<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/admin/tops')]
#[IsGranted('ROLE_ADMIN')]
class HomeController extends AbstractController
{
    #[Route('/')]
    public function index(EntityManagerInterface $manager): Response
    {

    }

}
