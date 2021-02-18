<?php

namespace Shomisha\Crudly\Test\Unit\Developers\WebCrud;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\Web\Index\IndexDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Crud\Web\IndexMethodDeveloperManager;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class IndexDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_the_web_crud_index_method()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('author_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'authors')
                ->isRelationship('author')
            ->webAuthorization();


        $manager = new IndexMethodDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new IndexDeveloper($manager, $this->modelSupervisor);
        $indexMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(CrudMethod::class, $indexMethod);

        $controller = ClassTemplate::name('PostsController')->addMethod($indexMethod);
        $this->assertStringContainsString(implode("\n", [
            "    public function index()",
            "    {",
            "        \$this->authorize('viewAll', Post::class);",
            "        \$posts = Post::paginate();\n",

            "        return view('posts.index', ['posts' => \$posts]);",
            "    }",
        ]), $controller->print());
    }

    /** @test */
    public function developer_will_not_develop_authorization_block_if_authorization_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('author_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'authors')
                ->isRelationship('author')
            ->webAuthorization(false);


        $manager = new IndexMethodDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new IndexDeveloper($manager, $this->modelSupervisor);
        $indexMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(CrudMethod::class, $indexMethod);

        $controller = ClassTemplate::name('PostsController')->addMethod($indexMethod);
        $this->assertStringContainsString(implode("\n", [
            "    public function index()",
            "    {",
            "        \$posts = Post::paginate();\n",

            "        return view('posts.index', ['posts' => \$posts]);",
            "    }",
        ]), $controller->print());
    }

    /** @test */
    public function developer_will_delegate_method_development_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('author_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'authors')
                ->isRelationship('author')
            ->webAuthorization();

        $expectedMethods = [
            'getLoadDeveloper',
            'getAuthorizationDeveloper',
            'getMainDeveloper',
            'getResponseDeveloper'
        ];
        $this->manager->imperativeCodeDevelopers($expectedMethods);

        $this->manager->arraysOfDevelopers([
            'getArgumentsDeveloper',
        ]);

        $developer = new IndexDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertArrayOfDevelopersRequested('getArgumentsDeveloper');
        foreach ($expectedMethods as $expectedMethod) {
            $this->manager->assertCodeDeveloperRequested($expectedMethod);
        }
    }

    /** @test */
    public function developer_will_not_delegate_authorization_development_if_authorization_was_not_developed()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('author_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'authors')
                ->isRelationship('author')
            ->webAuthorization(false);

        $expectedMethods = [
            'getLoadDeveloper',
            'getMainDeveloper',
            'getResponseDeveloper'
        ];
        $this->manager->imperativeCodeDevelopers($expectedMethods);

        $this->manager->arraysOfDevelopers([
            'getArgumentsDeveloper',
        ]);


        $developer = new IndexDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertCodeDeveloperNotRequested('getAuthorizationDeveloper');
    }
}
