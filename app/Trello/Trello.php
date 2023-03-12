<?php

namespace App\Trello;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Osmianski\Helper\Exceptions\NotImplemented;
use Osmianski\Helper\Object_;

/**
 * @property string $api_key
 * @property string $token
 */
class Trello extends Object_
{
    public string $base_url = 'https://api.trello.com/1/';

    protected function get_api_key(): string
    {
        return env('TRELLO_API_KEY');
    }

    protected function get_token(): string
    {
        return env('TRELLO_TOKEN');
    }

    /**
     * @return array|Board[]
     */
    public function getMe(): Member
    {
        return new Member(Member::fromTrello($this->get('members/me'), ['trello' => $this]));
    }

    public function getBoards(bool $open = null): array
    {
        return $this->toBoards($this->get($this->boardUrl('members/me/boards', $open)));
    }

    /**
     * @return array|Workspace[]
     */
    public function getWorkspaces(): array
    {
        return $this->toWorkspaces($this->get('members/me/organizations'));
    }

    public function getWorkspaceByName(string $name): ?Workspace
    {
        foreach ($this->getWorkspaces() as $workspace) {
            if (trim($workspace->name) === trim($name)) {
                return $workspace;
            }
        }

        return null;
    }

    protected function urlCredentials(): string
    {
        return http_build_query([
            'key' => $this->api_key,
            'token' => Crypt::decrypt($this->token),
        ]);
    }

    public function get(string $url): \stdClass|array
    {
        $delimiter = str_contains($url, '?') ? '&' : '?';
        $response = Http::get("{$this->base_url}{$url}{$delimiter}{$this->urlCredentials()}");

        $response->throw();

        return $response->object();
    }

    public function put(string $url): void
    {
        $delimiter = str_contains($url, '?') ? '&' : '?';
        $response = Http::put("{$this->base_url}{$url}{$delimiter}{$this->urlCredentials()}");

        $response->throw();
    }

    public function post(string $url): \stdClass|array
    {
        $delimiter = str_contains($url, '?') ? '&' : '?';
        $response = Http::post("{$this->base_url}{$url}{$delimiter}{$this->urlCredentials()}");

        $response->throw();

        return $response->object();
    }

    /**
     * @return array|Workspace[]
     */
    public function toWorkspaces(array $response): array
    {
        return collect($response)
            ->map(fn(\stdClass $raw) => new Workspace([
                'trello' => $this,
                'id' => $raw->id,
                'name' => $raw->displayName,
            ]))
            ->keyBy('id')
            ->toArray();
    }

    public function toBoards(array $response): array
    {
        return collect($response)
            ->map(fn(\stdClass $raw) => new Board([
                'trello' => $this,
                'id' => $raw->id,
                'name' => $raw->name,
                'closed' => $raw->closed,
            ]))
            ->keyBy('id')
            ->toArray();
    }

    public function toCards(array $response): array
    {
        return collect($response)
            ->map(fn(\stdClass $raw) => new Card(Card::fromTrello($raw, [ 'trello' => $this ])))
            ->keyBy('id')
            ->toArray();
    }

    public function toLists(array $response): array
    {
        return collect($response)
            ->map(fn(\stdClass $raw) => new List_(List_::fromTrello($raw, [ 'trello' => $this ])))
            ->keyBy('id')
            ->toArray();
    }

    public function boardUrl(string $url, ?bool $open): string
    {
        $query = [];
        if ($open !== null) {
            $query['filter'] = $open ? 'open' : 'closed';
        }

        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        return $url;
    }

    public function cardUrl(string $url, ?bool $open): string
    {
        $query = [];
        if ($open !== null) {
            $query['filter'] = $open ? 'open' : 'closed';
        }

        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        return $url;
    }

    public function listUrl(string $url, ?bool $archived): string
    {
        $query = [];
        if ($archived !== null) {
            $query['filter'] = $archived ? 'closed' : 'open';
        }

        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        return $url;
    }
}
