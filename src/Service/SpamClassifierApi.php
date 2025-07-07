<?php

namespace C10\SpamBundle\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class SpamClassifierApi
{
    private HttpClientInterface $client;
    private string $apiUrl;
    private string $source;

    public function __construct(HttpClientInterface $client, string $apiUrl, string $source)
    {
        $this->client = $client;
        $this->apiUrl = rtrim($apiUrl, '/');
        $this->source = $source;
    }

    public function classify(string $text): array
    {
        $response = $this->client->request('POST', $this->apiUrl . '/predict', [
            'json' => [
                'text' => $text,
                'source' => $this->source
            ]
        ]);

        return $response->toArray();
    }
}
