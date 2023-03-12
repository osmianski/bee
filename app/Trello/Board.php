<?php

namespace App\Trello;

use Osmianski\Helper\Exceptions\NotImplemented;
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

    public function getLists(bool $archived = null): array
    {
        return $this->trello->toLists($this->trello->get(
            $this->trello->listUrl("boards/{$this->id}/lists", $archived)));
    }

    public function getListByName(string $name): ?List_
    {
        foreach ($this->getLists(archived: false) as $list) {
            if (trim($list->name) === trim($name)) {
                return $list;
            }
        }

        return null;
    }
}
