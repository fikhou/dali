<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    /**
     * @Route("/send-email", name="send_email", methods={"POST"})
     */
    public function sendEmail(Request $request, MailerInterface $mailer): Response
    {
        // Retrieve form data from the request
        $name = $request->request->get('name');
        $emailAddress = $request->request->get('email');
        $subject = $request->request->get('subject');
        $messageBody = $request->request->get('message');

        // Create the email message
        $email = (new Email())
            ->from('hammamif750@gmail.com')
            ->to($emailAddress) // Set the recipient's email address
            ->subject($subject)
            ->text("Name: $name\nEmail: $emailAddress\nMessage: $messageBody");

        // Send the email using the configured mailer
        $mailer->send($email);

        // Optionally, add a flash message
        $this->addFlash('success', 'Your message has been sent successfully.');

        // Redirect to a success page or back to the form page
        return $this->redirectToRoute('app_Contact'); // Update with your form route
    }
}
