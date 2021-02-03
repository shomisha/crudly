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
        return [
            $this->getManager()->getAuthenticateUserMethodDeveloper(),
            $this->getManager()->getAuthorizeMethodDeveloper(),
            $this->getManager()->getDeauthorizeMethodDeveloper(),
            ...$this->getManager()->getRouteMethodDevelopers(),
            $this->getManager()->getDataMethodDeveloper(),
        ];
    }

    protected function getTestDevelopers(CrudlySpecification $specification): array
    {
        $developers = [];
        $hasAuthorization = $specification->hasApiAuthorization();


        $developers[] = $this->getManager()->getIndexTestDeveloper();
        if ($hasAuthorization) {
            $developers[] = $this->getManager()->getUnauthorizedIndexTestDeveloper();
        }


        $developers[] = $this->getManager()->getShowDeveloper();
        if ($hasAuthorization) {
            $developers[] = $this->getManager()->getUnauthorizedShowDeveloper();
        }


        $developers[] = $this->getManager()->getStoreDeveloper();
        $developers[] = $this->getManager()->getInvalidDataProviderDeveloper();
        $developers[] = $this->getManager()->getInvalidStoreDeveloper();
        if ($hasAuthorization) {
            $developers[] = $this->getManager()->getUnauthorizedStoreDeveloper();
        }

        $developers[] = $this->getManager()->getUpdateDeveloper();
        $developers[] = $this->getManager()->getInvalidUpdateDeveloper();
        if ($hasAuthorization) {
            $developers[] = $this->getManager()->getUnauthorizedUpdateDeveloper();
        }

        return $developers;
    }
}
