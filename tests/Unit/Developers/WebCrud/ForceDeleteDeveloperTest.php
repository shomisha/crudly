<?php

namespace Shomisha\Crudly\Test\Unit\Developers\WebCrud;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\ForceDelete\ForceDeleteDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Web\ForceDeleteMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class ForceDeleteDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        return CrudlySpecificationBuilder::forModel('Post');
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
            "    public function forceDelete(Post \$post)",
            "    {",
            "        \$this->authorize('forceDelete', \$post);",
            "        \$post->forceDelete();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully deleted instance.');",
            "    }"
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function forceDelete(Post \$post)",
            "    {",
            "        \$post->forceDelete();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully deleted instance.');",
            "    }"
        ]);
    }
}
