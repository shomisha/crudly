<?php

namespace Shomisha\Crudly\Test\Unit\Developers\ApiCrud\ForceDelete;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Developers\Crud\Api\ForceDelete\ForceDeleteDeveloper;
use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Api\ForceDeleteMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class ForceDeleteDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        return CrudlySpecificationBuilder::forModel('Animal')->softDeletes(true);
    }

    protected function getDeveloperWithManager(?BaseDeveloperManager $manager = null): CrudMethodDeveloper
    {
        if ($manager === null) {
            $manager = new ForceDeleteMethodDeveloperManager(new DeveloperConfig(), $this->app);
        }

        return new ForceDeleteDeveloper($manager, $this->modelSupervisor);
    }

    protected function getDevelopedMethodWithAuthorization(): string
    {
        return implode("\n", [
            "    public function forceDelete(Animal \$animal)",
            "    {",
            "        \$this->authorize('forceDelete', \$animal);",
            "        \$animal->forceDelete();\n",

            "        return response()->noContent();",
            "    }",
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function forceDelete(Animal \$animal)",
            "    {",
            "        \$animal->forceDelete();\n",

            "        return response()->noContent();",
            "    }",
        ]);
    }
}
