<?php

namespace App\Trello;

use Osmianski\Helper\Object_;

class Board extends Object_
{
    public string $id;
    public string $name;
    public bool $closed;
}
