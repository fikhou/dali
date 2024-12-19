<?php

namespace App\Controller;

use App\Entity\Forumsponsor;
use App\Form\ForumsponsorType;
use App\Repository\ForumsponsorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use TCPDF;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[Route('/forumsponsor')]
class ForumsponsorController extends AbstractController
{
    #[Route('/', name: 'app_forumsponsor_index', methods: ['GET'])]
    public function index(ForumsponsorRepository $forumsponsorRepository,EntityManagerInterface $entityManager): Response
    {
      
            $sponsorings = $forumsponsorRepository->findBy([], ['etat' => 'ASC']);

        return $this->render('Back/forumsponsor/index.html.twig', [
            'forumsponsors' => $sponsorings,
        ]);
    }

    #[Route('/export-pdf', name: 'app_sponsoring_export_pdf', methods: ['GET'])]
    public function exportPdf(ForumsponsorRepository $sponsoringRepository): Response
{
    // Récupérez la liste des sponsorings depuis le repository
    $sponsorings = $sponsoringRepository->findAll();

    // Créez une instance de TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Définir le nom du document
    $pdf->SetTitle('Liste des Sponsorings');

    // Définir le nom de l'auteur
    $pdf->SetAuthor('Votre nom d\'entreprise');

    // Ajoutez une page
    $pdf->AddPage();

    // Ajoutez le contenu du PDF
    $html = '<style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: left;
                }
                h1 {
                    text-align: center;
                }
                .green-border th {
                    border-color: green;
                }
            </style>';
    $html .= '<h1>Liste des Sponsorings</h1>';
    $html .= '<table>';
    $html .= '<tr class="green-border"><th>Nom</th><th>Nom de l\'établissement</th><th>Domaine</th><th>Adresse</th><th>Email</th><th>Type d\'établissement</th><th>Numéro</th><th>Description</th><th>État</th></tr>';
    foreach ($sponsorings as $sponsoring) {
        $html .= '<tr>';
        
        $html .= '<td>' . $sponsoring->getUser()->getName() . '</td>';
        
        $html .= '<td>' . $sponsoring->getNomEtab() . '</td>';
        $html .= '<td>' . $sponsoring->getDomaine() . '</td>';
        $html .= '<td>' . $sponsoring->getUser()->getAddress() . '</td>';
        $html .= '<td>' . $sponsoring->getUser()->getEmail() . '</td>';
        $html .= '<td>' . $sponsoring->getTetab() . '</td>';
        $html .= '<td>' . $sponsoring->getUser()->getPhone() . '</td>';
        $html .= '<td>' . $sponsoring->getDescription() . '</td>';
        $html .= '<td>' . $sponsoring->getEtat() . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';

    // Écrivez le contenu HTML dans le PDF
    $pdf->writeHTML($html);

    // Télécharger le PDF en tant que réponse
    $response = new Response($pdf->Output('liste_sponsorings.pdf', 'D'));
    $dispositionHeader = $response->headers->makeDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        'liste_sponsorings.pdf'
    );
    $response->headers->set('Content-Disposition', $dispositionHeader);

    return $response;
}



    #[Route('/new', name: 'app_forumsponsor_new', methods: ['GET', 'POST'])]
    public function new( TokenStorageInterface $tokenStorage,SessionInterface $session,Request $request, EntityManagerInterface $entityManager): Response
    {
        $forumsponsor = new Forumsponsor();
        $form = $this->createForm(ForumsponsorType::class, $forumsponsor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = $tokenStorage->getToken();
            $user = $token->getUser();
        
            $data = $form->getData();
            $forumsponsor->setUser($user);

            // Si le domaine est "Autres", utilisez la valeur de 'autreDomaine' pour 'domaine'
            if ($data->getDomaine() === 'Autres') {
                $forumsponsor->setDomaine($data->getAutreDomaine());
            }
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
            $forumsponsor->setUser($this->getUser());

            $data = $form->getData();

            // Si le domaine est "Autres", utilisez la valeur de 'autreDomaine' pour 'domaine'
            if ($data->getDomaine() === 'Autres') {
                $forumsponsor->setDomaine($data->getAutreDomaine());
            }
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
