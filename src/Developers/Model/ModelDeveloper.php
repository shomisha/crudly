<?php

namespace Shomisha\Crudly\Developers\Model;

use Illuminate\Database\Eloquent\Model;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\Utilities\Importable;

class ModelDeveloper extends Developer
{
	/** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $modelName = $specification->getModel();

        $modelTemplate = ClassTemplate::name($modelName->getName())->setNamespace($modelName->getNamespace());
        $modelTemplate->extends(new Importable(Model::class));

        return $modelTemplate;
    }
}
