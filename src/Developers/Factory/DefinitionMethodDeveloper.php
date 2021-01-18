<?php

namespace Shomisha\Crudly\Developers\Factory;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Values\Value;

/**
 * Class DefinitionMethodDeveloper
 *
 * @method \Shomisha\Crudly\Managers\FactoryDeveloperManager getManager()
 */
class DefinitionMethodDeveloper extends FactoryDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassMethod
    {
        $definitionMethod = ClassMethod::name('definition');

        $definitionMethod->setBody(
            Block::return(
                Value::array($this->prepareFactoryDefinition($specification, $developedSet))
            )
        );

        return $definitionMethod;
    }

    protected function prepareFactoryDefinition(CrudlySpecification $specification, CrudlySet $developedSet): array
    {
        return $specification->getProperties()->mapWithKeys(function (ModelPropertySpecification $property) use ($developedSet) {
            $propertyDefinition = null;
            if ($this->factoryDefinitionShouldIncludeProperty($property)) {
                $propertyDefinition = $this->getManager()->getFactoryDefinitionFieldDeveloper()->develop($property, $developedSet);
            }

            return [$property->getName() => $propertyDefinition];
        })->filter()->toArray();
    }

    protected function factoryDefinitionShouldIncludeProperty(ModelPropertySpecification $property): bool
    {
        // TODO: give this some more consideration
        if ($property->isPrimaryKey()) {
            return false;
        }

        if ($property->isAutoincrement()) {
            return false;
        }

        return true;
    }
}
