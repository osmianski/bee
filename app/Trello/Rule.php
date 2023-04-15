<?php

namespace App\Trello;

use Osmianski\Helper\Object_;

class Rule extends Object_
{
    public string $name;
    public string $list;
    public string $board;
    public string $workspace;
}
