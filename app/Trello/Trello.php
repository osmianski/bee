<?php

namespace App\Trello;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class Trello
{
    protected string $baseUrl = 'https://api.trello.com/1/';
    protected ?string $apiKey;
    protected ?string $token;

    public function __construct()
    {
        $this->apiKey = env('TRELLO_API_KEY');
        $this->token = env('TRELLO_TOKEN');
    }

    public function setCredentials(string $apiKey, string $token): void
    {
        $this->apiKey = $apiKey;
        $this->token = $token;
    }

    public function getBoards(): array
    {
        $response = $this->get('members/me/boards');

        return collect($response->object())
            ->map(fn(\stdClass $raw) => new Board([
                'id' => $raw->id,
                'name' => $raw->name,
                'closed' => $raw->closed,
            ]))
            ->keyBy('id')
            ->toArray();
    }

    public function getWorkspaces(): array
    {
        $response = $this->get('members/me/organizations');

        return collect($response->object())
            ->map(fn(\stdClass $raw) => new Workspace([
                'id' => $raw->id,
                'name' => $raw->displayName,
            ]))
            ->keyBy('id')
            ->toArray();
    }

    protected function urlCredentials(): string
    {
        return http_build_query([
            'key' => $this->apiKey,
            'token' => Crypt::decrypt($this->token),
        ]);
    }

    public function get(string $url): Response
    {
        $delimiter = str_contains($url, '?') ? '&' : '?';
        $response = Http::get("{$this->baseUrl}{$url}{$delimiter}{$this->urlCredentials()}");

        $response->throw();

        return $response;
    }
}
