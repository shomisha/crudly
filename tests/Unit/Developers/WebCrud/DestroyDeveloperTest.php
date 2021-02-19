<?php

namespace Shomisha\Crudly\Test\Unit\Developers\WebCrud;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Destroy\DestroyDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Web\DestroyMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class DestroyDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        return CrudlySpecificationBuilder::forModel('Post');
    }

    protected function getDeveloperWithManager(?BaseDeveloperManager $manager = null): CrudMethodDeveloper
    {
        if ($manager === null) {
            $manager = new DestroyMethodDeveloperManager(new DeveloperConfig(), $this->app);
        }

        return new DestroyDeveloper($manager, $this->modelSupervisor);
    }

    protected function getDevelopedMethodWithAuthorization(): string
    {
        return implode("\n", [
            "    public function destroy(Post \$post)",
            "    {",
            "        \$this->authorize('delete', \$post);",
            "        \$post->delete();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully deleted instance.');",
            "    }"
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function destroy(Post \$post)",
            "    {",
            "        \$post->delete();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully deleted instance.');",
            "    }"
        ]);
    }
}
