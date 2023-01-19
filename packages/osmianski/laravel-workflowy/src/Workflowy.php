<?php

namespace Osmianski\Workflowy;

use Illuminate\Support\Facades\Http;
use Osmianski\SuperObjects\Exceptions\NotImplemented;

class Workflowy
{
    protected const CLIENT_VERSION = 21;
    protected const CLIENT_VERSION_V2 = 28;
    protected const COOKIE_DOMAIN = 'workflowy.com';

    protected ?string $sessionId = null;

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

        return new Workspace(['raw' => $raw]);
    }

    protected function loginBeforeFirstApiCall(): void
    {
        if ($this->sessionId) {
            return;
        }

        $connection = config('workflowy.connections.default');

        $response = Http::asForm()->post('https://workflowy.com/ajax_login', [
            'username' => $connection['username'],
            'password' => $connection['password'],
            'next' => '',
        ]);

        $response->throw();

        if (!($cookie = $response->cookies()->getCookieByName('sessionid'))) {
            throw new NotImplemented();
        }

        $this->sessionId = $cookie->getValue();
    }
}
