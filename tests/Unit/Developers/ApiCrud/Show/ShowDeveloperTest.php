<?php

namespace Shomisha\Crudly\Test\Unit\Developers\ApiCrud\Show;

use Shomisha\Crudly\Developers\Crud\Api\Show\ShowDeveloper;
use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Api\ShowMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class ShowDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        $this->modelSupervisor->expectedExistingModels(['Author', 'Category']);

        return tap(CrudlySpecificationBuilder::forModel('Post'), function (CrudlySpecificationBuilder $specificationBuilder) {
            $specificationBuilder
                ->property('author_id', ModelPropertyType::BIG_INT())
                    ->isForeign('id', 'authors')
                    ->isRelationship('author')
                ->property('category_id', ModelPropertyType::BIG_INT())
                    ->isForeign('id', 'categories')
                    ->isRelationship('category');
        });
    }

    protected function getDeveloperWithManager(?BaseDeveloperManager $manager = null): CrudMethodDeveloper
    {
        if ($manager === null) {
            $manager = new ShowMethodDeveloperManager($this->getDeveloperConfig(), $this->app);
        }

        return new ShowDeveloper($manager, $this->modelSupervisor);
    }

    protected function getDevelopedMethodWithAuthorization(): string
    {
        return implode("\n", [
            "    public function show(Post \$post)",
            "    {",
            "        \$this->authorize('view', \$post);",
            "        \$post->load(['author', 'category']);\n",

            "        return new PostResource(\$post);",
            "    }",
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function show(Post \$post)",
            "    {",
            "        \$post->load(['author', 'category']);\n",

            "        return new PostResource(\$post);",
            "    }",
        ]);
    }
}
