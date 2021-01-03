<?php

namespace Shomisha\Crudly\Commands;

use Illuminate\Support\Collection;
use Shomisha\Crudly\Crudly;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Subwizards\ModelPropertySubwizard;
use Shomisha\LaravelConsoleWizard\Command\Wizard;
use Shomisha\LaravelConsoleWizard\Contracts\Step;
use Shomisha\LaravelConsoleWizard\Steps\ChoiceStep;
use Shomisha\LaravelConsoleWizard\Steps\ConfirmStep;
use Shomisha\LaravelConsoleWizard\Steps\OneTimeWizard;
use Shomisha\LaravelConsoleWizard\Steps\TextStep;

class CrudlyWizard extends Wizard
{
    private const SOFT_DELETE_DEFAULT_COLUMN = 'deleted_at';
    private const NEW_COLUMN_OPTION = 'Create new column';

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
            )->withRepeatPrompt('Do you want to add a model property?', false, true),
            'has_soft_deletion' => new ConfirmStep("Do you want soft deletion for this model?"),
            'has_timestamps' => new ConfirmStep("Do you want timestamps for this model?"),
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

    public function answeredHasSoftDeletion(Step $step, bool $hasSoftDeletion)
    {
        if ($hasSoftDeletion) {
            if (!$this->hasSoftDeleteColumn()) {
                $this->askForSoftDeleteColumn();
            }
        }

        return $hasSoftDeletion;
    }

    public function answeredSoftDeleteColumnName(Step $step, string $name)
    {
        if ($name == self::NEW_COLUMN_OPTION) {
            $this->followUp(
                'soft_delete_column_name',
                new TextStep('Enter column name')
            );

            return null;
        }

        return $name;
    }

    public function answeredHasWeb(Step $step, bool $hasWeb)
    {
        if ($hasWeb) {
            $this->followUp(
                'has_web_authorization',
                new ConfirmStep("Should web CRUD actions be authorized?", true)
            );
        }

        return $hasWeb;
    }

    public function answeredHasApi(Step $step, bool $hasApi)
    {
        if ($hasApi) {
            $this->followUp(
                'has_api_authorization',
                new ConfirmStep("Should API CRUD endpoints be authorized?", true)
            );
        }

        return $hasApi;
    }

    function completed()
    {
        $specification = new CrudlySpecification(
            $this->crudly->parseModelName($this->answers->get('model')),
            $this->answers->all()
        );

        dd($this->crudly->develop($specification)->getModel()->print());
    }

    private function getPrimaryKeys(array $properties): Collection
    {
        return collect($properties)->where('is_primary', true)->pluck('name');
    }

    private function hasSoftDeleteColumn(): bool
    {
        return collect($this->answers->get('properties'))->where('name', self::SOFT_DELETE_DEFAULT_COLUMN)->isNotEmpty();
    }

    private function askForSoftDeleteColumn(): void
    {
        $defaultSoftDeleteColumn = self::SOFT_DELETE_DEFAULT_COLUMN;
        $timestampableColumns = $this->getSoftDeletableColumnNames();

        if (empty($timestampableColumns)) {
            $this->followUp(
                'soft_delete_column_name',
                new TextStep("No '{$defaultSoftDeleteColumn}' column found. Please enter name for timestamp column to be used for soft deletion.")
            );
            return;
        }

        $choiceOptions = array_merge($timestampableColumns, [self::NEW_COLUMN_OPTION]);
        $this->followUp('soft_delete_column_name', new ChoiceStep(
            "No '{$defaultSoftDeleteColumn}' column found. Please choose column for soft deletion",
            $choiceOptions
        ));
    }

    private function getSoftDeletableColumnNames(): array
    {
        return collect($this->answers->get('properties'))->whereIn('type', [
            ModelPropertyType::DATETIME()->value(),
            ModelPropertyType::TIMESTAMP()->value(),
        ])->pluck('name')->toArray();
    }
}
