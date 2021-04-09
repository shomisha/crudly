<?php

namespace Shomisha\Crudly\Test\Unit\Developers\WebCrud\Store;

use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\StoreDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Web\StoreMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class StoreDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        return tap(CrudlySpecificationBuilder::forModel('Car'), function (CrudlySpecificationBuilder $specificationBuilder) {
            $specificationBuilder
                ->property('model', ModelPropertyType::STRING())
                ->property('year', ModelPropertyType::INT())
                ->property('manufacturer_uuid', ModelPropertyType::STRING())
                ->property('horse_power', ModelPropertyType::INT())
                ->property('cubic_capacity', ModelPropertyType::INT());
        });
    }

    protected function getDeveloperWithManager(?BaseDeveloperManager $manager = null): CrudMethodDeveloper
    {
        if ($manager === null) {
            $manager = new StoreMethodDeveloperManager($this->getDeveloperConfig(), $this->app);
        }

        return new StoreDeveloper($manager, $this->modelSupervisor);
    }

    protected function getDevelopedMethodWithAuthorization(): string
    {
        return implode("\n", [
            "    public function store(CarRequest \$request)",
            "    {",
            "        \$this->authorize('create', Car::class);",
            "        \$car = new Car();",
            "        \$car->model = \$request->input('model');",
            "        \$car->year = \$request->input('year');",
            "        \$car->manufacturer_uuid = \$request->input('manufacturer_uuid');",
            "        \$car->horse_power = \$request->input('horse_power');",
            "        \$car->cubic_capacity = \$request->input('cubic_capacity');",
            "        \$car->save();\n",

            "        return redirect()->route('cars.index')->with('success', 'Successfully created new instance.');",
            "    }"
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function store(CarRequest \$request)",
            "    {",
            "        \$car = new Car();",
            "        \$car->model = \$request->input('model');",
            "        \$car->year = \$request->input('year');",
            "        \$car->manufacturer_uuid = \$request->input('manufacturer_uuid');",
            "        \$car->horse_power = \$request->input('horse_power');",
            "        \$car->cubic_capacity = \$request->input('cubic_capacity');",
            "        \$car->save();\n",

            "        return redirect()->route('cars.index')->with('success', 'Successfully created new instance.');",
            "    }"
        ]);
    }
}
