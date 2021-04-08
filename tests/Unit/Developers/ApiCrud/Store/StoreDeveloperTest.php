<?php

namespace Shomisha\Crudly\Test\Unit\Developers\ApiCrud\Store;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Developers\Crud\Api\Store\StoreDeveloper;
use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Api\StoreMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class StoreDeveloperTest extends CrudMethodTestCase
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
            $manager = new StoreMethodDeveloperManager($this->getDeveloperConfig(), $this->app);
        }

        return new StoreDeveloper($manager, $this->modelSupervisor);
    }

    protected function getDevelopedMethodWithAuthorization(): string
    {
        return implode("\n", [
            "    public function store(AuthorRequest \$request)",
            "    {",
            "        \$this->authorize('create', Author::class);",
            "        \$author = new Author();",
            "        \$author->name = \$request->input('name');",
            "        \$author->email = \$request->input('email');",
            "        \$author->country_id = \$request->input('country_id');",
            "        \$author->publisher_id = \$request->input('publisher_id');",
            "        \$author->save();\n",

            "        return new AuthorResource(\$author);",
            "    }",
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function store(AuthorRequest \$request)",
            "    {",
            "        \$author = new Author();",
            "        \$author->name = \$request->input('name');",
            "        \$author->email = \$request->input('email');",
            "        \$author->country_id = \$request->input('country_id');",
            "        \$author->publisher_id = \$request->input('publisher_id');",
            "        \$author->save();\n",

            "        return new AuthorResource(\$author);",
            "    }",
        ]);
    }
}
