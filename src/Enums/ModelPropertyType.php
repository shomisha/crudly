<?php

namespace Shomisha\Crudly\Enums;

class ModelPropertyType extends BaseEnum
{
    public static function BOOL(): self
    {
        return new self('boolean');
    }

    public static function STRING(): self
    {
        return new self('string');
    }

    public static function EMAIL(): self
    {
        return new self('email');
    }

    public static function TEXT(): self
    {
        return new self('text');
    }

    public static function INT(): self
    {
        return new self('integer');
    }

    public static function BIG_INT(): self
    {
        return new self('big integer');
    }

    public static function TINY_INT(): self
    {
        return new self('tiny integer');
    }

    public static function FLOAT(): self
    {
        return new self('float');
    }

    public static function DATE(): self
    {
        return new self('date');
    }

    public static function DATETIME(): self
    {
        return new self('datetime');
    }

    public static function TIMESTAMP(): self
    {
        return new self('timestamp');
    }

    public static function JSON(): self
    {
        return new self('json');
    }

    public static function all(): array
    {
        return [
            self::BOOL(),
            self::STRING(),
            self::EMAIL(),
            self::TEXT(),
            self::INT(),
            self::BIG_INT(),
            self::TINY_INT(),
            self::FLOAT(),
            self::DATE(),
            self::DATETIME(),
            self::TIMESTAMP(),
            self::JSON(),
        ];
    }
}
