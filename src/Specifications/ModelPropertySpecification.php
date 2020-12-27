<?php

namespace Shomisha\Crudly\Specifications;

use Shomisha\Crudly\Abstracts\Specification;
use Shomisha\Crudly\Enums\ForeignKeyAction;
use Shomisha\Crudly\Enums\ModelPropertyType;

class ModelPropertySpecification extends Specification
{
    private const
        KEY_NAME = 'name',
        KEY_TYPE = 'type',
        KEY_AUTOINCREMENT = 'is_autoincrement',
        KEY_UNSIGNED = 'is_unsigned',
        KEY_UNIQUE = 'is_unique',
        KEY_NULLABLE = 'is_nullable',
        KEY_FOREIGN_KEY = 'is_foreign_key',
        KEY_PRIMARY_KEY = 'is_primary',
        KEY_FOREIGN_KEY_TABLE = 'foreign_key_target.table',
        KEY_FOREIGN_KEY_FIELD = 'foreign_key_target.field',
        KEY_FOREIGN_KEY_ON_DELETE = 'foreign_key_target.on_delete',
        KEY_FOREIGN_KEY_ON_UPDATE = 'foreign_key_target.on_update';

    public function getName(): string
    {
        return $this->extract(self::KEY_NAME);
    }

    public function getType(): ModelPropertyType
    {
        return ModelPropertyType::fromString($this->extract(self::KEY_TYPE));
    }

    public function isAutoincrement(): bool
    {
        return $this->extract(self::KEY_AUTOINCREMENT);
    }

    public function isUnsigned(): bool
    {
        return $this->extract(self::KEY_UNSIGNED) ?? false;
    }

    public function isUnique(): bool
    {
        return $this->extract(self::KEY_UNIQUE);
    }

    public function isNullable(): bool
    {
        return $this->extract(self::KEY_NULLABLE);
    }

    public function isForeignKey(): bool
    {
        return $this->extract(self::KEY_FOREIGN_KEY);
    }

    public function isInt(): bool
    {
        return in_array($this->getType(), [
            ModelPropertyType::TINY_INT(),
            ModelPropertyType::INT(),
            ModelPropertyType::BIG_INT(),
        ]);
    }

    public function isString(): bool
    {
        return in_array($this->getType(), [
            ModelPropertyType::STRING(),
            ModelPropertyType::EMAIL(),
            ModelPropertyType::TEXT(),
        ]);
    }

    public function isPrimaryKey(): bool
    {
        return $this->extract(self::KEY_PRIMARY_KEY) ?? false;
    }

    public function getForeignKeyTable(): ?string
    {
        return $this->extract(self::KEY_FOREIGN_KEY_TABLE);
    }

    public function getForeignKeyField(): ?string
    {
        return $this->extract(self::KEY_FOREIGN_KEY_FIELD);
    }

    public function getForeignKeyOnDelete(): ForeignKeyAction
    {
        return ForeignKeyAction::fromString(
            $this->extract(self::KEY_FOREIGN_KEY_ON_DELETE)
        );
    }

    public function getForeignKeyOnUpdate(): ForeignKeyAction
    {
        return ForeignKeyAction::fromString(
            $this->extract(self::KEY_FOREIGN_KEY_ON_UPDATE)
        );
    }
}
