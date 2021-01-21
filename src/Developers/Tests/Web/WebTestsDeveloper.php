<?php

namespace Shomisha\Crudly\Developers\Tests\Web;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\Utilities\Importable;

/**
 * Class WebTestsDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Tests\Web\WebTestsDeveloperManager getManager()
 */
class WebTestsDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $webTestsClass = ClassTemplate::name(
            $this->guessTestClassName($specification->getModel())
        )->extends(new Importable('Tests\TestCase'));

        $webTestsClass->setName('Tests\Feature\Web');

        foreach ($this->getTestDevelopers($specification) as $developer) {
            $webTestsClass->addMethod($developer->develop($specification, $developedSet));
        }

        return $webTestsClass;
    }

    /** @return \Shomisha\Crudly\Developers\Tests\TestsDeveloper[] */
    protected function getTestDevelopers(CrudlySpecification $specification): array
    {
        $manager = $this->getManager();
        $hasAuthorization = $specification->hasWebAuthorization();

        $developers = [];

        $developers[] = $manager->getIndexTestDeveloper();
        if ($hasAuthorization) {
            $developers[] = $manager->getUnauthorizedIndexTestDeveloper();
        }

        $developers[] = $manager->getShowTestDeveloper();
        if ($hasAuthorization) {
            $developers[] = $manager->getUnauthorizedShowTestDeveloper();
        }

        $developers[] = $manager->getCreateTestDeveloper();
        if ($hasAuthorization) {
            $developers[] = $manager->getUnauthorizedCreateTestDeveloper();
        }

        $developers[] = $manager->getStoreTestDeveloper();
        $developers[] = $manager->getStoreInvalidDataProviderDeveloper();
        $developers[] = $manager->getInvalidDataStoreTestDeveloper();
        if ($hasAuthorization) {
            $developers[] = $manager->getUnauthorizedStoreTestDeveloper();
        }

        $developers[] = $manager->getEditTestDeveloper();
        if ($hasAuthorization) {
            $developers[] = $manager->getUnauthorizedEditTestDeveloper();
        }


        $developers[] = $manager->getUpdateTestDeveloper();
        $developers[] = $manager->getUpdateInvalidDataProviderDeveloper();
        $developers[] = $manager->getInvalidDataUpdateTestDeveloper();
        if ($hasAuthorization) {
            $developers[] = $manager->getUnauthorizedUpdateTestDeveloper();
        }

        $developers[] = $manager->getDestroyTestDeveloper();
        if ($hasAuthorization) {
            $developers[] = $manager->getUnauthorizedDestroyTestDeveloper();
        }

        if ($specification->hasSoftDeletion()) {
            $developers[] = $manager->getForceDeleteTestDeveloper();
            if ($hasAuthorization) {
                $developers[] = $manager->getUnauthorizedForceDeleteTestDeveloper();
            }

            $developers[] = $manager->getRestoreTestDeveloper();
            if ($hasAuthorization) {
                $developers[] = $manager->getUnauthorizedRestoreTestDeveloper();
            }
        }

        return $developers;
    }
}
