<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\Web\Store\Fill\FillUsingDedicatedMethodDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class FillUsingDedicatedMethodDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_fill_model_using_dedicated_controller_method()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new FillUsingDedicatedMethodDeveloper($this->manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $developedSet->setWebCrudController(ClassTemplate::name('PostController'));
        $block = $developer->develop($specificationBuilder->build(), $developedSet);


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);

        $this->assertStringContainsString("\$this->fillFromRequest(\$post, \$request);", $block->print());
    }

    /** @test */
    public function developer_will_add_fill_model_method_to_controller()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('title', ModelPropertyType::STRING())
            ->property('body', ModelPropertyType::TEXT())
            ->property('published_at', ModelPropertyType::DATE())
            ->property('likes', ModelPropertyType::INT())
            ->property('views', ModelPropertyType::BIG_INT());


        $developer = new FillUsingDedicatedMethodDeveloper($this->manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $controller = ClassTemplate::name('PostController');
        $developedSet->setWebCrudController($controller);
        $developer->develop($specificationBuilder->build(), $developedSet);


        $this->assertStringContainsString(implode("\n", [
            "    private function fillFromRequest(Post \$post, PostRequest \$request) : Post",
            "    {",
            "        \$post->title = \$request->input('title');",
            "        \$post->body = \$request->input('body');",
            "        \$post->published_at = \$request->input('published_at');",
            "        \$post->likes = \$request->input('likes');",
            "        \$post->views = \$request->input('views');\n",
            "        return \$post;",
            "    }",
        ]), $controller->print());
    }
}
