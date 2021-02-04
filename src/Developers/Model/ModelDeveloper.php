<?php

namespace Shomisha\Crudly\Developers\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Stubless\DeclarativeCode\ClassProperty;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\Utilities\Importable;

/**
 * Class ModelDeveloper
 *
 * @method \Shomisha\Crudly\Managers\ModelDeveloperManager getManager()
 */
class ModelDeveloper extends Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassTemplate
    {
        $modelName = $specification->getModel();

        $modelTemplate = ClassTemplate::name($modelName->getName())->setNamespace($modelName->getFullNamespace());
        $modelTemplate->extends(new Importable(Model::class));

        $developedSet->setModel($modelTemplate);

        if ($specification->hasSoftDeletion()) {
            $this->getManager()->getSoftDeletionDeveloper()->develop($specification, $developedSet);
        }

        $modelTemplate->addTrait(new Importable(HasFactory::class));

        if (!$specification->hasTimestamps()) {
            $modelTemplate->addProperty(
                ClassProperty::name('timestamps')->value(false)
            );
        }

        $modelTemplate->addProperty(
            $this->getManager()->getCastsDeveloper()->develop($specification, $developedSet)
        );

        $this->getManager()->getRelationshipsDeveloper()->develop($specification, $developedSet);

        return $modelTemplate;
    }
}
