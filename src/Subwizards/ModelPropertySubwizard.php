<?php

namespace Shomisha\Crudly\Subwizards;

use Shomisha\Crudly\Enums\ForeignKeyAction;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Enums\RelationshipType;
use Shomisha\LaravelConsoleWizard\Command\Subwizard;
use Shomisha\LaravelConsoleWizard\Contracts\Step;
use Shomisha\LaravelConsoleWizard\Steps\ChoiceStep;
use Shomisha\LaravelConsoleWizard\Steps\ConfirmStep;
use Shomisha\LaravelConsoleWizard\Steps\OneTimeWizard;
use Shomisha\LaravelConsoleWizard\Steps\TextStep;

class ModelPropertySubwizard extends Subwizard
{
    function getSteps(): array
    {
        return [
            'name' => new TextStep('Enter property name'),
            'type' => new ChoiceStep('Choose property type', ModelPropertyType::all()),
            'is_unique' => new ConfirmStep('Should this field be unique?'),
            'is_nullable' => new ConfirmStep('Should this field be nullable?'),
        ];
    }

    public function answeredType(Step $step, string $type)
    {
        if ($this->canBeUnsigned($type)) {
            $this->followUp('is_unsigned', new ConfirmStep('Should this field be unsigned?'));
        }

        if ($this->canBeAutoIncrement($type)) {
            $this->followUp('is_autoincrement', new ConfirmStep('Should this field be auto-increment?'));
        }

        return $type;
    }

    public function answeredIsAutoincrement(Step $step, bool $isAutoIncrement)
    {
        if ($isAutoIncrement) {
            $this->followUp('is_primary', new ConfirmStep('Should this property be the primary key?'));
        }

        return $isAutoIncrement;
    }

    public function answeredIsNullable(Step $step, bool $isNullable)
    {
        if ($this->canBeForeignKey($this->answers->get('type'))) {
            $this->followUp('is_foreign_key', new ConfirmStep('Should this field be a foreign key?'));
        }

        return $isNullable;
    }

    public function answeredIsForeignKey(Step $step, bool $isForeignKey)
    {
        if ($isForeignKey) {
            $this->followUp('foreign_key_target', $this->subWizard(new RelationshipSubwizard()));
        }

        return $isForeignKey;
    }

    private function canBeForeignKey(string $fieldType): bool
    {
        return in_array($fieldType, [
            ModelPropertyType::STRING(),
            ModelPropertyType::TEXT(),
            ModelPropertyType::INT(),
            ModelPropertyType::BIG_INT(),
            ModelPropertyType::TINY_INT(),
        ]);
    }

    private function canBeAutoIncrement(string $fieldType): bool
    {
        return in_array($fieldType, [
            ModelPropertyType::INT(),
            ModelPropertyType::BIG_INT(),
            ModelPropertyType::TINY_INT(),
        ]);
    }

    private function canBeUnsigned(string $fieldType): bool
    {
        return in_array($fieldType, [
            ModelPropertyType::INT(),
            ModelPropertyType::BIG_INT(),
            ModelPropertyType::TINY_INT(),
            ModelPropertyType::FLOAT(),
        ]);
    }
}
