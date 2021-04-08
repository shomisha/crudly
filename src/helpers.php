<?php

if (!function_exists('developerClass')) {
    function developerClass(string $class, array $arguments = []) {
        $arguments = collect($arguments)->map(function (string $value, string $name) {
            return "{$name}:{$value}";
        })->implode(',');

        return "{$class}.{$arguments}";
    }
}
