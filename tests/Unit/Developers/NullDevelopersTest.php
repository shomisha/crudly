<?php

namespace Shomisha\Crudly\Test\Unit\Developers;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\NullClassDeveloper;
use Shomisha\Crudly\Developers\NullDeveloper;
use Shomisha\Crudly\Developers\NullMethodDeveloper;
use Shomisha\Crudly\Developers\NullPropertyDeveloper;
use Shomisha\Crudly\Developers\NullValueDeveloper;
use Shomisha\Crudly\Stubless\NullClass;
use Shomisha\Crudly\Stubless\NullMethod;
use Shomisha\Crudly\Stubless\NullProperty;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\TestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassProperty;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Values\NullValue;

class NullDevelopersTest extends TestCase
{
    /** @test */
    public function null_class_developer_can_implement_null_test_class()
    {
        $developer = new NullClassDeveloper();


        $nullClass = $developer->develop(CrudlySpecificationBuilder::forModel('Post')->build(), new CrudlySet());


        $this->assertInstanceOf(NullClass::class, $nullClass);
        $this->assertInstanceOf(ClassTemplate::class, $nullClass);

        $this->assertEquals("<?php\n\n", $nullClass->print());
    }

    /** @test */
    public function null_developer_can_develop_empty_block()
    {
        $developer = new NullDeveloper();


        $nullBlock = $developer->develop(CrudlySpecificationBuilder::forModel('Post')->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $nullBlock);

        $this->assertEquals("<?php\n\n", $nullBlock->print());
    }

    /** @test */
    public function null_method_developer_can_develop_null_class_method()
    {
        $developer = new NullMethodDeveloper();


        $nullMethod = $developer->develop(CrudlySpecificationBuilder::forModel('Post')->build(), new CrudlySet());


        $this->assertInstanceOf(NullMethod::class, $nullMethod);
        $this->assertInstanceOf(ClassMethod::class, $nullMethod);

        $this->assertEquals("<?php\n\n", $nullMethod->print());
    }

    /** @test */
    public function null_property_developer_can_develop_null_class_property()
    {
        $developer = new NullPropertyDeveloper();


        $nullProperty = $developer->develop(CrudlySpecificationBuilder::forModel('Post')->build(), new CrudlySet());


        $this->assertInstanceOf(NullProperty::class, $nullProperty);
        $this->assertInstanceOf(ClassProperty::class, $nullProperty);

        $this->assertEquals("<?php\n\n", $nullProperty->print());
    }

    /** @test */
    public function null_value_developer_can_develop_null_value()
    {
        $developer = new NullValueDeveloper();


        $nullValue = $developer->develop(CrudlySpecificationBuilder::forModel('Post')->build(), new CrudlySet());


        $this->assertInstanceOf(NullValue::class, $nullValue);

        $this->assertEquals("<?php\n\nnull;", $nullValue->print());
    }
}
