<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Factory;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Factory\FactoryModelPropertyDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassProperty;

class FactoryModelPropertyDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_property_with_model_name_as_value()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new FactoryModelPropertyDeveloper($this->manager, $this->modelSupervisor);
        $property = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassProperty::class, $property);

        $this->assertEquals('App\Models\Post', $property->getDelegatedImports()['App\Models\Post']->getName());

        $printedProperty = $property->print();
        $this->assertStringContainsString("protected \$model = Post::class;", $printedProperty);
    }
}
