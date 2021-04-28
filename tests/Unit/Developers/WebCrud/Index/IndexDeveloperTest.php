<?php

namespace Shomisha\Crudly\Test\Unit\Developers\WebCrud\Index;

use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Index\IndexDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Web\IndexMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class IndexDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        return tap(CrudlySpecificationBuilder::forModel('Post'), function (CrudlySpecificationBuilder $specificationBuilder) {
            $specificationBuilder->property('author_id', ModelPropertyType::BIG_INT())
                                 ->isForeign('id', 'authors')
                                 ->isRelationship('author');
        });
    }

    protected function getDeveloperWithManager(?BaseDeveloperManager $manager = null): CrudMethodDeveloper
    {
        if ($manager === null) {
            $manager = new IndexMethodDeveloperManager($this->getDeveloperConfig(), $this->app);
        }

        return new IndexDeveloper($manager, $this->modelSupervisor);
    }

    protected function getDevelopedMethodWithAuthorization(): string
    {
        return implode("\n", [
            "    public function index()",
            "    {",
            "        \$this->authorize('viewAny', Post::class);",
            "        \$posts = Post::paginate();\n",

            "        return view('posts.index', ['posts' => \$posts]);",
            "    }",
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function index()",
            "    {",
            "        \$posts = Post::paginate();\n",

            "        return view('posts.index', ['posts' => \$posts]);",
            "    }",
        ]);
    }
}
