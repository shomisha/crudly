<?php

namespace Shomisha\Crudly\Enums;

abstract class BaseEnum
{
    private string $value;

    protected function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }

    public static function fromString(string $value): self
    {
        if (!in_array($value, static::all())) {
            throw new \InvalidArgumentException(sprintf(
                "Invalid value '%s' for enum class %s",
                $value,
                static::class
            ));
        }

        return new static($value);
    }

    abstract public static function all(): array;
}
