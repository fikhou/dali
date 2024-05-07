<?php


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecaptchaController extends AbstractController
{
    /**
     * @Route("/generate-request", name="generate_request")
     */
    public function generateRequest(): Response
    {
        // Replace TOKEN and USER_ACTION with actual values
        $token = 'YOUR_TOKEN_HERE';
        $userAction = 'YOUR_USER_ACTION_HERE';

        // Define the request body array
        $requestBody = [
            'event' => [
                'token' => $token,
                'expectedAction' => $userAction,
                'siteKey' => '6LdMJ8spAAAAAEWaYwHAXp6tiQpZUNNxGd4vsdKa',
            ],
        ];

        // Convert array to JSON format
        $jsonContent = json_encode($requestBody, JSON_PRETTY_PRINT);

        // Define the file path and name
        $filePath = $this->getParameter('kernel.project_dir') . '/request.json';

        // Write JSON content to file
        file_put_contents($filePath, $jsonContent);

        return $this->json(['message' => 'Request JSON file generated successfully.']);
    }
}
