<?php

namespace App\Models\Task;

enum Type: string
{
    case Todo = 'todo';
    case Calendar = 'calendar';
    case Delegate = 'delegate';
    case Someday = 'someday';

    public static function parse(string $value): ?Type
    {
        return match(trim($value)) {
            '#todo' => Type::Todo,
            '#calendar' => Type::Calendar,
            '#delegate' => Type::Delegate,
            '#someday' => Type::Someday,
            default => null,
        };
    }
}
