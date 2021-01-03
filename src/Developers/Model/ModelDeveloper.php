<?php

namespace Shomisha\Crudly\Developers\Model;

use Illuminate\Database\Eloquent\Model;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Managers\ModelDeveloperManager;
use Shomisha\Stubless\Contracts\Code;
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
    private ModelSupervisor $modelSupervisor;

    public function __construct(ModelDeveloperManager $manager, ModelSupervisor $modelSupervisor)
    {
        parent::__construct($manager);

        $this->modelSupervisor = $modelSupervisor;
    }

    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $modelName = $specification->getModel();

        $modelTemplate = ClassTemplate::name($modelName->getName())->setNamespace($modelName->getFullNamespace());
        $modelTemplate->extends(new Importable(Model::class));

        $developedSet->setModel($modelTemplate);

        if ($specification->hasSoftDeletion()) {
            $this->getManager()->getSoftDeletionDeveloper()->develop($specification, $developedSet);
        }

        if (!$specification->hasTimestamps()) {
            $modelTemplate->addProperty(
                ClassProperty::name('timestamps')->value(false)
            );
        }

        $this->getManager()->getRelationshipsDeveloper()->develop($specification, $developedSet);

        return $modelTemplate;
    }
}
