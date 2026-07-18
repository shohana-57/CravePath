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

            $geoData = $this->geocodeCity($client, $city, $apiKey);

            if ($geoData) {
                $lat = $geoData[0]['lat'];
                $lon = $geoData[0]['lon'];

                return $this->getWeatherByCoordinates($client, $lat, $lon, $apiKey);
            }

            $fallbackCity = $this->fallbackCityName($city);
            if ($fallbackCity) {
                return $this->getWeatherByCityName($client, $fallbackCity, $apiKey);
            }

            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    private function geocodeCity(Client $client, string $city, string $apiKey): ?array
    {
        $response = $client->get('http://api.openweathermap.org/geo/1.0/direct', [
            'query' => [
                'q'     => "{$city},BD",
                'limit' => 1,
                'appid' => $apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true) ?: null;
    }

    private function getWeatherByCoordinates(Client $client, float $lat, float $lon, string $apiKey): ?array
    {
        $response = $client->get('https://api.openweathermap.org/data/2.5/weather', [
            'query' => [
                'lat'   => $lat,
                'lon'   => $lon,
                'appid' => $apiKey,
                'units' => 'metric',
            ],
        ]);

        return $this->formatWeatherData(json_decode($response->getBody(), true));
    }

    private function getWeatherByCityName(Client $client, string $city, string $apiKey): ?array
    {
        $response = $client->get('https://api.openweathermap.org/data/2.5/weather', [
            'query' => [
                'q'     => "{$city},BD",
                'appid' => $apiKey,
                'units' => 'metric',
            ],
        ]);

        return $this->formatWeatherData(json_decode($response->getBody(), true));
    }

    private function formatWeatherData(array $data): ?array
    {
        if (empty($data['main']['temp'] ?? null) || empty($data['weather'][0] ?? null)) {
            return null;
        }

        return [
            'city'        => $data['name'],
            'temperature' => $data['main']['temp'],
            'description' => $data['weather'][0]['description'],
            'humidity'    => $data['main']['humidity'],
            'wind'        => $data['wind']['speed'],
            'icon'        => $data['weather'][0]['icon'],
        ];
    }

    private function fallbackCityName(string $city): ?string
    {
        $parts = preg_split('/[\s,]+/', trim($city));

        return end($parts) ?: null;
    }
}