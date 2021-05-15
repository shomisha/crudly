<?php

namespace Shomisha\Crudly\Enums;

class ForeignKeyAction extends BaseEnum
{
    public static function CASCADE(): self
    {
        return new self('cascade');
    }

    public static function SET_NULL(): self
    {
        return new self('set null');
    }

    public static function NO_ACTION(): self
    {
        return new self('no action');
    }

    public static function all(): array
    {
        return [
            self::CASCADE(),
            self::SET_NULL(),
            self::NO_ACTION(),
        ];
    }
}
