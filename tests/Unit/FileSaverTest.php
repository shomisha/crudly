<?php

namespace Shomisha\Crudly\Test\Unit;

use Illuminate\Support\Facades\Storage;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Test\Mocks\ModelSupervisorMock;
use Shomisha\Crudly\Utilities\FileSaver\FileSaver;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Tests\TestCase;

class FileSaverTest extends TestCase
{
    /** @test */
    public function it_will_save_all_files_from_developed_set()
    {
        $disk = Storage::fake();

        $developedSet = (new CrudlySet())
            ->setMigration(ClassTemplate::name('CreateTestModelsTable'))
            ->setModel(ClassTemplate::name('TestModel'))
            ->setFactory(ClassTemplate::name('TestModelFactory'))
            ->setWebCrudController(ClassTemplate::name('TestModelsController'))
            ->setWebCrudFormRequest(ClassTemplate::name('TestModelRequest'))
            ->setWebTests(ClassTemplate::name('TestModelTest'))
            ->setApiCrudController(ClassTemplate::name('TestModelsController'))
            ->setApiCrudFormRequest(ClassTemplate::name('TestModelRequest'))
            ->setApiCrudApiResource(ClassTemplate::name('TestModelResource'))
            ->setApiTests(ClassTemplate::name('TestModelTest'))
            ->setPolicy(ClassTemplate::name('TestModelPolicy'));

        $modelSupervisor = new ModelSupervisorMock();


        $fileSaver = new FileSaver(
            $modelSupervisor,
            $disk->path(''),
            $disk->path('app')
        );
        $fileSaver->saveAllFiles($developedSet);


        $this->assertStringContainsString('create_test_models_table.php', $disk->allFiles('database/migrations')[0]);
        $disk->assertExists('app/Models/TestModel.php');
        $disk->assertExists('database/factories/TestModelFactory.php');
        $disk->assertExists('app/Http/Controllers/Web/TestModelsController.php');
        $disk->assertExists('app/Http/Requests/Web/TestModelRequest.php');
        $disk->assertExists('tests/Feature/Web/TestModelTest.php');
        $disk->assertExists('app/Http/Controllers/Api/TestModelsController.php');
        $disk->assertExists('app/Http/Requests/Api/TestModelRequest.php');
        $disk->assertExists('app/Http/Resources/TestModelResource.php');
        $disk->assertExists('tests/Feature/Api/TestModelTest.php');
        $disk->assertExists('app/Policies/TestModelPolicy.php');
    }

    /** @test */
    public function file_saver_will_not_save_omitted_files()
    {
        $developedSet = (new CrudlySet())
            ->setMigration(ClassTemplate::name('CreateAuthorsTable'))
            ->setModel(ClassTemplate::name('Author'))
            ->setFactory(ClassTemplate::name('AuthorFactory'));

        $disk = Storage::fake();
        $modelSupervisor = new ModelSupervisorMock();


        $fileSaver = new FileSaver(
            $modelSupervisor,
            $disk->path(''),
            $disk->path('app')
        );
        $fileSaver->saveAllFiles($developedSet);


        $this->assertStringContainsString('create_authors_table.php', $disk->allFiles('database/migrations')[0]);
        $disk->assertExists('app/Models/Author.php');
        $disk->assertExists('database/factories/AuthorFactory.php');
        $disk->assertMissing('app/Http/Controllers/Web/AuthorsController.php');
        $disk->assertMissing('app/Http/Requests/Web/AuthorRequest.php');
        $disk->assertMissing('tests/Feature/Web/AuthorTest.php');
        $disk->assertMissing('app/Http/Controllers/Api/AuthorsController.php');
        $disk->assertMissing('app/Http/Requests/Api/AuthorRequest.php');
        $disk->assertMissing('app/Http/Resources/AuthorResource.php');
        $disk->assertMissing('tests/Feature/Api/AuthorTest.php');
        $disk->assertMissing('app/Policies/AuthorPolicy.php');
    }
}
