<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class WeatherService
{
    public function getWeatherByCity(string $city): ?array
    {
        try {
            $apiKey = env('OPENWEATHER_API_KEY');
            $client = new Client();

            $geoUrl = "http://api.openweathermap.org/geo/1.0/direct?q={$city},BD&limit=1&appid={$apiKey}";
            $response = $client->get($geoUrl);
            $geoData = json_decode($response->getBody(), true);

            if (empty($geoData)) {
                return null;
            }

            $lat = $geoData[0]['lat'];
            $lon = $geoData[0]['lon'];

            $weatherUrl = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$apiKey}&units=metric";
            $response = $client->get($weatherUrl);
            $data = json_decode($response->getBody(), true);

            return [
                'city'        => $data['name'],
                'temperature' => $data['main']['temp'],
                'description' => $data['weather'][0]['description'],
                'humidity'    => $data['main']['humidity'],
                'wind'        => $data['wind']['speed'],
                'icon'        => $data['weather'][0]['icon'],
            ];
        } catch (Exception $e) {
            return null;
        }
    }
}