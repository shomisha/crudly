<?php

namespace Shomisha\Crudly\Developers;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Managers\DeveloperManager;

class CrudlyDeveloper
{
    private DeveloperManager $manager;

    public function __construct(DeveloperManager $manager)
    {
        $this->manager = $manager;
    }

    public function develop(CrudlySpecification $specification): CrudlySet
    {
        $set = new CrudlySet();

        $this->developModel($specification, $set);

        if ($specification->hasWeb()) {
            $this->developWebCrud($specification, $set);
        }

        if ($specification->hasApi()) {
            $this->developApiCrud($specification, $set);
        }

        return $set;
    }

    private function developModel(CrudlySpecification $specification, CrudlySet $developedSet): void
    {
        $this->manager->getMigrationDeveloper()->develop($specification, $developedSet);

        $this->manager->getModelDeveloper()->develop($specification, $developedSet);

        $this->manager->getFactoryDeveloper()->develop($specification, $developedSet);
    }

    private function developWebCrud(CrudlySpecification $specification, CrudlySet $developedSet): CrudlySet
    {
        $this->manager->getWebCrudFormRequestDeveloper()->develop($specification, $developedSet);

        $this->manager->getWebCrudControllerDeveloper()->develop($specification, $developedSet);

        return $developedSet;
    }

    private function developApiCrud(CrudlySpecification $specification, CrudlySet $developedSet): CrudlySet
    {
        $this->manager->getApiCrudFormRequestDeveloper()->develop($specification, $developedSet);

        $this->manager->getApiCrudApiResourceDeveloper()->develop($specification, $developedSet);

        $this->manager->getApiCrudControllerDeveloper()->develop($specification, $developedSet);

        return $developedSet;
    }
}
