<?php

namespace Shomisha\Crudly\Test\Unit\Developers\WebCrud;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Restore\RestoreDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Web\RestoreMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class RestoreDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        return CrudlySpecificationBuilder::forModel('Post');
    }

    protected function getDeveloperWithManager(?BaseDeveloperManager $manager = null): CrudMethodDeveloper
    {
        if ($manager === null) {
            $manager = new RestoreMethodDeveloperManager(new DeveloperConfig(), $this->app);
        }

        return new RestoreDeveloper($manager, $this->modelSupervisor);
    }

    protected function getDevelopedMethodWithAuthorization(): string
    {
        return implode("\n", [
            "    public function restore(Post \$post)",
            "    {",
            "        \$this->authorize('restore', \$post);",
            "        \$post->restore();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully restored instance.');",
            "    }"
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function restore(Post \$post)",
            "    {",
            "        \$post->restore();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully restored instance.');",
            "    }"
        ]);
    }
}
