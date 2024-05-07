<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    private $dompdf;

    public function __construct(Dompdf $dompdf)
    {
        $this->dompdf = $dompdf;
    }

    /**
     * @Route("/generate-pdf", name="generate_pdf")
     */
    public function generatePdf(): Response
    {
        // Retrieve tickets data (replace this with your actual data retrieval logic)
        $tickets = $this->getDoctrine()->getRepository('App\Entity\Ticket')->findAll();

        // Render the ticket table template with the tickets data
        $html = $this->renderView('pdfticket.html.twig', [
            'tickets' => $tickets,
        ]);

        // Load the rendered HTML content into Dompdf
        $this->dompdf->loadHtml($html);

        // Set paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $this->dompdf->render();

        // Output the PDF content
        $pdfContent = $this->dompdf->output();

        // Create a Symfony response with PDF content
        $response = new Response($pdfContent);

        // Set response headers for PDF download
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment; filename="document.pdf"');

        return $response;
    }
}
