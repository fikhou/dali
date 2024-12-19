<?php

namespace App\Controller;
use App\Entity\Event;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Reeser;
use App\Form\ReeserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reeser')]
class ReeserController extends AbstractController
{
    #[Route('/', name: 'app_reeser_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        // Retrieve all Reeser entities from the repository
        $query = $entityManager->getRepository(Reeser::class)->createQueryBuilder('r')
            ->getQuery();

        // Paginate the results using PaginatorInterface
        $reesers = $paginator->paginate(
            $query, // Query to paginate
            $request->query->getInt('page', 1), // Current page number, defaulting to 1
            1 // Number of items per page
        );

        // Render the index template with paginated results
        return $this->render('Back/reeser/index.html.twig', [
            'reesers' => $reesers,
        ]);
    }
    

    #[Route('/new', name: 'app_reeser_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Get the currently logged-in user
        $user = $this->getUser();

        $reeser = new Reeser();
        $reeser->setUser($user); // Set the user for the new Reeser entity

        $form = $this->createForm(ReeserType::class, $reeser);
        $form->handleRequest($request);

        $eventId = $request->query->get('eventId');
    
        if ($eventId) {
            // Retrieve the Event entity by its ID
            $event = $entityManager->getRepository(Event::class)->find($eventId);
    
            if ($event) {
                // Set the event on the ticket entity
                $reeser->setEvent($event);
            }
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reeser);
            $entityManager->flush();

            return $this->redirectToRoute('app_reeser_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/reeser/new.html.twig', [
            'reeser' => $reeser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reeser_show', methods: ['GET'])]
    public function show(Reeser $reeser): Response
    {
        return $this->render('Back/reeser/show.html.twig', [
            'reeser' => $reeser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reeser_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reeser $reeser, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReeserType::class, $reeser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reeser_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Back/reeser/edit.html.twig', [
            'reeser' => $reeser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reeser_delete', methods: ['POST'])]
    public function delete(Request $request, Reeser $reeser, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reeser->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reeser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reeser_index', [], Response::HTTP_SEE_OTHER);
    }
}
