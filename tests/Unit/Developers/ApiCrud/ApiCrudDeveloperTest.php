<?php

namespace Shomisha\Crudly\Test\Unit\Developers\ApiCrud;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\Api\CrudControllerDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Crud\Api\ApiCrudDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;

class ApiCrudDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_api_crud_controller()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->property('name', ModelPropertyType::STRING())
            ->property('age', ModelPropertyType::INT())
            ->property('country_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'countries')
                ->isRelationship('country')
            ->property('publisher_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'publishers')
                ->isRelationship('publisher')
            ->property('genre_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'genres')
            ->apiAuthorization(true)
            ->softDeletes()
            ->softDeletionColumn('deleted_at');

        $this->modelSupervisor->expectedExistingModels(['Country', 'Publisher']);


        $manager = new ApiCrudDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new CrudControllerDeveloper($manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $controller = $developer->develop($specificationBuilder->build(), $developedSet);


        $this->assertEquals($controller, $developedSet->getApiCrudController());

        $printedController = $controller->print();

        $this->assertStringContainsString("namespace App\Http\Controllers\Api;", $printedController);

        $this->assertStringContainsString("use App\Http\Controllers\Controller;", $printedController);
        $this->assertStringContainsString("use App\Http\Requests\AuthorRequest;", $printedController);
        $this->assertStringContainsString("use App\Http\Resources\AuthorResource;", $printedController);
        $this->assertStringContainsString("use App\Models\Author;", $printedController);

        $this->assertStringContainsString(implode("\n", [
            "class AuthorsController extends Controller",
            "{",
            "    public function index()",
            "    {",
            "        \$this->authorize('viewAll', Author::class);",
            "        \$authors = Author::paginate();\n",

            "        return AuthorResource::collection(\$authors);",
            "    }\n",

            "    public function show(Author \$author)",
            "    {",
            "        \$this->authorize('view', \$author);",
            "        \$author->load(['country', 'publisher']);\n",

            "        return new AuthorResource(\$author);",
            "    }\n",

            "    public function store(AuthorRequest \$request)",
            "    {",
            "        \$this->authorize('create', Author::class);",
            "        \$author = new Author();",
            "        \$author->email = \$request->input('email');",
            "        \$author->name = \$request->input('name');",
            "        \$author->age = \$request->input('age');",
            "        \$author->country_id = \$request->input('country_id');",
            "        \$author->publisher_id = \$request->input('publisher_id');",
            "        \$author->genre_id = \$request->input('genre_id');",
            "        \$author->save();\n",

            "        return new AuthorResource(\$author);",
            "    }\n",

            "    public function update(AuthorRequest \$request, Author \$author)",
            "    {",
            "        \$this->authorize('update', \$author);",
            "        \$author->email = \$request->input('email');",
            "        \$author->name = \$request->input('name');",
            "        \$author->age = \$request->input('age');",
            "        \$author->country_id = \$request->input('country_id');",
            "        \$author->publisher_id = \$request->input('publisher_id');",
            "        \$author->genre_id = \$request->input('genre_id');",
            "        \$author->update();\n",

            "        return response()->noContent();",
            "    }\n",

            "    public function destroy(Author \$author)",
            "    {",
            "        \$this->authorize('delete', \$author);",
            "        \$author->delete();\n",

            "        return response()->noContent();",
            "    }\n",

            "    public function forceDelete(Author \$author)",
            "    {",
            "        \$this->authorize('forceDelete', \$author);",
            "        \$author->forceDelete();\n",

            "        return response()->noContent();",
            "    }\n",

            "    public function restore(Author \$author)",
            "    {",
            "        \$this->authorize('restore', \$author);",
            "        \$author->restore();\n",

            "        return response()->noContent();",
            "    }",
            "}",
        ]), $printedController);
    }

    /** @test */
    public function developer_will_not_develop_authorization_checks_if_authorization_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->property('name', ModelPropertyType::STRING())
            ->property('age', ModelPropertyType::INT())
            ->property('country_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'countries')
                ->isRelationship('country')
            ->property('publisher_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'publishers')
                ->isRelationship('publisher')
            ->property('genre_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'genres')
            ->apiAuthorization(false)
            ->softDeletes()
            ->softDeletionColumn('deleted_at');

        $this->modelSupervisor->expectedExistingModels(['Country', 'Publisher']);


        $manager = new ApiCrudDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new CrudControllerDeveloper($manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $controller = $developer->develop($specificationBuilder->build(), $developedSet);


        $this->assertEquals($controller, $developedSet->getApiCrudController());

        $printedController = $controller->print();

        $this->assertStringContainsString("namespace App\Http\Controllers\Api;", $printedController);

        $this->assertStringContainsString("use App\Http\Controllers\Controller;", $printedController);
        $this->assertStringContainsString("use App\Http\Requests\AuthorRequest;", $printedController);
        $this->assertStringContainsString("use App\Http\Resources\AuthorResource;", $printedController);
        $this->assertStringContainsString("use App\Models\Author;", $printedController);

        $this->assertStringContainsString(implode("\n", [
            "class AuthorsController extends Controller",
            "{",
            "    public function index()",
            "    {",
            "        \$authors = Author::paginate();\n",

            "        return AuthorResource::collection(\$authors);",
            "    }\n",

            "    public function show(Author \$author)",
            "    {",
            "        \$author->load(['country', 'publisher']);\n",

            "        return new AuthorResource(\$author);",
            "    }\n",

            "    public function store(AuthorRequest \$request)",
            "    {",
            "        \$author = new Author();",
            "        \$author->email = \$request->input('email');",
            "        \$author->name = \$request->input('name');",
            "        \$author->age = \$request->input('age');",
            "        \$author->country_id = \$request->input('country_id');",
            "        \$author->publisher_id = \$request->input('publisher_id');",
            "        \$author->genre_id = \$request->input('genre_id');",
            "        \$author->save();\n",

            "        return new AuthorResource(\$author);",
            "    }\n",

            "    public function update(AuthorRequest \$request, Author \$author)",
            "    {",
            "        \$author->email = \$request->input('email');",
            "        \$author->name = \$request->input('name');",
            "        \$author->age = \$request->input('age');",
            "        \$author->country_id = \$request->input('country_id');",
            "        \$author->publisher_id = \$request->input('publisher_id');",
            "        \$author->genre_id = \$request->input('genre_id');",
            "        \$author->update();\n",

            "        return response()->noContent();",
            "    }\n",

            "    public function destroy(Author \$author)",
            "    {",
            "        \$author->delete();\n",

            "        return response()->noContent();",
            "    }\n",

            "    public function forceDelete(Author \$author)",
            "    {",
            "        \$author->forceDelete();\n",

            "        return response()->noContent();",
            "    }\n",

            "    public function restore(Author \$author)",
            "    {",
            "        \$author->restore();\n",

            "        return response()->noContent();",
            "    }",
            "}",
        ]), $printedController);
    }

    /** @test */
    public function developer_will_not_develop_soft_deletion_methods_if_soft_deletion_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->property('name', ModelPropertyType::STRING())
            ->property('age', ModelPropertyType::INT())
            ->property('country_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'countries')
                ->isRelationship('country')
            ->property('publisher_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'publishers')
                ->isRelationship('publisher')
            ->property('genre_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'genres')
            ->apiAuthorization(true)
            ->softDeletes(false);

        $this->modelSupervisor->expectedExistingModels(['Country', 'Publisher']);


        $manager = new ApiCrudDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new CrudControllerDeveloper($manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $controller = $developer->develop($specificationBuilder->build(), $developedSet);


        $this->assertEquals($controller, $developedSet->getApiCrudController());

        $printedController = $controller->print();

        $this->assertStringContainsString("namespace App\Http\Controllers\Api;", $printedController);

        $this->assertStringContainsString("use App\Http\Controllers\Controller;", $printedController);
        $this->assertStringContainsString("use App\Http\Requests\AuthorRequest;", $printedController);
        $this->assertStringContainsString("use App\Http\Resources\AuthorResource;", $printedController);
        $this->assertStringContainsString("use App\Models\Author;", $printedController);

        $this->assertStringContainsString(implode("\n", [
            "class AuthorsController extends Controller",
            "{",
            "    public function index()",
            "    {",
            "        \$this->authorize('viewAll', Author::class);",
            "        \$authors = Author::paginate();\n",

            "        return AuthorResource::collection(\$authors);",
            "    }\n",

            "    public function show(Author \$author)",
            "    {",
            "        \$this->authorize('view', \$author);",
            "        \$author->load(['country', 'publisher']);\n",

            "        return new AuthorResource(\$author);",
            "    }\n",

            "    public function store(AuthorRequest \$request)",
            "    {",
            "        \$this->authorize('create', Author::class);",
            "        \$author = new Author();",
            "        \$author->email = \$request->input('email');",
            "        \$author->name = \$request->input('name');",
            "        \$author->age = \$request->input('age');",
            "        \$author->country_id = \$request->input('country_id');",
            "        \$author->publisher_id = \$request->input('publisher_id');",
            "        \$author->genre_id = \$request->input('genre_id');",
            "        \$author->save();\n",

            "        return new AuthorResource(\$author);",
            "    }\n",

            "    public function update(AuthorRequest \$request, Author \$author)",
            "    {",
            "        \$this->authorize('update', \$author);",
            "        \$author->email = \$request->input('email');",
            "        \$author->name = \$request->input('name');",
            "        \$author->age = \$request->input('age');",
            "        \$author->country_id = \$request->input('country_id');",
            "        \$author->publisher_id = \$request->input('publisher_id');",
            "        \$author->genre_id = \$request->input('genre_id');",
            "        \$author->update();\n",

            "        return response()->noContent();",
            "    }\n",

            "    public function destroy(Author \$author)",
            "    {",
            "        \$this->authorize('delete', \$author);",
            "        \$author->delete();\n",

            "        return response()->noContent();",
            "    }",
            "}",
        ]), $printedController);
    }

    /** @test */
    public function developer_will_delegate_controller_method_development_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->softDeletes(true)
            ->softDeletionColumn('deleted_at');

        $expectedMethodDevelopers = [
            'getIndexMethodDeveloper',
            'getShowMethodDeveloper',
            'getStoreMethodDeveloper',
            'getUpdateMethodDeveloper',
            'getDestroyMethodDeveloper',
            'getForceDeleteMethodDeveloper',
            'getRestoreMethodDeveloper',
        ];
        $this->manager->methodDevelopers($expectedMethodDevelopers);


        $expectedDeveloper = new CrudControllerDeveloper($this->manager, $this->modelSupervisor);
        $expectedDeveloper->develop($specificationBuilder->build(), new CrudlySet());


        foreach ($expectedMethodDevelopers as $expectedDeveloper) {
            $this->manager->assertMethodDeveloperRequested($expectedDeveloper);
        }
    }
}
