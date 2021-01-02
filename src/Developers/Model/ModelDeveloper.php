<?php

namespace Shomisha\Crudly\Developers\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Enums\RelationshipType;
use Shomisha\Crudly\Managers\ModelDeveloperManager;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassProperty;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Utilities\Importable;

/**
 * Class ModelDeveloper
 *
 * @method \Shomisha\Crudly\Managers\ModelDeveloperManager getManager()
 */
class ModelDeveloper extends Developer
{
    private ModelSupervisor $modelSupervisor;

    public function __construct(ModelDeveloperManager $manager, ModelSupervisor $modelSupervisor)
    {
        parent::__construct($manager);

        $this->modelSupervisor = $modelSupervisor;
    }

    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $modelName = $specification->getModel();

        $modelTemplate = ClassTemplate::name($modelName->getName())->setNamespace($modelName->getNamespace());
        $modelTemplate->extends(new Importable(Model::class));

        if ($specification->hasSoftDeletion()) {
            $this->addSoftDeletion($modelTemplate, $specification);
        }

        if (!$specification->hasTimestamps()) {
            $modelTemplate->addProperty(
                ClassProperty::name('timestamps')->value(false)
            );
        }

        foreach ($this->getRelationshipMethods($specification) as $relationshipMethod) {
            $modelTemplate->addMethod($relationshipMethod);
        }

        $developedSet->setModel($modelTemplate);
        return $modelTemplate;
    }

    private function addSoftDeletion(ClassTemplate $model, CrudlySpecification $specification): void
    {
        $model->uses([new Importable(SoftDeletes::class)]);

        if ($columnName = $specification->softDeletionColumnName()) {
            $model->addMethod(
                ClassMethod::name('getDeletedAtColumn')->makePublic()->body(Block::return($columnName))
            );
        }
    }

    /** @return \Shomisha\Stubless\DeclarativeCode\ClassMethod[] */
    private function getRelationshipMethods(CrudlySpecification $specification): array
    {
        $relationshipMethods = [];

        foreach ($specification->getProperties() as $modelPropertySpecification) {
            if ($modelPropertySpecification->isForeignKey() && $modelPropertySpecification->getForeignKeySpecification()->hasRelationship()) {
                $relationshipMethods[] = $this->convertPropertySpecificationToRelationshipMethod($modelPropertySpecification);
            }
        }

        return array_filter($relationshipMethods);
    }

    private function convertPropertySpecificationToRelationshipMethod(ModelPropertySpecification $specification): ?ClassMethod
    {
        $foreignKeySpecification = $specification->getForeignKeySpecification();

        $relationshipTargetTable = $foreignKeySpecification->getForeignKeyTable();
        $modelName = $this->modelSupervisor->parseModelName(
            Str::of($relationshipTargetTable)->studly()->singular()
        );

        if (!$this->modelSupervisor->modelExists($modelName->getName())) {
            return null;
        }

        return $this->prepareRelationshipMethod(
            $foreignKeySpecification->getRelationshipType(),
            $modelName,
            $foreignKeySpecification->getRelationshipName(),
            $specification->getName(),
            $foreignKeySpecification->getForeignKeyField(),
        );
    }

    private function prepareRelationshipMethod(RelationshipType $type, ModelName $model, string $relationshipName, string $foreignKeyField, string $localKeyField): ClassMethod
    {
        $method = ClassMethod::name($relationshipName);

        $method->body(
            Block::return(
                Block::invokeMethod(
                    Reference::this(),
                    $type->value(),
                    [
                        Reference::classReference(
                            $model->getName()
                        ),
                        $foreignKeyField,
                        $localKeyField,
                    ]
                )
            )
        );

        return $method;
    }
}
