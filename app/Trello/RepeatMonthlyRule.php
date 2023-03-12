<?php

namespace App\Trello;

use Osmianski\Helper\Object_;

class RepeatMonthlyRule extends Object_
{
    public int $day;
    public string $name;
    public string $list;
    public string $board;
    public string $workspace;
}
