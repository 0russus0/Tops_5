<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Security\SignUpType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/signup', name: 'app_signup')]
    public function signup(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $userPasswordHasher, FileUploader $fileUploader):Response{
        $user = new User();
        $form = $this->createForm(SignUpType::class, $user)->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('password')->getData()));
            /** @var UploadedFile $avatar */
            $avatar = $form->get('avatar')->getData();
            if ($avatar) {
                $avatarFileName = $fileUploader->upload($avatar);
                $user->setAvatar($avatarFileName);
            }
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->renderForm('security/register.html.twig', ['form'=>$form]);

    }
}
