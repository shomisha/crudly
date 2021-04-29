<?php

namespace Shomisha\Crudly\Test\Unit\Developers\ApiCrud\Restore;

use Shomisha\Crudly\Developers\Crud\Api\Restore\RestoreDeveloper;
use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Api\RestoreMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class RestoreDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        return tap(CrudlySpecificationBuilder::forModel('Animal'), function (CrudlySpecificationBuilder $specification) {
            $specification->property('id', ModelPropertyType::BIG_INT())->primary();
        });
    }

    protected function getDeveloperWithManager(?BaseDeveloperManager $manager = null): CrudMethodDeveloper
    {
        if ($manager === null) {
            $manager = new RestoreMethodDeveloperManager($this->getDeveloperConfig(), $this->app);
        }

        return new RestoreDeveloper($manager, $this->modelSupervisor);
    }

    protected function getDevelopedMethodWithAuthorization(): string
    {
        return implode("\n", [
            "    public function restore(\$animalId)",
            "    {",
            "        \$animal = Animal::query()->withTrashed()->findOrFail(\$animalId);",
            "        \$this->authorize('restore', \$animal);",
            "        \$animal->restore();\n",

            "        return response()->noContent();",
            "    }",
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function restore(\$animalId)",
            "    {",
            "        \$animal = Animal::query()->withTrashed()->findOrFail(\$animalId);",
            "        \$animal->restore();\n",

            "        return response()->noContent();",
            "    }",
        ]);
    }
}
