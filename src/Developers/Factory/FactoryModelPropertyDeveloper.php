<?php

namespace Shomisha\Crudly\Developers\Factory;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Stubless\DeclarativeCode\ClassProperty;
use Shomisha\Stubless\Utilities\Importable;

/**
 * Class ModelPropertyDeveloper
 *
 * @method \Shomisha\Crudly\Managers\FactoryDeveloperManager getManager()
 */
class FactoryModelPropertyDeveloper extends Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassProperty
    {
        $model = $specification->getModel();

        return ClassProperty::name('model')->setValue(new Importable($model->getFullyQualifiedName()))->makeProtected();
    }
}
