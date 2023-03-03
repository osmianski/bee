<?php

namespace App\Trello;

use Illuminate\Support\Carbon;
use Osmianski\Helper\Object_;

class Card extends Object_
{
    public Trello $trello;
    public string $id;
    public string $name;
    public bool $closed;
    public ?Carbon $due;
    /**
     * Minutes to remind before the due date, or `null` if no reminder is set
     *
     * @var int|null
     */
    public ?int $reminder;

    public function update(array $data): void
    {
        $this->trello->put("cards/{$this->id}?" . http_build_query(static::toTrello($data)));
    }

    public static function fromTrello(\stdClass $raw, array $data = []): array
    {
        return array_merge($data, [
            'id' => $raw->id,
            'name' => $raw->name,
            'closed' => $raw->closed,
            'due' => $raw->due ? Carbon::parse($raw->due, 'UTC') : null,
            'reminder' => $raw->dueReminder !== -1 ? $raw->dueReminder : null,
        ]);
    }

    public static function toTrello(array $data): array
    {
        $result = [];

        if (array_key_exists('name', $data)) {
            $result['name'] = $data['name'];
        }

        if (array_key_exists('closed', $data)) {
            $result['closed'] = $data['closed'];
        }

        if (array_key_exists('due', $data)) {
            $result['due'] = $data['due']->toString();
        }

        if (array_key_exists('reminder', $data)) {
            $result['dueReminder'] = $data['reminder'] !== null ? $data['reminder'] : -1;
        }

        return $result;
    }
}
