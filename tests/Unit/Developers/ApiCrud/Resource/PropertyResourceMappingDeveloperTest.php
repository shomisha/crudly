<?php

namespace Shomisha\Crudly\Test\Unit\Developers\ApiCrud\Resource;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\Api\Resource\PropertyResourceMappingDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\Values\ArrayValue;

class PropertyResourceMappingDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_field_mappings_for_all_fields()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Patient')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->property('name', ModelPropertyType::STRING())
            ->property('doctor_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'doctors')
                ->isRelationship('doctor')
            ->property('disease_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'diseases')
                ->isRelationship('disease')
            ->property('hospital_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'hospitals')
            ->timestamps(true);

        $this->modelSupervisor->expectedExistingModels(['Disease']);


        $developer = new PropertyResourceMappingDeveloper($this->manager, $this->modelSupervisor);
        $mappings = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ArrayValue::class, $mappings);
        $this->assertStringContainsString("['id' => \$this->id, 'email' => \$this->email, 'name' => \$this->name, 'doctor_id' => \$this->doctor_id, 'disease' => new DiseaseResource(\$this->whenLoaded('disease')), 'hospital_id' => \$this->hospital_id, 'updated_at' => \$this->updated_at, 'created_at' => \$this->created_at];", $mappings->print());
    }

    /** @test */
    public function developer_will_always_place_primary_key_first()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Patient')
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->property('name', ModelPropertyType::STRING())
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('hospital_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'hospitals')
            ->timestamps(true);


        $developer = new PropertyResourceMappingDeveloper($this->manager, $this->modelSupervisor);
        $mappings = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ArrayValue::class, $mappings);
        $this->assertStringContainsString("['id' => \$this->id, 'email' => \$this->email, 'name' => \$this->name, 'hospital_id' => \$this->hospital_id, 'updated_at' => \$this->updated_at, 'created_at' => \$this->created_at];", $mappings->print());
    }

    /** @test */
    public function developer_will_not_develop_timestamp_mappings_if_timestamps_were_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Patient')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->property('name', ModelPropertyType::STRING())
            ->property('hospital_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'hospitals')
            ->timestamps(false);


        $developer = new PropertyResourceMappingDeveloper($this->manager, $this->modelSupervisor);
        $mappings = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ArrayValue::class, $mappings);
        $this->assertStringContainsString("['id' => \$this->id, 'email' => \$this->email, 'name' => \$this->name, 'hospital_id' => \$this->hospital_id];", $mappings->print());
    }

    /** @test */
    public function developer_will_use_relationship_foreign_key_as_mapping_name_and_parent_foreign_key_as_mapping_if_related_model_does_not_exist()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Patient')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('doctor_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'doctors')
                ->isRelationship('doctor')
            ->timestamps(false);

        $this->modelSupervisor->expectedExistingModels([]);


        $developer = new PropertyResourceMappingDeveloper($this->manager, $this->modelSupervisor);
        $mappings = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ArrayValue::class, $mappings);
        $this->assertStringContainsString("['id' => \$this->id, 'doctor_id' => \$this->doctor_id];", $mappings->print());
    }

    /** @test */
    public function developer_will_use_relationship_name_as_mapping_name_and_related_model_resource_as_mapping_if_related_model_does_not_exist()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Patient')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('doctor_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'doctors')
                ->isRelationship('doctor_who')
            ->timestamps(false);

        $this->modelSupervisor->expectedExistingModels(['Doctor']);


        $developer = new PropertyResourceMappingDeveloper($this->manager, $this->modelSupervisor);
        $mappings = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ArrayValue::class, $mappings);
        $this->assertStringContainsString("['id' => \$this->id, 'doctor_who' => new DoctorResource(\$this->whenLoaded('doctor_who'))];", $mappings->print());
    }
}
