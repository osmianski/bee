<?php

namespace App\Integrations;

use App\Exceptions\NotImplemented;
use Illuminate\Support\Facades\Http;

class Workflowy
{
    protected const CLIENT_VERSION = 21;
    protected const CLIENT_VERSION_V2 = 28;
    protected const DOMAIN = 'workflowy.com';

    protected ?string $sessionId = null;

    public function all(): \stdClass | null {
        $this->loginBeforeFirstApiCall();

        $query = http_build_query([
            'client_version' => static::CLIENT_VERSION,
            'client_version_v2' => static::CLIENT_VERSION_V2,
        ]);

        $response = Http::asForm()
            ->withCookies(['sessionid' => $this->sessionId], static::DOMAIN)
            ->post("https://workflowy.com/get_initialization_data?{$query}");

        $response->throw();

        return $response->object();
    }

    protected function loginBeforeFirstApiCall(): void
    {
        if ($this->sessionId) {
            return;
        }

        $response = Http::asForm()->post('https://workflowy.com/ajax_login', [
            'username' => env('WORKFLOWY_USERNAME'),
            'password' => env('WORKFLOWY_PASSWORD'),
            'next' => '',
        ]);

        $response->throw();

        $this->sessionId = $response->cookies()
            ->getCookieByName('sessionid')->getValue();
    }
}
