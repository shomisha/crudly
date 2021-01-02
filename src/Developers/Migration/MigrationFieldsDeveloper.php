<?php

namespace Shomisha\Crudly\Developers\Migration;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeBlock;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Variable;

class MigrationFieldsDeveloper extends MigrationDeveloper
{
    private const DEFAULT_PRIMARY_FIELD_NAME = 'id';

    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $primaryKey = $specification->getPrimaryKey();
        $otherFields = $specification->getProperties()->except($primaryKey->getName());

        $primaryKeyMigration = $this->developPrimaryKeyMigration($primaryKey);

        $fieldMigrations = [];
        $foreignKeyMigrations = [];
        foreach ($otherFields as $field) {
            $fieldMigrations[] = $this->developFieldMigration($field);

            if ($field->isForeignKey()) {
                $foreignKeyMigrations[] = $this->developForeignKeyMigration($field);
            }
        }

        $extraMigrations = [];
        if (
            $specification->hasSoftDeletion() &&
            $columnDefinition = $this->developSoftDeleteMigration($specification)
        ) {
            $extraMigrations[] = $columnDefinition;
        }

        if ($specification->hasTimestamps()) {
            $extraMigrations[] = $this->developTimestampsMigration();
        }

        return Block::fromArray([
            $primaryKeyMigration,
            Block::fromArray($fieldMigrations),
            Block::fromArray($extraMigrations),
            Block::fromArray($foreignKeyMigrations),
        ]);
    }

    private function developPrimaryKeyMigration(ModelPropertySpecification $specification): InvokeBlock
    {
        if ($specification->isInt()) {
            $arguments = [];
            if ($specification->getName() !== self::DEFAULT_PRIMARY_FIELD_NAME) {
                $arguments[] = $specification->getName();
            }

            return Block::invokeMethod($this->getTableVar(), 'id', $arguments);
        }

        return $this->developFieldMigration($specification)->chain('primary');
    }

    private function developFieldMigration(ModelPropertySpecification $specification): InvokeBlock
    {
        $migrationMethodName = $this->getMigrationFieldMethod($specification->getType());

        $method = Block::invokeMethod(
            $this->getTableVar(),
            $migrationMethodName,
            [
                $specification->getName()
            ]
        );

        if ($specification->isNullable()) {
            $method->chain('nullable');
        }

        if ($specification->isUnsigned()) {
            $method->chain('unsigned');
        }

        if ($specification->isUnique()) {
            $method->chain('unique');
        }

        return $method;
    }

    private function getMigrationFieldMethod(ModelPropertyType $type): string
    {
        return $this->migrationFieldMap()[(string) $type];
    }

    private function developForeignKeyMigration(ModelPropertySpecification $specification): InvokeBlock
    {
        $method = Block::invokeMethod(
            $this->getTableVar(),
            'foreign',
            [$specification->getName()]
        );

        $foreignKeySpecification = $specification->getForeignKeySpecification();

        $method->chain('references', [$foreignKeySpecification->getForeignKeyField()])
               ->chain('on', [$foreignKeySpecification->getForeignKeyTable()])
               ->chain('onDelete', [(string) $foreignKeySpecification->getForeignKeyOnDelete()])
               ->chain('onUpdate', [(string) $foreignKeySpecification->getForeignKeyOnUpdate()]);

        return $method;
    }

    private function developSoftDeleteMigration(CrudlySpecification $specification): ?InvokeMethodBlock
    {
        if ($columnName = $specification->softDeletionColumnName()) {
            return null;
        }

        return Block::invokeMethod(
            $this->getTableVar(),
            'softDeletes',
            [
                $specification->softDeletionColumnDefinition()->getName()
            ]
        );
    }

    private function developTimestampsMigration(): InvokeMethodBlock
    {
        return Block::invokeMethod(
            $this->getTableVar(),
            'timestamps'
        );
    }

    private function getTableVar(): Variable
    {
        return Variable::name('table');
    }

    private function migrationFieldMap(): array
    {
        return [
            (string) ModelPropertyType::BOOL() => 'boolean',
            (string) ModelPropertyType::STRING() => 'string',
            (string) ModelPropertyType::EMAIL() => 'string',
            (string) ModelPropertyType::TEXT() => 'text',
            (string) ModelPropertyType::INT() => 'integer',
            (string) ModelPropertyType::BIG_INT() => 'bigInteger',
            (string) ModelPropertyType::TINY_INT() => 'tinyInteger',
            (string) ModelPropertyType::FLOAT() => 'float',
            (string) ModelPropertyType::DATE() => 'date',
            (string) ModelPropertyType::DATETIME() => 'dateTime',
            (string) ModelPropertyType::JSON() => 'json',
        ];
    }
}
