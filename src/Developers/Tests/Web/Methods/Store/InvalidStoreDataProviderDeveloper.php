<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Store;

use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager as DeveloperManagerAbstract;
use Shomisha\Crudly\ModelPropertyGuessers\InvalidValidationDataProvidersGuesser;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\ReturnBlock;

class InvalidStoreDataProviderDeveloper extends TestsDeveloper
{
    private InvalidValidationDataProvidersGuesser $dataProviderGuesser;

    public function __construct(DeveloperManagerAbstract $manager, ModelSupervisor $modelSupervisor, InvalidValidationDataProvidersGuesser $dataProviderGuesser)
    {
        parent::__construct($manager, $modelSupervisor);

        $this->dataProviderGuesser = $dataProviderGuesser;
    }

    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassMethod
    {
        $method = ClassMethod::name(
            $this->guessStoreDataProviderName($specification->getModel())
        );

        return $method->body(
            $this->getDataProviderBody($specification)
        );
    }

    protected function getDataProviderBody(CrudlySpecification $specification): ReturnBlock
    {
        $providers = [];

        foreach ($specification->getProperties() as $property) {
            if ($property->getName() == $specification->getPrimaryKey()->getName()) {
                continue;
            }

            $providers = array_merge($providers, $this->getProvidersForProperty($property));
        }

        return Block::return($providers);
    }

    protected function getProvidersForProperty(ModelPropertySpecification $property): array
    {
        return $this->dataProviderGuesser->guess($property) ?? [];
    }
}
