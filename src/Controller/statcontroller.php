<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    #[Route('/statistics', name: 'app_statistics')]
    public function statistics(Request $request, TicketRepository $ticketRepository): Response
    {
        // Fetch all events
        $events = $this->getDoctrine()->getRepository(Event::class)->findAll();

        // Get ticket counts per event
        $eventTicketCounts = [];
        foreach ($events as $event) {
            $ticketCount = $ticketRepository->countTicketsByEvent($event);
            $eventTicketCounts[$event->getId()] = $ticketCount;
        }

        return $this->render('Front/stat.html.twig', [
            'events' => $events,
            'eventTicketCounts' => $eventTicketCounts,
        ]);
    }
}
