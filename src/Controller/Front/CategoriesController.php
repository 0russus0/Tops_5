<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\Category;
use App\Entity\User;
use App\Form\Category\CreateCategoryType;
use App\Form\Category\EditCategoryType;





#[Route(path: '/categories')]
class CategoriesController extends AbstractController
{

    #[Route(
        path: '/',
        name: 'front_index_categories',
        methods: ['GET']
    )]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $repCategories = $doctrine->getRepository(Category::class);
        return $this->render('front/categories/index.html.twig', [
            'categories' => $repCategories->findBy(array(), array('created_at' => 'DESC')),
        ]);
    }

    #[Route(
        path: '/new',
        name: 'front_create_category',
        requirements: ['id' => '\d+'],
        methods: ['GET', 'POST']
    )]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CreateCategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($category);
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('front_index_categories');
        }
        return $this->render('front/categories/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route(
        path: '/edit/{id}',
        name: 'front_edit_category',
        methods: ['GET', 'PUT']
    )]

    public function edit(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $repCategory = $doctrine->getRepository(category::class);
        $category = $repCategory->find($id);
        $form = $this->createForm(EditCategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('front_index_categories');
        }

        return $this->render('front/categories/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route(
        path: '/show/{id}',
        name: 'front_show_category',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]

    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $repCategory = $doctrine->getRepository(Category::class);
        $category = $repCategory->find($id);
        return $this->render('front/categories/show.html.twig', [
            'category' => $category
        ]);
    }

    #[Route(
        path: '/delete/{id}',
        name: 'front_delete_category',
        requirements: ['id' => '\d+'],
        methods: ['DELETE']
    )]

    public function delete(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $repCategory  = $doctrine->getRepository(Category::class);
        $category = $repCategory->find($id);
        $em = $doctrine->getManager();
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('front_index_categories');
    }
}
