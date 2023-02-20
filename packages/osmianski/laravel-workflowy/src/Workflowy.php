<?php

namespace Osmianski\Workflowy;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Osmianski\Helper\Exceptions\NotImplemented;
use Osmianski\Workflowy\Exceptions\InvalidCredentials;
use Osmianski\Workflowy\Node\Layout;

class Workflowy
{
    protected const CLIENT_VERSION = 21;
    protected const CLIENT_VERSION_V2 = 28;
    protected const COOKIE_DOMAIN = 'workflowy.com';

    protected ?string $sessionId = null;

    protected ?string $username;
    protected ?string $password;

    public function __construct()
    {
        $this->username = env('WORKFLOWY_USERNAME');
        $this->password = env('WORKFLOWY_PASSWORD');
    }

    public function setCredentials(string $username, string $password): void
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function connect(): void
    {
        $this->loginBeforeFirstApiCall();
    }

    public function getWorkspace(): Workspace
    {
        $this->loginBeforeFirstApiCall();

        $query = http_build_query([
            'client_version' => static::CLIENT_VERSION,
            'client_version_v2' => static::CLIENT_VERSION_V2,
        ]);

        $response = Http::asForm()
            ->withCookies(['sessionid' => $this->sessionId], static::COOKIE_DOMAIN)
            ->post("https://workflowy.com/get_initialization_data?{$query}");

        $response->throw();

        $raw = $response->object();

        if (!$raw) {
            throw new NotImplemented();
        }

        return $this->createWorkspace($raw);
    }

    protected function loginBeforeFirstApiCall(): void
    {
        if ($this->sessionId) {
            return;
        }

        $response = Http::asForm()->post('https://workflowy.com/ajax_login', [
            'username' => $this->username,
            'password' => Crypt::decrypt($this->password),
            'next' => '',
        ]);

        $response->throw();

        if (!($cookie = $response->cookies()->getCookieByName('sessionid'))) {
            throw new InvalidCredentials("Couldn't connect to Workflowy as '{$this->username}' using provided password.");
        }

        $this->sessionId = $cookie->getValue();
    }

    protected function createWorkspace(\stdClass $raw): Workspace
    {
        $workspace = new Workspace();

        $workspace->children = $this->createChildren(
            $raw->projectTreeData->mainProjectTreeInfo->rootProjectChildren,
            $workspace,
        );

        return $workspace;
    }

    protected function createChildren(array $raw, Workspace $workspace,
        ?Node $parent = null): array
    {
        $children = [];

        foreach ($raw as $position => $item) {
            $children[] = $this->createNode($item, $workspace, $parent, $position);
        }

        return $children;
    }

    protected function createNode(\stdClass $raw, Workspace $workspace,
        ?Node $parent, int $position): Node
    {
        $node = new Node();

        $node->workspace = $workspace;
        $node->parent = $parent;
        $node->position = $position;
        $node->id = $raw->id;
        $node->name = $raw->nm ?? null;
        $node->note = $raw->no ?? null;
        $node->layout = ($layout = ($this->raw->metadata->layoutMode ?? null))
            ? Layout::tryFrom($layout)
            : null;
        $node->children = $this->createChildren(
            $raw->ch ?? [],
            $workspace,
            $node
        );

        return $node;
    }
}
