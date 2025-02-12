<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use App\Security\Voter\ClientVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(ClientRepository $clientRepository): Response
    {
        $clients = $clientRepository->findAll();
        return $this->render('client/index.html.twig', [
            'clients' => $clients
        ]);
    }


    #[Route('/client/create', name: 'app_client_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($client);
            $entityManager->flush();
        }

        return $this->render('client/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/client/{id}', name: 'app_client_view')]
    public function view(ClientRepository $clientRepository, int $id): Response
    {
        $client = $clientRepository->find($id);
        if (!$this->isGranted(ClientVoter::VIEW, $client)) {
            $this->addFlash('error', 'Vous n\'avez pas les droits nécessaires pour voir ce client.');
            return $this->redirectToRoute('app_client');
        }

        return $this->render('client/view.html.twig', [
            'client' => $client
        ]);
    }

    #[Route('/client/{id}/edit', name: 'app_client_edit')]
    public function edit(ClientRepository $clientRepository, Request $request): Response
    {
        $client = $clientRepository->find($request->get('id'));
        if (!$this->isGranted(ClientVoter::EDIT, $client)) {
            $this->addFlash('error', 'Vous n\'avez pas les droits nécessaires pour modifier ce client.');
            return $this->redirectToRoute('app_client');
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client
        ]);
    }

    #[Route('/client/{id}/delete', name: 'app_client_delete')]
    public function delete(ClientRepository $clientRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $client = $clientRepository->find($request->get('id'));
        if (!$this->isGranted(ClientVoter::DELETE, $client)) {
            $this->addFlash('error', 'Vous n\'avez pas les droits nécessaires pour supprimer ce client.');
            return $this->redirectToRoute('app_client');
        }

        $entityManager->remove($client);
        $entityManager->flush();
        $this->addFlash('success', 'Utilisateur supprimée avec succès.');
        return $this->redirectToRoute('app_client');
    }
}
