<?php

namespace App\Trello;

use Osmianski\Helper\Exceptions\NotImplemented;
use Osmianski\Helper\Object_;

class Member extends Object_
{
    public Trello $trello;
    public string $id;
    public string $username;
    public string $name;

    public static function fromTrello(\stdClass $raw, array $data = []): array
    {
        return array_merge($data, [
            'id' => $raw->id,
            'username' => $raw->username,
            'name' => $raw->fullName,
        ]);
    }
}
