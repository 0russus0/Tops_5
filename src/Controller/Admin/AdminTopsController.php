<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin/tops')]
#[IsGranted('ROLE_ADMIN')]
class AdminTopsController extends AbstractController
{
    #[Route('/')]
    public function index(EntityManagerInterface $manager): Response
    {
    }
}
