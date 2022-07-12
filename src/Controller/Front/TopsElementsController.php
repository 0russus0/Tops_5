<?php

namespace App\Controller\Front;

use App\Entity\Top;
use App\Entity\TopElement;
use App\Entity\User;
use App\Form\TopElement\CreateTopElementType;
use App\Form\TopElement\EditTopElementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopsElementsController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
    ) {
    }

    #[Route('/tops/elements', name: 'app_tops_elements')]
    public function index(): Response
    {
        return $this->render('tops_elements/index.html.twig', [
            'controller_name' => 'TopsElementsController',
        ]);
    }

    #[Route('/top/{uuid}/new', name: 'front_top_element_create')]
    public function create(Top $top, Request $request): Response
    {
        $form = $this
            ->createForm(CreateTopElementType::class)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->getUser();

            $responses = [
                strval($form->get('response_one')->getData()),
                strval($form->get('response_two')->getData()),
                strval($form->get('response_three')->getData()),
                strval($form->get('response_four')->getData()),
                strval($form->get('response_five')->getData()),
            ];

            foreach ($responses as $element) {
                $topElement = new TopElement();
                $topElement
                    ->setContent($element)
                    ->setAuthor($user)
                    ->setTop($top);

                $this->manager->persist($topElement);
            }

            $this->manager->flush();

            return $this->redirectToRoute('front_tops_show', ['uuid' => $top->getUuid()]);
        }

        return $this->renderForm('front/tops_elements/create.html.twig', [
            'form' => $form,
            'top' => $top,
        ]);
    }

    #[Route('/top/{uuid}/elements', name: 'front_top_element_edit')]
    public function edit(Top $top, Request $request): Response
    {
        $responses = array_map(function ($element) {
            return $element->getContent();
        }, $top->getTopElements()->toArray());

        $elements = array_splice($responses, 0, 5);

        $form = $this
            ->createForm(EditTopElementType::class, null, [
                'responses' => $elements
            ])
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->getUser();

            $responses = [
                strval($form->get('response_one')->getData()),
                strval($form->get('response_two')->getData()),
                strval($form->get('response_three')->getData()),
                strval($form->get('response_four')->getData()),
                strval($form->get('response_five')->getData()),
            ];

            foreach ($top->getTopElements() as $element) {
                $this->manager->remove($element);
            }

            foreach ($responses as $element) {
                $topElement = new TopElement();
                $topElement
                    ->setContent($element)
                    ->setAuthor($user)
                    ->setTop($top);

                $this->manager->persist($topElement);
            }

            $this->manager->flush();

            return $this->redirectToRoute('front_tops_show', ['uuid' => $top->getUuid()]);
        }

        return $this->renderForm('front/tops_elements/create.html.twig', [
            'form' => $form,
            'top' => $top,
        ]);
    }
}
