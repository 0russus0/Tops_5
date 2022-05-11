<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\User;
use App\Form\Category\CreateCategoryType;
use App\Form\Category\EditCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/u/categories')]
class AdminCategoriesController extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    #[Route(
        path:'/categories',
        name: 'app_categories',
        methods: ['GET']
    )]
    public function index(): Response
    {
        $categories = $this->manager->getRepository(Category::class)->findAll();
        return $this->render('front/category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route(
        path: '/new',
        name: 'front_categories_create',
        methods: ['GET', 'POST']
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): Response
    {
        /** @var User $authUser */
        $authUser = $this->getUser();

        $category = new Category();
        $form = $this
            ->createForm(CreateTopType::class, $category)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setAuthor($authUser);
            $this->manager->persist($category);
            $this->manager->flush();

            return $this->redirectToRoute('front_categories_index');
        }

        return $this->renderForm('front/category/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(
        path: '/{uuid}',
        name: 'front_categories_show',
        methods: ['GET']
    )]
    public function show(Category $category): Response
    {
        return $this->render('front/category/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route(
        path: '/{uuid}/edit',
        name: 'front_categories_edit',
        methods: ['GET', 'PATCH']
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Category $category, Request $request): Response
    {
        /** @var User $authUser */
        $authUser = $this->getUser();

        if ($category->getAuthor() !== $authUser) {
            return $this->redirectToRoute('front_categories_index');
        }

        $form = $this
            ->createForm(EditTopType::class, $category)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($category);
            $this->manager->flush();

            return $this->redirectToRoute('front_categories_index');
        }

        return $this->renderForm('front/category/edit.html.twig', [
            'form' => $form,
            'top' => $category,
        ]);
    }

    #[Route(
        path: '/{uuid}',
        name: 'front_categories_delete',
        methods: ['DELETE']
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Category $category): Response
    {
        /** @var User $authUser */
        $authUser = $this->getUser();

        if ($category->getAuthor() !== $authUser) {
            return $this->redirectToRoute('front_categories_index');
        }

        $this->manager->remove($category);
        $this->manager->flush();

        return $this->redirectToRoute('front_tops_index');
    }

}
