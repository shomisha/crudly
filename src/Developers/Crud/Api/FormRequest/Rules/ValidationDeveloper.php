<?php

namespace Shomisha\Crudly\Developers\Crud\Api\FormRequest\Rules;

use Illuminate\Support\Str;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\References\Variable;

abstract class ValidationDeveloper extends CrudDeveloper
{
    protected function getUniqueRuleVariable(string $propertyName): Variable
    {
        $propertyName = Str::camel($propertyName);

        return Reference::variable("{$propertyName}UniqueRule");
    }

    protected function getForeignKeyRuleVariable(string $propertyName): Variable
    {
        $propertyName = Str::camel($propertyName);

        return Reference::variable("{$propertyName}ExistsRule");
    }

    protected function propertyRequiresSpecialRules(ModelPropertySpecification $property): bool
    {
        if (
            $property->isPrimaryKey()  ||
            !$property->isForeignKey() &&
            !$property->isUnique()
        ) {
            return false;
        }

        return true;
    }
}
