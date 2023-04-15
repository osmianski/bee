<?php

namespace App\Trello\Rule;

use App\Trello\Rule;

class RepeatQuarterly extends Rule
{
    public int $month;
    public int $day;
}
