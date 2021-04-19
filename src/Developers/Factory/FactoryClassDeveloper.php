<?php

namespace Shomisha\Crudly\Developers\Factory;

use Illuminate\Database\Eloquent\Factories\Factory;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\Utilities\Importable;

/**
 * Class FactoryDeveloper
 *
 * @method \Shomisha\Crudly\Managers\FactoryDeveloperManager getManager()
 */
class FactoryClassDeveloper extends FactoryDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassTemplate
    {
        $model = $specification->getModel();

        $factoryClass = ClassTemplate::name($this->guessFactoryShortName($model))
                                     ->extends(new Importable(Factory::class));

        $factoryClass->setNamespace('Database\Factories');

        $developedSet->setFactory($factoryClass);

        $factoryClass->addProperty(
            $this->getManager()->getFactoryModelPropertyDeveloper()->develop($specification, $developedSet)
        );

        $factoryClass->addMethod(
            $this->getManager()->getDefinitionMethodDeveloper()->develop($specification, $developedSet)
        );

        return $factoryClass;
    }
}
