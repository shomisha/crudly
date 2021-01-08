<?php

namespace Shomisha\Crudly\Subwizards;

use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\LaravelConsoleWizard\Command\Subwizard;
use Shomisha\LaravelConsoleWizard\Contracts\Step;
use Shomisha\LaravelConsoleWizard\Steps\ChoiceStep;
use Shomisha\LaravelConsoleWizard\Steps\ConfirmStep;
use Shomisha\LaravelConsoleWizard\Steps\TextStep;

class ModelPropertySubwizard extends Subwizard
{
    function getSteps(): array
    {
        return [
            'name' => new TextStep('Enter property name'),
            'type' => new ChoiceStep('Choose property type', ModelPropertyType::all()),
            'is_unsigned' => new ConfirmStep('Should this field be unsigned?'),
            'is_autoincrement' => new ConfirmStep('Should this field be auto-increment?'),
            'is_unique' => new ConfirmStep('Should this field be unique?'),
            'is_nullable' => new ConfirmStep('Should this field be nullable?'),
            'is_primary' => new ConfirmStep('Should this property be the primary key?'),
            'is_foreign_key' => new ConfirmStep('Should this field be a foreign key?'),
            'foreign_key_target' => $this->subWizard(new RelationshipSubwizard()),
        ];
    }

    public function answeredType(Step $step, string $type)
    {
        if (!$this->canBeUnsigned($type)) {
            $this->skip('is_unsigned');
        }

        if (!$this->canBeAutoIncrement($type)) {
            $this->skip('is_autoincrement');
        }

        return $type;
    }

    public function answeredIsNullable(Step $step, bool $isNullable)
    {
        if (!$this->canBePrimary($isNullable)) {
            $this->skip('is_primary');
        }

        if (!$this->canBeForeignKey($this->answers->get('type'))) {
            $this->skip('is_foreign_key');
        }

        return $isNullable;
    }

    public function answeredIsForeignKey(Step $step, bool $isForeignKey)
    {
        if (!$isForeignKey) {
            $this->skip('foreign_key_target');
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

    private function canBePrimary(bool $isNullable): bool
    {
        if ($isNullable) {
            return false;
        }

        if ($this->answers->get('is_autoincrement', false)) {
            return true;
        }

        if ($this->answers->get('is_unique') && $this->typeIsStringable()) {
            return true;
        }

        return false;
    }

    private function typeIsStringable(): bool
    {
        return in_array($this->answers->get('type'), [
            (string) ModelPropertyType::STRING(),
            (string) ModelPropertyType::EMAIL(),
            (string) ModelPropertyType::TEXT(),
        ]);
    }
}
