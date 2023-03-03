<?php

namespace App\Trello;

use Osmianski\Helper\Object_;

class Board extends Object_
{
    public Trello $trello;
    public string $id;
    public string $name;
    public bool $closed;

    /**
     * @param ?bool $open
     * @return array|Card[]
     */
    public function getCards(bool $open = null): array
    {
        return $this->trello->toCards($this->trello->get(
            $this->trello->cardUrl("boards/{$this->id}/cards", $open)));
    }
}
