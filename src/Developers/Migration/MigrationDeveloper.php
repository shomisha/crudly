<?php

namespace Shomisha\Crudly\Developers\Migration;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\Utilities\Importable;

/**
 * Class MigrationDeveloper
 *
 * @method \Shomisha\Crudly\Managers\MigrationDeveloperManager getManager()
 */
class MigrationDeveloper extends Developer
{
	/** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassTemplate
    {
        $modelName = $specification->getModel();

        $migrationClass = ClassTemplate::name($this->guessName($modelName))->extends(
            new Importable(Migration::class)
        );

        $migrationClass
            ->addMethod($this->upMethod($specification, $developedSet))
            ->addMethod($this->downMethod($specification, $developedSet));

        $developedSet->setMigration($migrationClass);

        return $migrationClass;
    }

    private function guessName(ModelName $modelName): string
    {
        return "Create" . Str::of((string) $modelName)->plural()->studly() . "Table";
    }

    private function upMethod(CrudlySpecification $specification, CrudlySet $developedSet): ClassMethod
    {
        return $this->getManager()->getMigrationUpMethodDeveloper()->develop($specification, $developedSet);
    }

    private function downMethod(CrudlySpecification $specification, CrudlySet $developedSet): ClassMethod
    {
        return $this->getManager()->getMigrationDownMethodDeveloper()->develop($specification, $developedSet);
    }
}
