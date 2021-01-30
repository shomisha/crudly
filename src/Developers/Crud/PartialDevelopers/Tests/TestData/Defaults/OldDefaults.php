<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\Defaults;

class OldDefaults extends DefaultsGuesser
{
    protected function getDefaults(): array
    {
        return [
            'name' => 'Old Name',
            'title' => 'Old Title',
            'description' => 'Old Description',
            'body' => 'Old Body',
            'address' => 'Old Street 15, Old City, Old Country',
        ];
    }

    protected function getEmailDefault(): string
    {
        return 'old@test.com';
    }
}
