<?php

namespace Shomisha\Crudly\Test\Unit\Developers\WebCrud;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Edit\EditDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Web\EditMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class EditDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        return tap(CrudlySpecificationBuilder::forModel('RentalListing'), function (CrudlySpecificationBuilder $specificationBuilder) {
            $specificationBuilder
                ->property('owner_email', ModelPropertyType::EMAIL())
                    ->isForeign('email', 'users')
                    ->isRelationship('owner')
                ->property('city_uuid', ModelPropertyType::STRING())
                    ->isForeign('uuid', 'cities')
                    ->isRelationship('city');
        });
    }

    protected function getDeveloperWithManager(?BaseDeveloperManager $manager = null): CrudMethodDeveloper
    {
        if ($manager === null) {
            $manager = new EditMethodDeveloperManager(new DeveloperConfig(), $this->app);
        }

        return new EditDeveloper($manager, $this->modelSupervisor);
    }

    protected function getDevelopedMethodWithAuthorization(): string
    {
        return implode("\n", [
            "    public function edit(RentalListing \$rentalListing)",
            "    {",
            "        \$this->authorize('update', \$rentalListing);",
            "        \$users = User::all();",
            "        \$cities = City::all();\n",

            "        return view('rental_listings.edit', ['rentalListing' => \$rentalListing, 'users' => \$users, 'cities' => \$cities]);",
            "    }",
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function edit(RentalListing \$rentalListing)",
            "    {",
            "        \$users = User::all();",
            "        \$cities = City::all();\n",

            "        return view('rental_listings.edit', ['rentalListing' => \$rentalListing, 'users' => \$users, 'cities' => \$cities]);",
            "    }",
        ]);
    }
}
