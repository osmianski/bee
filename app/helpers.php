<?php

function is_nav_item_active(array $item): bool
{
    if (!isset($item['route'])) {
        return false;
    }

    $request = request();

    if ($request->routeIs($item['route'])) {
        return true;
    }
    if (isset($item['is_directory']) && ($name = $request->route()?->getName())) {
        return str_starts_with($name, $item['route'] . '.');
    }

    return false;
}
