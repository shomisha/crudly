<?php

namespace Shomisha\Crudly\Test\Unit\Developers\ApiCrud\Index;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Developers\Crud\Api\Index\IndexDeveloper;
use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Api\IndexMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class IndexDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        return CrudlySpecificationBuilder::forModel('Post');
    }

    protected function getDeveloperWithManager(?BaseDeveloperManager $manager = null): CrudMethodDeveloper
    {
        if ($manager === null) {
            $manager = new IndexMethodDeveloperManager(new DeveloperConfig(), $this->app);
        }

        return new IndexDeveloper($manager, $this->modelSupervisor);
    }

    protected function getDevelopedMethodWithAuthorization(): string
    {
        return implode("\n", [
            "    public function index()",
            "    {",
            "        \$this->authorize('viewAll', Post::class);",
            "        \$posts = Post::paginate();\n",

            "        return PostResource::collection(\$posts);",
            "    }",
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function index()",
            "    {",
            "        \$posts = Post::paginate();\n",

            "        return PostResource::collection(\$posts);",
            "    }",
        ]);
    }
}
