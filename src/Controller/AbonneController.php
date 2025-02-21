<?php

// src/Controller/AbonneController.php
namespace App\Controller;

use App\Entity\Abonne;
use App\Form\AbonneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/abonne')]
class AbonneController extends AbstractController
{
    #[Route('/', name: 'abonne_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $abonnes = $entityManager->getRepository(Abonne::class)->findAll();
        return $this->render('abonne/index.html.twig', [
            'abonnes' => $abonnes,
        ]);
    }

    #[Route('/new', name: 'abonne_new', methods: ['GET', 'POST'])]
// src/Controller/AbonneController.php
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $abonne = new Abonne();
    $form = $this->createForm(AbonneType::class, $abonne);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Définir les rôles comme un tableau
        $abonne->setRoles(['ROLE_USER']); // <-- Tableau, pas une chaîne

        $entityManager->persist($abonne);
        $entityManager->flush();

        return $this->redirectToRoute('abonne_index');
    }

    return $this->render('abonne/new.html.twig', [
        'abonne' => $abonne,
        'form' => $form->createView(),
    ]);
}

    #[Route('/{id}', name: 'abonne_show', methods: ['GET'])]
    public function show(Abonne $abonne): Response
    {
        return $this->render('abonne/show.html.twig', [
            'abonne' => $abonne,
        ]);
    }

    #[Route('/{id}/edit', name: 'abonne_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Abonne $abonne, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AbonneType::class, $abonne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('abonne_index');
        }

        return $this->render('abonne/edit.html.twig', [
            'abonne' => $abonne,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'abonne_delete', methods: ['POST'])]
    public function delete(Request $request, Abonne $abonne, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$abonne->getId(), $request->request->get('_token'))) {
            $entityManager->remove($abonne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('abonne_index');
    }
}