<?php

namespace App\Controller;

use App\Entity\Forumsponsor;
use App\Form\ForumsponsorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/forumsponsor')]
class ForumsponsorController extends AbstractController
{
    #[Route('/', name: 'app_forumsponsor_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $forumsponsors = $entityManager
            ->getRepository(Forumsponsor::class)
            ->findAll();

        return $this->render('Back/forumsponsor/index.html.twig', [
            'forumsponsors' => $forumsponsors,
        ]);
    }

    #[Route('/new', name: 'app_forumsponsor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $forumsponsor = new Forumsponsor();
        $form = $this->createForm(ForumsponsorType::class, $forumsponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload for 'produit' field
            $produitFile = $form['produit']->getData();
            if ($produitFile) {
                $uploadsDirectory = $this->getParameter('terrain_images_directory');
                $newFilename = uniqid().'.'.$produitFile->guessExtension();
                $produitFile->move($uploadsDirectory, $newFilename);

                // Set the 'produit' field of Forumsponsor entity with the uploaded file path
                $forumsponsor->setProduit($newFilename);
            }

            // Persist and flush the Forumsponsor entity
            $entityManager->persist($forumsponsor);
            $entityManager->flush();

            // Redirect to the index page after successful form submission
            return $this->redirectToRoute('app_forumsponsor_index');
        }

        // Render the form template if form is not submitted or invalid
        return $this->render('Back/forumsponsor/new.html.twig', [
            'forumsponsor' => $forumsponsor,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_forumsponsor_show', methods: ['GET'])]
    public function show(Forumsponsor $forumsponsor): Response
    {
        return $this->render('Back/forumsponsor/show.html.twig', [
            'forumsponsor' => $forumsponsor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_forumsponsor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Forumsponsor $forumsponsor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ForumsponsorType::class, $forumsponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload for 'produit' field
            $produitFile = $form['produit']->getData();
            if ($produitFile) {
                $uploadsDirectory = $this->getParameter('terrain_images_directory');
                $newFilename = uniqid().'.'.$produitFile->guessExtension();
                $produitFile->move($uploadsDirectory, $newFilename);

                // Set the 'produit' field of Forumsponsor entity with the new file path
                $forumsponsor->setProduit($newFilename);
            }

            // Flush the changes to the Forumsponsor entity
            $entityManager->flush();

            // Redirect to the index page after successful form submission
            return $this->redirectToRoute('app_forumsponsor_index');
        }

        // Render the edit form template if form is not submitted or invalid
        return $this->render('Back/forumsponsor/edit.html.twig', [
            'forumsponsor' => $forumsponsor,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_forumsponsor_delete', methods: ['POST'])]
    public function delete(Request $request, Forumsponsor $forumsponsor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$forumsponsor->getId(), $request->request->get('_token'))) {
            // Delete the associated file for 'produit' field, if exists
            $uploadsDirectory = $this->getParameter('terrain_images_directory');
            $produitPath = $uploadsDirectory.'/'.$forumsponsor->getProduit();
            if (file_exists($produitPath)) {
                unlink($produitPath);
            }

            // Remove and flush the Forumsponsor entity
            $entityManager->remove($forumsponsor);
            $entityManager->flush();

            // Redirect to the index page after successful deletion
            $this->addFlash('success', 'Forumsponsor deleted successfully');
        } else {
            $this->addFlash('error', 'Invalid CSRF token');
        }

        // Redirect to the index page
        return $this->redirectToRoute('app_forumsponsor_index');
    }
}
