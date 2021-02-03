<?php

namespace Shomisha\Crudly\Developers\Tests\Api;

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

        foreach ($this->getHelperMethodDevelopers() as $developer) {
            $apiTestsClass->addMethod($developer->develop($specification, $developedSet));
        }

        foreach ($this->getTestDevelopers($specification) as $developer) {
            $apiTestsClass->addMethod($developer->develop($specification, $developedSet));
        }

        return $apiTestsClass;
    }

    protected function getHelperMethodDevelopers(): array
    {
        $manager = $this->getManager();

        return [
            $manager->getAuthenticateUserMethodDeveloper(),
            $manager->getAuthorizeMethodDeveloper(),
            $manager->getDeauthorizeMethodDeveloper(),
            ...$manager->getRouteMethodDevelopers(),
            $manager->getDataMethodDeveloper(),
        ];
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
