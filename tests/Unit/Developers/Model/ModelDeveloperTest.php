<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Model;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Model\ModelDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\ModelDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class ModelDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_model()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('id', ModelPropertyType::BIG_INT())->unsigned()->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('birth_date', ModelPropertyType::DATE())
            ->property('manager_id', ModelPropertyType::BIG_INT())->unsigned()
                ->isForeign('id', 'managers')
                ->isRelationship('manager')
            ->property('first_book_id', ModelPropertyType::BIG_INT())->unsigned()
                ->isForeign('id', 'books')
                ->isRelationship('firstBook')
            ->property('published_books', ModelPropertyType::JSON())
            ->softDeletes()
            ->softDeletionColumn('stopped_writing_at')
            ->timestamps(true);

        $this->modelSupervisor->expectedExistingModels([
            'Manager',
            'Book'
        ]);


        $manager = new ModelDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new ModelDeveloper($manager, $this->modelSupervisor);
        $developedModel = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassTemplate::class, $developedModel);

        $printedModel = $developedModel->print();


        $this->assertStringContainsString(
            "namespace App\Models;\n\n" .
                   "use Illuminate\Database\Eloquent\Factories\HasFactory;\n" .
                   "use Illuminate\Database\Eloquent\Model;\n" .
                   "use Illuminate\Database\Eloquent\SoftDeletes;\n\n" .
                   "class Author extends Model\n" .
                   "{\n" .
                   "    use SoftDeletes, HasFactory;\n\n" .
                   "    public \$casts = ['birth_date' => 'date', 'published_books' => 'array'];\n\n" .
                   "    public function getDeletedAtColumn()\n" .
                   "    {\n" .
                   "        return 'stopped_writing_at';\n" .
                   "    }\n\n" .
                   "    public function manager()\n" .
                   "    {\n" .
                   "        return \$this->belongsTo(Manager::class, 'manager_id', 'id');\n" .
                   "    }\n\n" .
                   "    public function firstBook()\n" .
                   "    {\n" .
                   "        return \$this->belongsTo(Book::class, 'first_book_id', 'id');\n" .
                   "    }\n" .
                   "}",
            $printedModel
        );
    }

    /** @test */
    public function developer_can_disable_timestamps_if_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->timestamps(false);


        $manager = new ModelDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new ModelDeveloper($manager, $this->modelSupervisor);
        $printed = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString(implode("\n", [
                "class Author extends Model",
                "{",
                "    use HasFactory;\n",
                "    public \$timestamps = false;",
                "}",
            ]),
            $printed
        );
    }

    /** @test */
    public function developer_will_delegate_soft_deletion_and_relationships_and_casts_development_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('id', ModelPropertyType::BIG_INT())->unsigned()->primary()
            ->softDeletes(true)
            ->softDeletionColumn('deleted_at');

        $this->manager->methodDevelopers([
            'getSoftDeletionDeveloper',
            'getRelationshipsDeveloper'
        ])->propertyDevelopers([
            'getCastsDeveloper'
        ]);


        $developer = new ModelDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertMethodDeveloperRequested('getSoftDeletionDeveloper');
        $this->manager->assertMethodDeveloperRequested('getRelationshipsDeveloper');
        $this->manager->assertPropertyDeveloperRequested('getCastsDeveloper');
    }
}
