<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Model;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Model\CastsDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassProperty;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class CastsDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_add_the_casts_property_to_model()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('published_at', ModelPropertyType::DATETIME())
            ->property('coauthors', ModelPropertyType::JSON());


        $developer = new CastsDeveloper($this->manager, $this->modelSupervisor);
        $castsProperty = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassProperty::class, $castsProperty);

        $model = ClassTemplate::name('Post')->addProperty($castsProperty);
        $this->assertStringContainsString("public \$casts = ['published_at' => 'datetime', 'coauthors' => 'array'];", $model->print());
    }

    /** @test */
    public function developer_will_not_add_the_casts_property_to_model_if_no_casts_are_available()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
                                                          ->property('title', ModelPropertyType::STRING())
                                                          ->property('body', ModelPropertyType::TEXT());


        $developer = new CastsDeveloper($this->manager, $this->modelSupervisor);
        $castsProperty = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassProperty::class, $castsProperty);

        $model = ClassTemplate::name('Post')->addProperty($castsProperty);
        $this->assertStringNotContainsString("public \$casts = [];", $model->print());
    }
}
