<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/entreprise')]
class EntrepriseController extends AbstractController
{
    #[Route('/', name: 'app_entreprise_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $entreprises = $entityManager
            ->getRepository(Entreprise::class)
            ->findAll();

        return $this->render('Back/entreprise/index.html.twig', [
            'entreprises' => $entreprises,
        ]);
    }

    #[Route('/new', name: 'app_entreprise_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Create a new instance of Entreprise
        $entreprise = new Entreprise();

        // Get the currently logged-in user (assuming you're using Symfony's security component)
        $user = $this->getUser();

        // Set the logged-in user as the owner of the Entreprise
        $entreprise->setUser($user);

        // Create a form for the Entreprise
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                // Generate a unique name for the file
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the desired directory
                try {
                    $imageFile->move(
                        $this->getParameter('terrain_images_directory'),
                        $newFilename
                    );
                } catch (\Exception $e) {
                    // Handle file upload error
                    // You may log the error or display a flash message
                }

                // Update the image filename in the entity
                $entreprise->setImage($newFilename);
            }

            // Persist the Entreprise entity
            $entityManager->persist($entreprise);
            $entityManager->flush();

            // Redirect to the index page or show success message
            return $this->redirectToRoute('app_entreprise_index');
        }

        return $this->render('Back/entreprise/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_entreprise_show', methods: ['GET'])]
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('Back/entreprise/show.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_entreprise_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entreprise $entreprise, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image upload
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                // Generate a unique name for the file
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the desired directory
                try {
                    $imageFile->move(
                        $this->getParameter('terrain_images_directory'),
                        $newFilename
                    );
                } catch (\Exception $e) {
                    // Handle file upload error
                    // You may log the error or display a flash message
                }

                // Update the image filename in the entity
                $entreprise->setImage($newFilename);
            }

            // Persist the updated entity
            $entityManager->flush();

            // Redirect to the index page or show success message
            return $this->redirectToRoute('app_entreprise_index');
        }

        return $this->render('Back/entreprise/edit.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_entreprise_delete', methods: ['POST'])]
    public function delete(Request $request, Entreprise $entreprise, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entreprise->getId(), $request->request->get('_token'))) {
            // Remove the entity
            $entityManager->remove($entreprise);
            $entityManager->flush();
        }

        // Redirect to the index page or show success message
        return $this->redirectToRoute('app_entreprise_index');
    }
    
}
