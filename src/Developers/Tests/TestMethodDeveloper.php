<?php

namespace Shomisha\Crudly\Developers\Tests;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Contracts\Developer as DeveloperContract;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Stubless\TestMethod;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;

/** @method \Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager getManager() */
abstract class TestMethodDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    final public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $testMethod = TestMethod::name($this->getName($specification))->withDataProvider(
            $this->getDataProvider($specification, $developedSet)
        );

        $testMethod->setBody(Block::fromArray([
            ...$this->getCodeFromDevelopers($this->getManager()->getArrangeDevelopers(), $specification, $developedSet),
            ...$this->getCodeFromDevelopers($this->getManager()->getActDevelopers(), $specification, $developedSet),
            ...$this->getCodeFromDevelopers($this->getManager()->getAssertDevelopers(), $specification, $developedSet),
        ]));

        return $testMethod;
    }

    abstract protected function getName(CrudlySpecification $specification): string;

    protected function getDataProvider(CrudlySpecification $specification, CrudlySet $developedSet): ?string
    {
        return null;
    }

    protected function getArrangeDeveloper(): DeveloperContract
    {
        return $this->getManager()->getArrangeDevelopers();
    }

    protected function getActDeveloper(): DeveloperContract
    {
        return $this->getManager()->getActDevelopers();
    }

    protected function getAssertDeveloper(): DeveloperContract
    {
        return $this->getManager()->getAssertDevelopers();
    }

    /**
     * @param \Shomisha\Crudly\Contracts\Developer[] $developers
     * @return \Shomisha\Stubless\Contracts\Code[]
     */
    final protected function getCodeFromDevelopers(array $developers, CrudlySpecification $specification, CrudlySet $developedSet): array
    {
        return array_values(array_map(function (Developer $developer) use ($specification, $developedSet) {
            return $developer->develop($specification, $developedSet);
        }, $developers));
    }
}
