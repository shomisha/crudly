<?php

if (!function_exists('configureDeveloper')) {
    function configureDeveloper(string $class, array $arguments = []) {
        $arguments = collect($arguments)->map(function (string $value, string $name) {
            return "{$name}:{$value}";
        })->implode(',');

        return "{$class}.{$arguments}";
    }
}
