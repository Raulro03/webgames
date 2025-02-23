<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class IGDBService {
    private $clientId;
    private $clientSecret;
    private $accessToken;

    public function __construct()
    {
        $this->clientId = config('services.igdb.client_id');
        $this->clientSecret = config('services.igdb.client_secret');
        $this->authenticate();
    }

    private function authenticate()
    {
        $response = Http::post('https://id.twitch.tv/oauth2/token', [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'client_credentials',
        ]);

        $this->accessToken = $response->json()['access_token'];
    }

    public function getTopGamesByPopularity($limit = 10)
    {
        $response = Http::withHeaders([
            'Client-ID' => $this->clientId,
            'Authorization' => 'Bearer ' . $this->accessToken,
        ])->withBody("
            fields game_id, value, popularity_type;
            sort value desc;
            limit $limit;
            where popularity_type = 1;
        ", 'text/plain')->post('https://api.igdb.com/v4/popularity_primitives');

        $popularGames = $response->json();

        return collect($popularGames)->map(function ($game) {
            return $this->getGameDetails($game['game_id']);
        });
    }

    private function getGameDetails($gameId)
    {
        $response = Http::withHeaders([
            'Client-ID' => $this->clientId,
            'Authorization' => 'Bearer ' . $this->accessToken,
        ])->withBody("
            fields name, cover.url, rating, url;
            where id = $gameId;
        ", 'text/plain')->post('https://api.igdb.com/v4/games');

        return $response->json()[0] ?? null;
    }
}
