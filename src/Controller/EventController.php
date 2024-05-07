<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository; // Assurez-vous d'importer EventRepository ici

use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

#[Route('/event')]
class EventController extends AbstractController
{
    #[Route('/', name: 'app_event_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $events = $entityManager->getRepository(Event::class)->findAll();

        return $this->render('Back/event/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/new', name: 'app_event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FlashBagInterface $flashBag): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('terrain_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $flashBag->add('error', 'Failed to upload image');
                    return $this->redirectToRoute('app_event_new');
                }

                $event->setImage($newFilename);
            }

            $entityManager->persist($event);
            $entityManager->flush();

            $flashBag->add('success', 'Event created successfully');

            return $this->redirectToRoute('app_event_index');
        }

        return $this->render('Back/event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        return $this->render('Back/event/show.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_event_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Event $event, EntityManagerInterface $entityManager, FlashBagInterface $flashBag): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('terrain_images_directory'),
                        $newFilename
                    );
                    $event->setImage($newFilename);
                } catch (FileException $e) {
                    $flashBag->add('error', 'Failed to upload image');
                    return $this->redirectToRoute('app_event_edit', ['id' => $event->getId()]);
                }
            }

            $entityManager->flush();

            $flashBag->add('success', 'Event updated successfully');

            return $this->redirectToRoute('app_event_index');
        }

        return $this->renderForm('Back/event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_event_delete', methods: ['POST'])]
    public function delete(Request $request, Event $event, EntityManagerInterface $entityManager, FlashBagInterface $flashBag): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            // Delete event image if exists
            $imagePath = $this->getParameter('terrain_images_directory').'/'.$event->getImage();
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $entityManager->remove($event);
            $entityManager->flush();

            $flashBag->add('success', 'Event deleted successfully');
        } else {
            $flashBag->add('error', 'Invalid CSRF token');
        }

        return $this->redirectToRoute('app_event_index');
    }
   
}
