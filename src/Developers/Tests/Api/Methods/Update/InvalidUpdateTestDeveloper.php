<?php

namespace Shomisha\Crudly\Developers\Tests\Api\Methods\Update;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\DeclarativeCode\Argument;

class InvalidUpdateTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "user_cannot_update_{$modelComponent}_using_invalid_data";
    }

    protected function getDataProvider(CrudlySpecification $specification, CrudlySet $developedSet): ?string
    {
        return $this->guessInvalidDataProviderName($specification->getModel());
    }

    protected function getArguments(): array
    {
        return [
            Argument::name('field')->type('string'),
            Argument::name('value'),
        ];
    }
}
