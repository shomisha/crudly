<?php

namespace Shomisha\Crudly\Commands;

use Illuminate\Support\Collection;
use Shomisha\Crudly\Crudly;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Subwizards\ModelPropertySubwizard;
use Shomisha\LaravelConsoleWizard\Command\Wizard;
use Shomisha\LaravelConsoleWizard\Contracts\Step;
use Shomisha\LaravelConsoleWizard\Steps\ChoiceStep;
use Shomisha\LaravelConsoleWizard\Steps\ConfirmStep;
use Shomisha\LaravelConsoleWizard\Steps\TextStep;

class CrudlyWizard extends Wizard
{
    protected $description = 'Generates CRUD mechanisms for a specific model.';

    protected $signature = 'crudly:model';

    private Crudly $crudly;

    public function __construct(Crudly $crudly)
    {
        parent::__construct();

        $this->crudly = $crudly;
    }

    function getSteps(): array
    {
        return [
            'model' => new TextStep("Enter the name of your model"),
            'properties' => $this->repeat(
                $this->subWizard(new ModelPropertySubwizard())
            )->withRepeatPrompt('Do you want to add a model property?'),
            'has_web' => new ConfirmStep('Should this model have web pages for CRUD actions?'),
            'has_api' => new ConfirmStep('Should this model have API endpoints for CRUD actions?'),
        ];
    }

    public function answeredModel(Step $step, string $model)
    {
        if (!$this->crudly->modelNameIsValid($model)) {
            $this->error('The name you entered is invalid.');
            $this->followUp('model', new TextStep('Enter the name of your model'));
        } elseif ($this->crudly->modelExists($model)) {
            $this->followUp('override_model', new ConfirmStep("This model already exists. Do you want to override it?"));
        } else {
            $this->info("Define model properties:");
        }

        return $model;
    }

    public function answeredOverrideModel(Step $step, bool $override)
    {
        if (!$override) {
            $this->abort("Cancelled.");
        }

        return $override;
    }

    public function answeredProperties(Step $step, array $properties)
    {
        $primaryKeys = $this->getPrimaryKeys($properties);

        if ($primaryKeys->count() > 1) {
            $this->followUp('actual_primary_key', new ChoiceStep("You have specified multiple primary keys. Please select one.", $primaryKeys->all()));
        }

        return $properties;
    }

    function completed()
    {
        $specification = new CrudlySpecification(
            $this->crudly->parseModelName($this->answers->get('model')),
            $this->answers->all()
        );

        dd($specification);
    }

    private function getPrimaryKeys(array $properties): Collection
    {
        return collect($properties)->where('is_primary', true)->pluck('name');
    }
}
