<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Store;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\DeclarativeCode\Argument;

class InvalidStoreTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $component = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "user_cannot_create_{$component}_using_invalid_data";
    }

    protected function getArguments(): array
    {
        return [
            Argument::name('field')->type('string'),
            Argument::name('value')
        ];
    }

    protected function getDataProvider(CrudlySpecification $specification, CrudlySet $developedSet): ?string
    {
        return $this->guessInvalidDataProviderName($specification->getModel());
    }
}
