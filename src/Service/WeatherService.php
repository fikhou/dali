<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService
{
    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, $apiKey)
    {
        $this->client = $client;
        $this->apiKey = 'bf9b72083b8add6bc264e053f8bc74eb'; // Enclose the API key in quotes
    }

    public function getWeatherForecast($city)
    {

    
        $response = $this->client->request('GET', 'http://api.openweathermap.org/data/2.5/forecast', [
            'query' => [
                'q' => $city,
                'appid' => $this->apiKey,
                'units' => 'metric', // Pour avoir la température en degrés Celsius
                'cnt' => 40 // Nombre de prévisions de 3 heures, 40 couvre 5 jours
            ]
        ]);

        if ($response->getStatusCode() === 200) {
            // La réponse est OK, retourner les données.
            return [
                'data' => $response->toArray(),
                'error' => null
            ];
        } else {
            // Il y a eu un problème, retourner un message d'erreur.
            return [
                'data' => null,
                'error' => "La ville spécifiée est invalide."
            ];
        }

        return $response->toArray();
       
    }
}