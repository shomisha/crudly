<?php

namespace Shomisha\Crudly\Test\Unit\Developers\WebCrud\Restore;

use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Restore\RestoreDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Web\RestoreMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class RestoreDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        return tap(CrudlySpecificationBuilder::forModel('Post'), function (CrudlySpecificationBuilder $specification) {
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
            "    public function restore(\$postId)",
            "    {",
            "        \$post = Post::query()->withTrashed()->findOrFail(\$postId);",
            "        \$this->authorize('restore', \$post);",
            "        \$post->restore();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully restored instance.');",
            "    }",
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function restore(\$postId)",
            "    {",
            "        \$post = Post::query()->withTrashed()->findOrFail(\$postId);",
            "        \$post->restore();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully restored instance.');",
            "    }",
        ]);
    }
}
