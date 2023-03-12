<?php

namespace App\Trello;

use Osmianski\Helper\Exceptions\NotImplemented;
use Osmianski\Helper\Object_;

class List_ extends Object_
{
    public Trello $trello;
    public string $id;
    public string $name;
    public bool $archived;

    public static function fromTrello(\stdClass $raw, array $data = []): array
    {
        return array_merge($data, [
            'id' => $raw->id,
            'name' => $raw->name,
            'archived' => $raw->closed,
        ]);
    }

    /**
     * @return array|Card[]
     */
    public function getCards(): array
    {
        return $this->trello->toCards($this->trello->get("lists/{$this->id}/cards"));
    }

    public function createCard(array $data): Card
    {
        $raw = $this->trello->post("cards?" . http_build_query(array_merge(
            Card::toTrello($data),
            ['idList' => $this->id]
        )));

        return new Card(Card::fromTrello($raw, ['trello' => $this->trello]));
    }
}
