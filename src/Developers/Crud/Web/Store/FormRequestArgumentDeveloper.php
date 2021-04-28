<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Store;

use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager as DeveloperManagerAbstract;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\Utilities\Importable;

class FormRequestArgumentDeveloper extends CrudDeveloper
{
    private string $domain;

    public function __construct(DeveloperManagerAbstract $manager, ModelSupervisor $modelSupervisor, string $domain)
    {
        parent::__construct($manager, $modelSupervisor);

        $this->domain = $domain;
    }

    public function develop(Specification $specification, CrudlySet $developedSet): Argument
    {
        $formRequestClass = $this->guessFormRequestClass(
            $specification->getModel(),
            $this->domain
        );

        return Argument::name('request')->type(
            new Importable($formRequestClass)
        );
    }
}
