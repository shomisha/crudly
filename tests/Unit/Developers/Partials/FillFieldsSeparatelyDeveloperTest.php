<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\Web\Store\Fill\FillFieldsSeparatelyDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Crud\Web\StoreMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\Block;

class FillFieldsSeparatelyDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_filling_each_property_separately()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('title', ModelPropertyType::STRING())
            ->property('author_id', ModelPropertyType::BIG_INT());


        $manager = new StoreMethodDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new FillFieldsSeparatelyDeveloper($manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringContainsString(implode("\n", [
            "\$post->title = \$request->input('title');",
            "\$post->author_id = \$request->input('author_id');",
        ]), $block->print());
    }

    /** @test */
    public function developer_will_delegate_filling_fields_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('title', ModelPropertyType::STRING())
            ->property('author_id', ModelPropertyType::BIG_INT());

        $this->manager->imperativeCodeDevelopers(['getFillFieldDeveloper']);


        $developer = new FillFieldsSeparatelyDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertCodeDeveloperRequested('getFillFieldDeveloper');
    }

    /** @test */
    public function developer_will_not_fill_primary_properties()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('title', ModelPropertyType::STRING());


        $manager = new StoreMethodDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new FillFieldsSeparatelyDeveloper($manager, $this->modelSupervisor);
        $printedBlock = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString("\$post->title = \$request->input('title');", $printedBlock);
        $this->assertStringNotContainsString("\$post->id = ", $printedBlock);
    }
}
