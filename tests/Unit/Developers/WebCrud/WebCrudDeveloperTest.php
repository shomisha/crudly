<?php

namespace Shomisha\Crudly\Test\Unit\Developers\WebCrud;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\Web\CrudControllerDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Crud\Web\WebCrudDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class WebCrudDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_web_crud_controller()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('id', ModelPropertyType::BIG_INT())->unsigned()->primary()
            ->property('title', ModelPropertyType::STRING())
            ->property('body', ModelPropertyType::TEXT())
            ->property('published_at', ModelPropertyType::TIMESTAMP())
            ->property('author_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'authors')
                ->isRelationship('author')
            ->property('category_uuid', ModelPropertyType::BIG_INT())
                ->isForeign('uuid', 'categories')
                ->isRelationship('category')
            ->webCrud()
            ->webAuthorization()
            ->softDeletes()
            ->softDeletionColumn('deleted_at');

        $this->modelSupervisor->expectedExistingModels(['Author']);

        $manager = new WebCrudDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new CrudControllerDeveloper($manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $crudController = $developer->develop($specificationBuilder->build(), $developedSet);


        $this->assertInstanceOf(ClassTemplate::class, $crudController);
        $this->assertEquals($crudController, $developedSet->getWebCrudController());

        $printedController = $crudController->print();

        $this->assertStringContainsString("namespace App\Http\Controllers\Web;", $printedController);

        $this->assertStringContainsString("use App\Http\Controllers\Controller;", $printedController);
        $this->assertStringContainsString("use App\Http\Requests\PostRequest;", $printedController);
        $this->assertStringContainsString("use App\Models\Author;", $printedController);
        $this->assertStringContainsString("use App\Models\Post;", $printedController);
        $this->assertStringContainsString("use Illuminate\Support\Facades\DB;", $printedController);

        $this->assertStringContainsString(implode("\n", [
            "class PostsController extends Controller",
            "{",


            "    public function index()",
            "    {",
            "        \$this->authorize('viewAll', Post::class);",
            "        \$posts = Post::paginate();\n",

            "        return view('posts.index', ['posts' => \$posts]);",
            "    }\n",


            "    public function show(Post \$post)",
            "    {",
            "        \$this->authorize('view', \$post);",
            "        \$post->load(['author']);\n",

            "        return view('posts.show', ['post' => \$post]);",
            "    }\n",


            "    public function create()",
            "    {",
            "        \$this->authorize('create', Post::class);",
            "        \$authors = Author::all();",
            "        \$categories = DB::table('categories')->get();",
            "        \$post = new Post();\n",

            "        return view('posts.create', ['post' => \$post, 'authors' => \$authors, 'categories' => \$categories]);",
            "    }\n",


            "    public function store(PostRequest \$request)",
            "    {",
            "        \$this->authorize('create', Post::class);",
            "        \$post = new Post();",
            "        \$post->title = \$request->input('title');",
            "        \$post->body = \$request->input('body');",
            "        \$post->published_at = \$request->input('published_at');",
            "        \$post->author_id = \$request->input('author_id');",
            "        \$post->category_uuid = \$request->input('category_uuid');",
            "        \$post->save();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully created new instance.');",
            "    }\n",


            "    public function edit(Post \$post)",
            "    {",
            "        \$this->authorize('update', \$post);",
            "        \$authors = Author::all();",
            "        \$categories = DB::table('categories')->get();\n",

            "        return view('posts.edit', ['post' => \$post, 'authors' => \$authors, 'categories' => \$categories]);",
            "    }\n",


            "    public function update(PostRequest \$request, Post \$post)",
            "    {",
            "        \$this->authorize('update', \$post);",
            "        \$post->title = \$request->input('title');",
            "        \$post->body = \$request->input('body');",
            "        \$post->published_at = \$request->input('published_at');",
            "        \$post->author_id = \$request->input('author_id');",
            "        \$post->category_uuid = \$request->input('category_uuid');",
            "        \$post->update();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully updated instance.');",
            "    }\n",


            "    public function destroy(Post \$post)",
            "    {",
            "        \$this->authorize('delete', \$post);",
            "        \$post->delete();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully deleted instance.');",
            "    }\n",


            "    public function forceDelete(Post \$post)",
            "    {",
            "        \$this->authorize('forceDelete', \$post);",
            "        \$post->forceDelete();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully deleted instance.');",
            "    }\n",


            "    public function restore(Post \$post)",
            "    {",
            "        \$this->authorize('restore', \$post);",
            "        \$post->restore();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully restored instance.');",
            "    }",
            "}",
        ]), $printedController);
    }

    /** @test */
    public function developer_will_not_develop_authorization_checks_if_authorization_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('id', ModelPropertyType::BIG_INT())->unsigned()->primary()
            ->property('title', ModelPropertyType::STRING())
            ->webCrud()
            ->webAuthorization(false)
            ->softDeletes()
            ->softDeletionColumn('deleted_at');


        $manager = new WebCrudDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new CrudControllerDeveloper($manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $printedController = $developer->develop($specificationBuilder->build(), $developedSet)->print();


        $this->assertStringContainsString(implode("\n", [
            "class PostsController extends Controller",
            "{",


            "    public function index()",
            "    {",
            "        \$posts = Post::paginate();\n",

            "        return view('posts.index', ['posts' => \$posts]);",
            "    }\n",


            "    public function show(Post \$post)",
            "    {",
            "        return view('posts.show', ['post' => \$post]);",
            "    }\n",


            "    public function create()",
            "    {",
            "        \$post = new Post();\n",

            "        return view('posts.create', ['post' => \$post]);",
            "    }\n",


            "    public function store(PostRequest \$request)",
            "    {",
            "        \$post = new Post();",
            "        \$post->title = \$request->input('title');",
            "        \$post->save();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully created new instance.');",
            "    }\n",


            "    public function edit(Post \$post)",
            "    {",
            "        return view('posts.edit', ['post' => \$post]);",
            "    }\n",


            "    public function update(PostRequest \$request, Post \$post)",
            "    {",
            "        \$post->title = \$request->input('title');",
            "        \$post->update();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully updated instance.');",
            "    }\n",


            "    public function destroy(Post \$post)",
            "    {",
            "        \$post->delete();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully deleted instance.');",
            "    }\n",


            "    public function forceDelete(Post \$post)",
            "    {",
            "        \$post->forceDelete();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully deleted instance.');",
            "    }\n",


            "    public function restore(Post \$post)",
            "    {",
            "        \$post->restore();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully restored instance.');",
            "    }",
            "}",
        ]), $printedController);
    }

    /** @test */
    public function developer_will_not_develop_soft_deletion_methods_if_soft_deletion_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('id', ModelPropertyType::BIG_INT())->unsigned()->primary()
            ->property('title', ModelPropertyType::STRING())
            ->webCrud()
            ->webAuthorization()
            ->softDeletes(false);


        $manager = new WebCrudDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new CrudControllerDeveloper($manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $printedController = $developer->develop($specificationBuilder->build(), $developedSet)->print();


        $this->assertStringContainsString(implode("\n", [
            "class PostsController extends Controller",
            "{",


            "    public function index()",
            "    {",
            "        \$this->authorize('viewAll', Post::class);",
            "        \$posts = Post::paginate();\n",

            "        return view('posts.index', ['posts' => \$posts]);",
            "    }\n",


            "    public function show(Post \$post)",
            "    {",
            "        \$this->authorize('view', \$post);\n",

            "        return view('posts.show', ['post' => \$post]);",
            "    }\n",


            "    public function create()",
            "    {",
            "        \$this->authorize('create', Post::class);",
            "        \$post = new Post();\n",

            "        return view('posts.create', ['post' => \$post]);",
            "    }\n",


            "    public function store(PostRequest \$request)",
            "    {",
            "        \$this->authorize('create', Post::class);",
            "        \$post = new Post();",
            "        \$post->title = \$request->input('title');",
            "        \$post->save();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully created new instance.');",
            "    }\n",


            "    public function edit(Post \$post)",
            "    {",
            "        \$this->authorize('update', \$post);\n",

            "        return view('posts.edit', ['post' => \$post]);",
            "    }\n",


            "    public function update(PostRequest \$request, Post \$post)",
            "    {",
            "        \$this->authorize('update', \$post);",
            "        \$post->title = \$request->input('title');",
            "        \$post->update();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully updated instance.');",
            "    }\n",


            "    public function destroy(Post \$post)",
            "    {",
            "        \$this->authorize('delete', \$post);",
            "        \$post->delete();\n",

            "        return redirect()->route('posts.index')->with('success', 'Successfully deleted instance.');",
            "    }",
            "}",
        ]), $printedController);
    }

    /** @test */
    public function developer_will_delegate_controller_method_development_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('id', ModelPropertyType::BIG_INT())->unsigned()->primary()
            ->property('title', ModelPropertyType::STRING())
            ->webCrud()
            ->webAuthorization()
            ->softDeletes()
            ->softDeletionColumn('deleted_at');

        $expectedDeveloperDelegates = [
            'getIndexMethodDeveloper',
            'getShowMethodDeveloper',
            'getCreateMethodDeveloper',
            'getStoreMethodDeveloper',
            'getEditMethodDeveloper',
            'getUpdateMethodDeveloper',
            'getDestroyMethodDeveloper',
            'getForceDeleteDeveloper',
            'getRestoreDeveloper',
        ];
        $this->manager->methodDevelopers($expectedDeveloperDelegates);


        $developer = new CrudControllerDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        foreach ($expectedDeveloperDelegates as $delegate) {
            $this->manager->assertMethodDeveloperRequested($delegate);
        }
    }
}
