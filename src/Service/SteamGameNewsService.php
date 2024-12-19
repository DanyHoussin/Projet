<?php
namespace App\Service;

use App\Service\OpenGraphService;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SteamGameNewsService
{
    private HttpClientInterface $httpClient;
    private OpenGraphService $openGraphService;

    public function __construct(HttpClientInterface $httpClient, OpenGraphService $openGraphService)
    {
        $this->httpClient = $httpClient;
        $this->openGraphService = $openGraphService;
    }

    public function getGameNews(int $appId, int $count = 5, int $maxLength = 300): array
    {
        $url = "https://api.steampowered.com/ISteamNews/GetNewsForApp/v2/";

        try {
            $response = $this->httpClient->request('GET', $url, [
                'query' => [
                    'appid' => $appId,
                    'count' => $count,
                    'maxlength' => $maxLength,
                    'format' => 'json',
                ]
            ]);

            $data = $response->toArray();

            if (!isset($data['appnews']['newsitems'])) {
                return [];
            }

            $filteredNews = array_filter($data['appnews']['newsitems'], function ($newsItem) {
                return $newsItem['feedname'] !== 'Gamemag.ru';
            });

            return array_values($filteredNews);
        } catch (\Exception $e) {
            // Gérer les erreurs (journalisation, retour d'une valeur par défaut, etc.)
            return [];
        }
    }
    
    public function getGameNewsWithImages(int $appId, int $count = 5): array
    {
        // Récupérer les actualités
        $newsItems = $this->getGameNews($appId, $count);

        // Ajouter les images
        $newsWithImages = [];
        foreach ($newsItems as $newsItem) {
            $newsItem['image'] = null; // Par défaut, aucune image

            // Si l'actualité est externe, essayer de récupérer une image
            if ($newsItem['is_external_url']) {
                $newsItem['image'] = $this->openGraphService->getOgImage($newsItem['url']);
            }

            $newsWithImages[] = $newsItem;
        }

        return $newsWithImages;
    }
}
