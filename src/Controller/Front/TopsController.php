<?php

namespace App\Controller\Front;

use App\Entity\Top;
use App\Entity\User;
use App\Form\Top\CreateTopType;
use App\Form\Top\EditTopType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/u/tops')]
class TopsController extends AbstractController
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    #[Route(
        path: '/',
        name: 'front_tops_index',
        methods: ['GET']
    )]
    public function index(): Response
    {
        $tops = $this->manager->getRepository(Top::class)->findAll();
        return $this->render('front/top/index.html.twig', [
            'tops' => $tops,
        ]);
    }

    #[Route(
        path: '/new',
        name: 'front_tops_create',
        methods: ['GET', 'POST']
    )]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request): Response
    {
        /** @var User $authUser */
        $authUser = $this->getUser();

        $top = new Top();
        $form = $this
            ->createForm(CreateTopType::class, $top)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $top->setAuthor($authUser);
            $this->manager->persist($top);
            $this->manager->flush();

            return $this->redirectToRoute('front_tops_index');
        }

        return $this->renderForm('front/top/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(
        path: '/{uuid}',
        name: 'front_tops_show',
        methods: ['GET']
    )]
    public function show(Top $top): Response
    {
        return $this->render('front/top/show.html.twig', [
            'top' => $top,
        ]);
    }

    #[Route(
        path: '/{uuid}/edit',
        name: 'front_tops_edit',
        methods: ['GET', 'PATCH']
    )]
    #[IsGranted('ROLE_USER')]
    public function edit(Top $top, Request $request): Response
    {
        /** @var User $authUser */
        $authUser = $this->getUser();

        if ($top->getAuthor() !== $authUser) {
            return $this->redirectToRoute('front_tops_index');
        }

        $form = $this
            ->createForm(EditTopType::class, $top)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($top);
            $this->manager->flush();

            return $this->redirectToRoute('front_tops_index');
        }

        return $this->renderForm('front/top/edit.html.twig', [
            'form' => $form,
            'top' => $top,
        ]);
    }

    #[Route(
        path: '/{uuid}',
        name: 'front_tops_delete',
        methods: ['DELETE']
    )]
    #[IsGranted('ROLE_USER')]
    public function delete(Top $top): Response
    {
        /** @var User $authUser */
        $authUser = $this->getUser();

        if ($top->getAuthor() !== $authUser) {
            return $this->redirectToRoute('front_tops_index');
        }

        $this->manager->remove($top);
        $this->manager->flush();

        return $this->redirectToRoute('front_tops_index');
    }
}
