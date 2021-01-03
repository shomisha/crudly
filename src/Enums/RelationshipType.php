<?php

namespace Shomisha\Crudly\Enums;

class RelationshipType extends BaseEnum
{
    public static function HAS_ONE(): self
    {
        return new self('hasOne');
    }

    public static function BELONGS_TO(): self
    {
        return new self('belongsTo');
    }

    public static function all(): array
    {
        return [
            self::HAS_ONE(),
            self::BELONGS_TO(),
        ];
    }
}
