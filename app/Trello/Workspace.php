<?php

namespace App\Trello;

use Osmianski\Helper\Object_;

class Workspace extends Object_
{
    public Trello $trello;
    public string $id;
    public string $name;

    /**
     * @return array|Board[]
     */
    public function getBoards(bool $open = null): array
    {
        return $this->trello->toBoards($this->trello->get(
            $this->trello->boardUrl("organizations/{$this->id}/boards", $open)));
    }
}
