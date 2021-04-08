<?php

namespace Shomisha\Crudly\Test\Unit\Developers\ApiCrud\Destroy;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Developers\Crud\Api\Destroy\DestroyDeveloper;
use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Api\DestroyMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class DestroyDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        return CrudlySpecificationBuilder::forModel('Animal');
    }

    protected function getDeveloperWithManager(?BaseDeveloperManager $manager = null): CrudMethodDeveloper
    {
        if ($manager === null) {
            $manager = new DestroyMethodDeveloperManager($this->getDeveloperConfig(), $this->app);
        }

        return new DestroyDeveloper($manager, $this->modelSupervisor);
    }

    protected function getDevelopedMethodWithAuthorization(): string
    {
        return implode("\n", [
            "    public function destroy(Animal \$animal)",
            "    {",
            "        \$this->authorize('delete', \$animal);",
            "        \$animal->delete();\n",

            "        return response()->noContent();",
            "    }",
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function destroy(Animal \$animal)",
            "    {",
            "        \$animal->delete();\n",

            "        return response()->noContent();",
            "    }",
        ]);
    }
}
