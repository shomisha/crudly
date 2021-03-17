<?php

namespace Shomisha\Crudly\Specifications;

use Shomisha\Crudly\Abstracts\Specification;
use Shomisha\Crudly\Enums\ForeignKeyAction;

class ForeignKeySpecification extends Specification
{
    private const
        KEY_FOREIGN_KEY_TABLE = 'table',
        KEY_FOREIGN_KEY_FIELD = 'field',
        KEY_HAS_RELATIONSHIP = 'has_relationship',
        KEY_RELATIONSHIP_NAME = 'relationship.name',
        KEY_FOREIGN_KEY_ON_DELETE = 'on_delete',
        KEY_FOREIGN_KEY_ON_UPDATE = 'on_update';

    public function getForeignKeyTable(): ?string
    {
        return $this->extract(self::KEY_FOREIGN_KEY_TABLE);
    }

    public function getForeignKeyField(): ?string
    {
        return $this->extract(self::KEY_FOREIGN_KEY_FIELD);
    }

    public function hasRelationship(): bool
    {
        return $this->extract(self::KEY_HAS_RELATIONSHIP);
    }

    public function getRelationshipName(): ?string
    {
        return $this->extract(self::KEY_RELATIONSHIP_NAME);
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
