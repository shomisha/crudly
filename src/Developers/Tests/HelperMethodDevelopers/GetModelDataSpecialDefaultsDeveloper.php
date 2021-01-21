<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\ForeignKeySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Abstractions\ImperativeCode;
use Shomisha\Stubless\Comparisons\Comparison;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Utilities\Importable;

class GetModelDataSpecialDefaultsDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $defaults = Block::fromArray([]);

        foreach ($specification->getProperties() as $property) {
            if ($this->needsSpecialDefault($property)) {
                $defaults->addCode(
                    $this->prepareSpecialDefault($property)
                );
            }
        }

        return $defaults;
    }

    protected function needsSpecialDefault(ModelPropertySpecification $property): bool
    {
        return !$property->isPrimaryKey() && $property->isForeignKey();
    }

    protected function prepareSpecialDefault(ModelPropertySpecification $property): ImperativeCode
    {
        $ifBlock = Block::if(
            Comparison::not(
                Block::invokeFunction(
                    'array_key_exists',
                    [
                        $property->getName(),
                        Reference::variable('override')
                    ]
                )
            )
        );

        $ifBlock->then(
            $this->guessSpecialDefault($property)
        );

        return $ifBlock;
    }

    protected function guessSpecialDefault(ModelPropertySpecification $property): ImperativeCode
    {
        $foreign = $property->getForeignKeySpecification();
        $relationshipModel = $this->getModelSupervisor()->parseModelNameFromTable($foreign->getForeignKeyTable());

        if (!$this->getModelSupervisor()->modelExists($relationshipModel->getName())) {
            return Block::throw(
                Block::invokeStaticMethod(
                    new Importable($this->incompleteWebTestExceptionName()),
                    'provideMissingForeignKey',
                    [$property->getName()]
                )
            );
        }

        $getForeignKeyBlock = Reference::objectProperty(
            Block::invokeStaticMethod(
                new Importable($relationshipModel->getFullyQualifiedName()),
                'factory'
            )->chain('create'),
            $foreign->getForeignKeyField()
        );

        return Block::assign(
            Reference::arrayFetch(
                Reference::variable('override'),
                $property->getName()
            ),
            $getForeignKeyBlock
        );
    }
}
