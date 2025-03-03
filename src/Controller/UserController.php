<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\Voter\UserVoter;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepository): Response
    {

        $users = $userRepository->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/user/create', name: 'app_user_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $newUser = new User();
        $form = $this->createForm(UserType::class, $newUser);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Encode password
            $plainPassword = $form->get('plainPassword')->getData();
            $newUser->setPassword($userPasswordHasher->hashPassword($newUser, $plainPassword));

            $entityManager->persist($newUser);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur créé avec succès.');
            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/{id}', name: 'app_user_view')]
    public function view(UserRepository $userRepository, Request $request): Response
    {
        $user = $userRepository->find($request->get('id'));
        if (!$this->isGranted(UserVoter::VIEW, $user) || !$this) {
            $this->addFlash('error', 'Vous n\'avez pas les droits nécessaires pour voir cet utilisateurs.');
            return $this->redirectToRoute('app_user');
        }
        return $this->render('user/view.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/user/{id}/edit', name: 'app_user_edit')]
    public function edit(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $userRepository->find($request->get('id'));
        if (!$user) {
            $this->addFlash('error', 'Utilisateur non trouvé.');
            return $this->redirectToRoute('app_user');
        }
        if (!$this->isGranted(UserVoter::EDIT, $user)) {
            $this->addFlash('error', 'Vous n\'avez pas les droits nécessaires pour modifier cet utilisateurs.');
            return $this->redirectToRoute('app_user');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();

            if ($plainPassword) {
                // Only hash and update password if a new one is provided
                $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_view', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }


    #[Route('/user/{id}/delete', name: 'app_user_delete')]
    public function delete(UserRepository $userRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($request->get('id'));
        if (!$user) {
            $this->addFlash('error', 'Utilisateur non trouvé.');
            return $this->redirectToRoute('app_user');
        }
        if (!$this->isGranted(UserVoter::DELETE, $user)) {
            $this->addFlash('error', 'Vous n\'avez pas les droits nécessaires pour supprimer cet utilisateurs.');
            return $this->redirectToRoute('app_user');
        }
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash('success', 'Utilisateur supprimée avec succès.');
        return $this->redirectToRoute('app_user');
    }
}
