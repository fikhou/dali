<?php

namespace App\Controller;
use App\Entity\Event;
use App\Form\TicketType;
use App\Entity\Forumsponsor;
use App\Repository\EventRepository; // Assurez-vous d'importer EventRepository ici
use App\Repository\TicketRepository;
use App\Service\WeatherService;
use Psr\Log\LoggerInterface;

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
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    #[Route('/', name: 'start', methods: ['GET', 'POST'])] 
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('app_Home');
    }

    #[Route('/Event', name: 'app_Event', methods: ['GET', 'POST'])]
public function faaaaaa(EntityManagerInterface $entityManager , WeatherService $weatherService , Request $request): Response
{
    $events = $entityManager
        ->getRepository(Event::class)
        ->findAll();
        $city = $request->query->get('city');
        $forecast = null;
        $errorMsg = null;
        if ($city) {
            $weatherData = $weatherService->getWeatherForecast($city);
            $forecast = $weatherData['data'];
            $errorMsg = $weatherData['error'];
        }else {
            $forecast = null;
        }
    return $this->render('Front/event.html.twig', [
        'events' => $events,
        'forecast' => $forecast,
        'forecastAvailable' => $forecast !== null,
        'errorMsg' => $errorMsg,

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
        #[Route('/search', name: 'event_search')]
        public function searchEvents(EventRepository $eventRepository, Request $request): Response
        {
            $searchTerm = $request->query->get('search');
            
            try {
                if ($searchTerm) {
                    $events = $eventRepository->findByEventName($searchTerm);
                } else {
                    $events = $eventRepository->findAll();
                }
                
                // Fetch forecast data (assuming it comes from an external service)
                $forecastData = $this->fetchForecastData(); // Implement this method to fetch forecast data
                
                // Assuming no error, set errorMsg to null or an empty string
                $errorMsg = null;
            } catch (\Exception $e) {
                // If there's an error, set errorMsg to an appropriate message
                $errorMsg = 'An error occurred while fetching events.';
                // Log the exception for debugging purposes
                $this->logger->error('Error fetching events: ' . $e->getMessage());
                // Handle the error case more appropriately based on your application's needs
            }
            
            return $this->render('Front/event.html.twig', [
                'events' => $events,
                'errorMsg' => $errorMsg,
                'forecast' => $forecastData, // Pass forecast data to the template
            ]);
        }
        
        private function fetchForecastData()
        {
            // Implement logic to fetch forecast data (e.g., from a weather API)
            // Return the forecast data as an array or object
            return [
                'list' => [/* Populate with forecast data */],
            ];
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





    
    
   
   
  

