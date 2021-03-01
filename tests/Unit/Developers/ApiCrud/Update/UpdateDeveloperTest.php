<?php

namespace Shomisha\Crudly\Test\Unit\Developers\ApiCrud\Update;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Developers\Crud\Api\Update\UpdateDeveloper;
use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Api\UpdateMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class UpdateDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        return tap(CrudlySpecificationBuilder::forModel('Author'), function (CrudlySpecificationBuilder $specificationBuilder) {
            $specificationBuilder
                ->property('id', ModelPropertyType::BIG_INT())
                    ->primary()
                ->property('name', ModelPropertyType::STRING())
                ->property('email', ModelPropertyType::STRING())
                    ->unique()
                ->property('country_id', ModelPropertyType::BIG_INT())
                    ->isForeign('id', 'countries')
                    ->isRelationship('country')
                ->property('publisher_id', ModelPropertyType::BIG_INT())
                    ->isForeign('id', 'publishers')
                    ->isRelationship('publisher');
        });
    }

    protected function getDeveloperWithManager(?BaseDeveloperManager $manager = null): CrudMethodDeveloper
    {
        if ($manager === null) {
            $manager = new UpdateMethodDeveloperManager(new DeveloperConfig(), $this->app);
        }

        return new UpdateDeveloper($manager, $this->modelSupervisor);
    }

    protected function getDevelopedMethodWithAuthorization(): string
    {
        return implode("\n", [
            "    public function update(AuthorRequest \$request, Author \$author)",
            "    {",
            "        \$this->authorize('update', \$author);",
            "        \$author->name = \$request->input('name');",
            "        \$author->email = \$request->input('email');",
            "        \$author->country_id = \$request->input('country_id');",
            "        \$author->publisher_id = \$request->input('publisher_id');",
            "        \$author->update();\n",

            "        return new AuthorResource(\$author);",
            "    }",
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function update(AuthorRequest \$request, Author \$author)",
            "    {",
            "        \$author->name = \$request->input('name');",
            "        \$author->email = \$request->input('email');",
            "        \$author->country_id = \$request->input('country_id');",
            "        \$author->publisher_id = \$request->input('publisher_id');",
            "        \$author->update();\n",

            "        return new AuthorResource(\$author);",
            "    }",
        ]);
    }
}
