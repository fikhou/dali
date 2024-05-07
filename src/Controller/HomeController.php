<?php

namespace App\Controller;
use App\Entity\Event;
use App\Form\TicketType;
use App\Entity\Forumsponsor;
use App\Repository\EventRepository; // Assurez-vous d'importer EventRepository ici
use App\Repository\TicketRepository;

use App\Form\Login;
use App\Repository\UserRepository;
use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends AbstractController
{
    #[Route('/', name: 'start', methods: ['GET', 'POST'])] 
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('app_Home');
    }

    #[Route('/Event', name: 'app_Event', methods: ['GET', 'POST'])]
public function faaaaaa(EntityManagerInterface $entityManager): Response
{
    $events = $entityManager
        ->getRepository(Event::class)
        ->findAll();

    return $this->render('Front/event.html.twig', [
        'events' => $events,
    ]);
    
}
    #[Route('/Ticket', name: 'app_Ticket', methods: ['GET', 'POST'])]
    public function Ticket( EntityManagerInterface $em): Response
    {
     

        return $this->render('Back/ticket/index.html.twig', [
          
           
            
       
        ]);
    }
    #[Route('/Reservation', name: 'app_Reservation', methods: ['GET', 'POST'])]
    public function Reservation( EntityManagerInterface $em): Response
    {
     

        return $this->render('reservation/index.html.twig', [
          
           
            
       
        ]);
    }


    #[Route('/Contact', name: 'app_Contact', methods: ['GET', 'POST'])]
    public function Contact(EntityManagerInterface $em): Response
    {
       

        return $this->render('Front/Contact.html.twig', [
          
           
            
       
        ]);
    }
   
    
    #[Route('/Home', name: 'app_Home', methods: ['GET', 'POST'])]
    public function Home(  EntityManagerInterface $entityManager): Response
    { 
        return $this->render('Front/Home.html.twig', [
          
           
            
       
        ]);
    }
   
    #[Route('/Team', name: 'app_Team', methods: ['GET', 'POST'])]
    public function Team( EntityManagerInterface $entityManager): Response
    {
       

        return $this->render('Front/Team.html.twig', [
          
           
            
       
        ]);
    }


    #[Route('/Entreprise', name: 'app_Entreprise', methods: ['GET', 'POST'])]
    public function faaa(EntityManagerInterface $entityManager): Response
    {
        $entreprises = $entityManager
            ->getRepository(Entreprise::class)
            ->findAll();
    
        return $this->render('Back/entreprise/entreprise.html.twig', [
            'entreprises' => $entreprises,
        ]);
    }

    
        #[Route('/Sponsor', name: 'app_Sponsor', methods: ['GET', 'POST'])]
        public function showForumsponsors(EntityManagerInterface $entityManager): Response
        {
            $forumsponsors = $entityManager
                ->getRepository(Forumsponsor::class)
                ->findAll();
    
            return $this->render('Front/sponsor.html.twig', [
                'forumsponsors' => $forumsponsors,
            ]);
        }
        #[Route('/search', name: 'event_search')]        public function searchEvents(EventRepository $eventRepository, Request $request): Response
        {
            $searchTerm = $request->query->get('search');
    
            if ($searchTerm) {
                $events = $eventRepository->findByEventName($searchTerm);
            } else {
                $events = $eventRepository->findAll();
            }
    
            return $this->render('Front/event.html.twig', [
                'events' => $events,
            ]);
        }
        #[Route('/stat', name: 'app_stat', methods: ['GET', 'POST'])]
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
    





    // #[Route('/login', name: 'app_user_login', methods: ['GET' , 'POST'])]
    // public function login(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $userRepository = $entityManager->getRepository(User::class);
        
    //     $user = new User();
    //     $formlogin = $this->createForm(Login::class , $user , ['validation_groups' => ['login']]);
    //     $formlogin->handleRequest($request);
    //     if ($formlogin->isSubmitted() && $formlogin->isValid()) {
           
    //         $user = $userRepository->findOneByemail($formlogin->get('email')->getData());

    //         if($user){
    //             if($user->getPassword() == $formlogin->get('password')->getData()){
    //                 return $this->redirectToRoute('app_user_profile', ['id' => $user->getId()]);
    //             }else{
    //                 $this->addFlash('error', 'Password is incorrect');
    //             }
    //             }
        
    //         }
    //     return $this->renderForm('login.html.twig', [
            
    //         'formlogin' => $formlogin,
          
    //     ]);
    // }


    // #[Route('/register', name: 'app_user_register', methods: ['GET' , 'POST'])]
    // public function register(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $userRepository = $entityManager->getRepository(User::class);

    //     $user = new User();
    //     $form = $this->createForm(UserType::class , $user , ['validation_groups' => ['registration']]);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $userexist = $userRepository->findOneByemail($form->get('email')->getData());
    //         if(!$userexist){
    //             $entityManager->persist($user);
    //             $entityManager->flush();
    //             return $this->redirectToRoute('app_user_login', [], Response::HTTP_SEE_OTHER);
    //         }
            

    //         return $this->redirectToRoute('app_user_register', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('register.html.twig', [
    //         'form' => $form
            
    //     ]);
    // }





    
    
   
   
  

