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

    public static function DO_NOTHING(): self
    {
        return new self('do nothing');
    }

    public static function all(): array
    {
        return [
            self::CASCADE(),
            self::SET_NULL(),
            self::DO_NOTHING(),
        ];
    }
}
