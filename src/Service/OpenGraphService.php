<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class OpenGraphService
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getOgImage(string $url): ?string
    {
        try {
            $response = $this->httpClient->request('GET', $url);
            $html = $response->getContent();

            // Rechercher la balise <meta property="og:image">
            if (preg_match('/<meta property="og:image" content="([^"]+)"/i', $html, $matches)) {
                return $matches[1];
            }
        } catch (\Exception $e) {
            // Gérer les erreurs (par exemple, si la page n'est pas accessible)
        }

        return null;
    }
}
