<?php

namespace App\Models\Project;

enum Type: string
{
    case Project = 'project';
    case Area = 'area';

    public static function parse(string $value): ?Type
    {
        return match($value) {
            '🏁' => Type::Project,
            '🌍' => Type::Area,
            default => null,
        };
    }
}
