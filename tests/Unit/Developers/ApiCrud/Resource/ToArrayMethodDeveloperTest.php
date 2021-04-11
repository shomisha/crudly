<?php

namespace Shomisha\Crudly\Test\Unit\Developers\ApiCrud\Resource;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\Api\Resource\ToArrayMethodDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Crud\Api\ApiResourceDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class ToArrayMethodDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_to_api_method()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Patient')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->timestamps(false);


        $manager = new ApiResourceDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new ToArrayMethodDeveloper($manager, $this->modelSupervisor);
        $method = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $method);

        $class = ClassTemplate::name('TestClass')->addMethod($method);

        $this->assertStringContainsString(implode("\n", [
            "    public function toArray(\$request)",
            "    {",
            "        return ['id' => \$this->id, 'name' => \$this->name];",
            "    }",
        ]), $class->print());
    }

    /** @test */
    public function developer_will_delegate_model_field_mappings_development_to_other_developer()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Patient');

        $this->manager->valueDevelopers(['getPropertyToResourceMappingDeveloper']);


        $developer = new ToArrayMethodDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertValueDeveloperRequested('getPropertyToResourceMappingDeveloper');
    }
}
