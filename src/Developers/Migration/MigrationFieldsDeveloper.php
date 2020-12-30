<?php

namespace Shomisha\Crudly\Developers\Migration;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeBlock;
use Shomisha\Stubless\References\Variable;

class MigrationFieldsDeveloper extends MigrationDeveloper
{
    private const DEFAULT_PRIMARY_FIELD_NAME = 'id';

    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification): Code
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

        return Block::fromArray([
            $primaryKeyMigration,
            Block::fromArray($fieldMigrations),
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
        $migrationMethodName = $this->migrationFieldMap()[(string) $specification->getType()];

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

    private function developForeignKeyMigration(ModelPropertySpecification $specification): InvokeBlock
    {
        $method = Block::invokeMethod(
            $this->getTableVar(),
            'foreign',
            [$specification->getName()]
        );

        $method->chain('references', [$specification->getForeignKeyField()])
               ->chain('on', [$specification->getForeignKeyTable()])
               ->chain('onDelete', [(string) $specification->getForeignKeyOnDelete()])
               ->chain('onUpdate', [(string) $specification->getForeignKeyOnUpdate()]);

        return $method;
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
