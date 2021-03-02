<?php

namespace Shomisha\Crudly\Test\Unit\Developers\ApiCrud\Resource;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\Api\Resource\ApiResourceDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Crud\Api\ApiResourceDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;

class ResourceDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_api_resource()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Book')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('title', ModelPropertyType::STRING())
                ->unique()
            ->property('cover_color', ModelPropertyType::STRING())
            ->property('author_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'authors')
                ->isRelationship('author')
            ->property('publisher_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'publishers')
                ->isRelationship('publisher')
            ->property('category_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'categories')
            ->property('published_at', ModelPropertyType::DATETIME())
                ->nullable()
            ->timestamps(true);

        $this->modelSupervisor->expectedExistingModels(['Author', 'Publisher']);


        $manager = new ApiResourceDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new ApiResourceDeveloper($manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $resource = $developer->develop($specificationBuilder->build(), $developedSet);


        $this->assertEquals($resource, $developedSet->getApiCrudApiResource());

        $printedResource = $resource->print();

        $this->assertStringContainsString("namespace App\Http\Resources;", $printedResource);

        $this->assertStringContainsString("use App\Http\Resources\AuthorResource;", $printedResource);
        $this->assertStringContainsString("use App\Http\Resources\PublisherResource;", $printedResource);
        $this->assertStringContainsString("use Illuminate\Http\Resources\Json\JsonResource;", $printedResource);

        $this->assertStringContainsString(implode("\n", [
            "class BookResource extends JsonResource",
            "{",
            "    public function toArray(\$request)",
            "    {",
            "        return ['id' => \$this->id, 'title' => \$this->title, 'cover_color' => \$this->cover_color, 'author' => new AuthorResource(\$this->whenLoaded('author')), 'publisher' => new PublisherResource(\$this->whenLoaded('publisher')), 'category_id' => \$this->category_id, 'published_at' => \$this->published_at, 'updated_at' => \$this->updated_at, 'created_at' => \$this->created_at];",
            "    }",
            "}"
        ]), $printedResource);
    }

    /** @test */
    public function developer_will_delegate_to_array_method_development_to_other_developer()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');

        $this->manager->methodDevelopers([
            'getToArrayMethodDeveloper',
        ]);


        $developer = new ApiResourceDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertMethodDeveloperRequested('getToArrayMethodDeveloper');
    }
}
