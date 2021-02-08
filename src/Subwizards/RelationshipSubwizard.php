<?php

namespace Shomisha\Crudly\Subwizards;

use Shomisha\Crudly\Enums\ForeignKeyAction;
use Shomisha\Crudly\Enums\RelationshipType;
use Shomisha\LaravelConsoleWizard\Command\Subwizard;
use Shomisha\LaravelConsoleWizard\Contracts\Step;
use Shomisha\LaravelConsoleWizard\Steps\ChoiceStep;
use Shomisha\LaravelConsoleWizard\Steps\ConfirmStep;
use Shomisha\LaravelConsoleWizard\Steps\OneTimeWizard;
use Shomisha\LaravelConsoleWizard\Steps\TextStep;

class RelationshipSubwizard extends Subwizard
{
    function getSteps(): array
    {
        return [
            'table' => new TextStep('Which table should this foreign key point to?'),
            'field' => new TextStep('Which field should this foreign key point to?'),
            'has_relationship' => new ConfirmStep('Do you want a relationship for this method?', true),
            'on_delete' => new ChoiceStep('What should happen on row delete?', ForeignKeyAction::all()),
            'on_update' => new ChoiceStep('What should happen on row update?', ForeignKeyAction::all())
        ];
    }

    public function answeredHasRelationship(Step $step, bool $hasRelationship)
    {
        if ($hasRelationship) {
            $this->followUp(
                'relationship',
                $this->subWizard(
                    new OneTimeWizard([
                        'name' => new TextStep('Enter the name for this relationship'),
                        'type' => new ChoiceStep('Choose relationship type', RelationshipType::all()),
                    ])
                )
            );
        }

        return $hasRelationship;
    }
}
