<?php

namespace Shomisha\Crudly\Developers\Tests\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\Utilities\Importable;

/** @method \Shomisha\Crudly\Managers\Tests\Api\ApiTestsDeveloperManager getManager() */
class ApiTestsDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassTemplate
    {
        $apiTestsClass = ClassTemplate::name(
            $this->guessTestClassShortName($specification->getModel())
        )->extends(new Importable('Tests\TestCase'))->setNamespace($this->guessTestNamespace());

        $developedSet->setApiTests($apiTestsClass);

        $apiTestsClass->uses([
            new Importable(RefreshDatabase::class)
        ]);

        foreach ($this->getHelperMethodDevelopers($specification) as $developer) {
            $apiTestsClass->addMethod($developer->develop($specification, $developedSet));
        }

        foreach ($this->getTestDevelopers($specification) as $developer) {
            $apiTestsClass->addMethod($developer->develop($specification, $developedSet));
        }

        return $apiTestsClass;
    }

    protected function guessTestNamespace(): string
    {
        return "Tests\Feature\Api";
    }

    protected function getHelperMethodDevelopers(CrudlySpecification $specification): array
    {
        $developers = $this->getManager()->getHelperMethodDevelopers();

        if ($specification->hasApiAuthorization()) {
            $developers = array_merge($developers, $this->getManager()->getAuthorizationHelperMethodDevelopers());
        }

        return array_merge(
            $developers,
            $this->getManager()->getRouteMethodDevelopers(),
        );
    }

    protected function getTestDevelopers(CrudlySpecification $specification): array
    {
        $manager = $this->getManager();
        $developers = [];
        $hasAuthorization = $specification->hasApiAuthorization();


        $developers[] = $manager->getIndexTestDeveloper();
        if ($hasAuthorization) {
            $developers[] = $manager->getUnauthorizedIndexTestDeveloper();
        }


        $developers[] = $manager->getShowDeveloper();
        if ($hasAuthorization) {
            $developers[] = $manager->getUnauthorizedShowDeveloper();
        }


        $developers[] = $manager->getStoreDeveloper();
        $developers[] = $manager->getInvalidDataProviderDeveloper();
        $developers[] = $manager->getInvalidStoreDeveloper();
        if ($hasAuthorization) {
            $developers[] = $manager->getUnauthorizedStoreDeveloper();
        }

        $developers[] = $manager->getUpdateDeveloper();
        $developers[] = $manager->getInvalidUpdateDeveloper();
        if ($hasAuthorization) {
            $developers[] = $manager->getUnauthorizedUpdateDeveloper();
        }

        $developers[] = $manager->getDestroyDeveloper();
        if ($hasAuthorization) {
            $developers[] = $manager->getUnauthorizedDestroyDeveloper();
        }

        if ($specification->hasSoftDeletion()) {
            $developers[] = $manager->getForceDeleteDeveloper();
            if ($hasAuthorization) {
                $developers[] = $manager->getUnauthorizedForceDeleteDeveloper();
            }

            $developers[] = $manager->getRestoreDeveloper();
            if ($hasAuthorization) {
                $developers[] = $manager->getUnauthorizedRestoreDeveloper();
            }
        }

        return $developers;
    }
}
