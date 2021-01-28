<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\Defaults;

class NewDefaults extends DefaultsGuesser
{
    protected function getDefaults(): array
    {
        // TODO: make these configurable
        return [
            'name' => 'New Name',
            'title' => 'New Title',
            'description' => 'New Description',
            'body' => 'New Body',
            'address' => 'New Street 10, New City, New Country',
        ];
    }

    protected function getEmailDefault(): string
    {
        return 'new@test.com';
    }
}
