<?php

namespace App\Controller;
use App\Entity\Event;
use App\Entity\Ticket;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ticket')]
class TicketController extends AbstractController
{
    #[Route('/new', name: 'app_ticket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        $ticket = new Ticket();

        // Get the currently authenticated user
        $user = $this->getUser();
    
        // Set the user on the ticket entity
        if ($user) {
            $ticket->setUser($user);
        }
    
        // Get the eventId from the request query parameters
        $eventId = $request->query->get('eventId');
    
        if ($eventId) {
            // Retrieve the Event entity by its ID
            $event = $entityManager->getRepository(Event::class)->find($eventId);
    
            if ($event) {
                // Set the event on the ticket entity
                $ticket->setEvent($event);
            }
        }
    
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ticket);
            $entityManager->flush();
    
            $this->addFlash('success', 'Ticket created successfully!');
    
            return $this->redirectToRoute('app_ticket_index');
        }
    
        return $this->render('Back/ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/', name: 'app_ticket_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tickets = $entityManager->getRepository(Ticket::class)->findAll();

        return $this->render('Back/ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_show', methods: ['GET'])]
    public function show(Ticket $ticket): Response
    {
        return $this->render('Back/ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ticket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Ticket updated successfully!');

            return $this->redirectToRoute('app_ticket_index');
        }

        return $this->render('Back/ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_ticket_delete', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ticket);
            $entityManager->flush();

            $this->addFlash('success', 'Ticket deleted successfully!');
        }

        return $this->redirectToRoute('app_ticket_index');
    }

    #[Route('/', name: 'app_ticket_index', methods: ['GET'])]
    public function inddex(EntityManagerInterface $entityManager): Response
    {
        // Retrieve tickets ordered by date in descending order
        $tickets = $entityManager->getRepository(Ticket::class)
            ->findBy([], ['date' => 'DESC']);  // Order by 'date' field in descending order
    
        return $this->render('Back/ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }
    
        #[Route('/', name: 'app_ticket_index', methods: ['GET'])]
        public function indfffex(Request $request, EntityManagerInterface $entityManager): Response
        {
            $sortBy = $request->query->get('sort'); // Get sorting parameter from URL
    
            // Determine sorting order based on the 'sort' parameter
            switch ($sortBy) {
                case 'date_desc':
                    $tickets = $entityManager->getRepository(Ticket::class)->findBy([], ['date' => 'DESC']);
                    break;
                case 'date_asc':
                    $tickets = $entityManager->getRepository(Ticket::class)->findBy([], ['date' => 'ASC']);
                    break;
                default:
                    // Default sorting (e.g., by ID)
                    $tickets = $entityManager->getRepository(Ticket::class)->findAll();
                    break;
            }
    
            return $this->render('Back/ticket/index.html.twig', [
                'tickets' => $tickets,
            ]);
        }
    }


