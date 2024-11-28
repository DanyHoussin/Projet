<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;


// function getPlayerStats($steam_id, $api_key) {
//     $app_id = "389730"; // Tekken 7
//     $url = "http://api.steampowered.com/ISteamUserStats/GetUserStatsForGame/v0002/?appid=$app_id&key=$api_key&steamid=$steam_id";

//     $response = file_get_contents($url);
//     if ($response) {
//         return json_decode($response, true);
//     }
//     return null;
// }

class SteamApiService
{
    private HttpClientInterface $client;
    private string $apiKey;

    public function __construct(HttpClientInterface $client, string $steamApiKey)
    {
        $this->client = $client;
        $this->apiKey = $steamApiKey;
    }

    public function getPlayerSummary(string $steamId): array
    {
        $response = $this->client->request('GET', 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/', [
            'query' => [
                'key' => $this->apiKey,
                'steamids' => $steamId,
            ],
        ]);

        return $response->toArray()['response']['players'][0] ?? [];
    }

    public function getOwnedGames(string $steamId): array
    {
        $response = $this->client->request('GET', 'http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/', [
            'query' => [
                'key' => $this->apiKey,
                'steamid' => $steamId,
                'include_appinfo' => true,
                'include_played_free_games' => true,
                'format' => 'json',
            ],
        ]);

        return $response->toArray()['response']['games'] ?? [];
    }
}