<?php

namespace Shomisha\Crudly\Developers\Tests\Api\Methods\Store;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\DeclarativeCode\Argument;

class InvalidStoreTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "user_cannot_create_new_{$modelComponent}_using_invalid_data";
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
