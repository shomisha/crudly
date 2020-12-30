<?php

namespace Shomisha\Crudly\Developers\Migration;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\Contracts\Code;
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
    public function develop(Specification $specification): Code
    {
        $modelName = $specification->getModel();

        $migrationClass = ClassTemplate::name($this->guessName($modelName))->extends(
            new Importable(Migration::class)
        );

        $migrationClass
            ->addMethod($this->upMethod($specification))
            ->addMethod($this->downMethod($specification));

        return $migrationClass;
    }

    private function guessName(ModelName $modelName): string
    {
        return "Create" . Str::studly((string) $modelName) . "Table";
    }

    protected function guessTableName(ModelName $modelName): string
    {
        return Str::snake(Str::plural($modelName->getName()));
    }

    private function upMethod(CrudlySpecification $specification): ClassMethod
    {
        return $this->getManager()->getMigrationUpMethodDeveloper()->develop($specification);
    }

    private function downMethod(CrudlySpecification $specification): ClassMethod
    {
        return $this->getManager()->getMigrationDownMethodDeveloper()->develop($specification);
    }
}
