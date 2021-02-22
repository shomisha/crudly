<?php

namespace Shomisha\Crudly\Test\Unit\Developers\WebCrud;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Create\CreateDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Web\CreateMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class CreateDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        $this->modelSupervisor->expectedExistingModels(['Publisher']);

        return tap(CrudlySpecificationBuilder::forModel('Author'), function (CrudlySpecificationBuilder $specificationBuilder) {
            $specificationBuilder
                ->property('country_id', ModelPropertyType::BIG_INT())
                    ->isForeign('id', 'countries')
                    ->isRelationship('country')
                ->property('published_ir', ModelPropertyType::BIG_INT())
                    ->isForeign('id', 'publishers')
                    ->isRelationship('publisher');
        });
    }

    protected function getDeveloperWithManager(?BaseDeveloperManager $manager = null): CrudMethodDeveloper
    {
        if ($manager === null) {
            $manager = new CreateMethodDeveloperManager(new DeveloperConfig(), $this->app);
        }

        return new CreateDeveloper($manager, $this->modelSupervisor);
    }

    protected function getDevelopedMethodWithAuthorization(): string
    {
        return implode("\n", [
            "    public function create()",
            "    {",
            "        \$this->authorize('create', Author::class);",
            "        \$countries = DB::table('countries')->get();",
            "        \$publishers = Publisher::all();",
            "        \$author = new Author();\n",

            "        return view('authors.create', ['author' => \$author, 'countries' => \$countries, 'publishers' => \$publishers]);",
            "    }",
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function create()",
            "    {",
            "        \$countries = DB::table('countries')->get();",
            "        \$publishers = Publisher::all();",
            "        \$author = new Author();\n",

            "        return view('authors.create', ['author' => \$author, 'countries' => \$countries, 'publishers' => \$publishers]);",
            "    }",
        ]);
    }
}
