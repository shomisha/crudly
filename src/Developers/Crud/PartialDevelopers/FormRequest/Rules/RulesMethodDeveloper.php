<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\FormRequest\Rules;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\ImperativeCode\Block;

/**
 * Class RulesMethodDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\FormRequestDeveloperManager getManager()
 */
class RulesMethodDeveloper extends ValidationDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassMethod
    {
        $rulesMethod = $this->getRulesMethod();

        $rulesMethod->setBody($this->getRulesMethodBody($specification, $developedSet));

        return $rulesMethod;
    }

    protected function getRulesMethodBody(CrudlySpecification $specification, CrudlySet $developedSet): Block
    {
        $body = Block::fromArray([
            $this->getManager()->getSpecialRulesDeveloper()->develop($specification, $developedSet)
        ]);

        $rules = $specification->getProperties()->mapWithKeys(function (ModelPropertySpecification $property) use ($developedSet) {
            if ($property->isPrimaryKey()) {
                return [$property->getName() => null];
            }

            /** @var \Shomisha\Stubless\Values\ArrayValue $rules */
            $rules = $this->getManager()->getValidationRulesDeveloper()->develop($property, $developedSet);

            return [
                $property->getName() => array_merge(
                    $this->getSpecialRuleReferences($property),
                    $rules->getRaw()
                ),
            ];
        })->filter()->toArray();

        $body->addCode(
            Block::return($rules)
        );

        return $body;
    }

    protected function getSpecialRuleReferences(ModelPropertySpecification $property): array
    {
        $references = [];

        if ($property->isUnique()) {
            $references[] = $this->getUniqueRuleVariable($property->getName());
        }

        if ($property->isForeignKey()) {
            $references[] = $this->getForeignKeyRuleVariable($property->getName());
        }

        return $references;
    }

    protected function getRulesMethod(): ClassMethod
    {
        return ClassMethod::name('rules');
    }
}
