<?php

namespace Shomisha\Crudly\Test\Unit\Developers\WebCrud\Update;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Update\UpdateDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Web\UpdateMethodDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\CrudMethodTestCase;

class UpdateDeveloperTest extends CrudMethodTestCase
{
    protected function getSpecificationBuilder(): CrudlySpecificationBuilder
    {
        return tap(CrudlySpecificationBuilder::forModel('Player'), function (CrudlySpecificationBuilder $specificationBuilder) {
            $specificationBuilder
                ->property('id', ModelPropertyType::BIG_INT())->primary()
                ->property('name', ModelPropertyType::STRING())
                ->property('country_id', ModelPropertyType::BIG_INT())
                    ->isForeign('id', 'countries')
                    ->isRelationship('country')
                ->property('club_id', ModelPropertyType::BIG_INT())
                    ->isForeign('id', 'clubs')
                    ->isRelationship('club');
        });
    }

    protected function getDeveloperWithManager(?BaseDeveloperManager $manager = null): CrudMethodDeveloper
    {
        if ($manager === null) {
            $manager = new UpdateMethodDeveloperManager($this->getDeveloperConfig(), $this->app);
        }

        return new UpdateDeveloper($manager, $this->modelSupervisor);
    }

    protected function getDevelopedMethodWithAuthorization(): string
    {
        return implode("\n", [
            "    public function update(PlayerRequest \$request, Player \$player)",
            "    {",
            "        \$this->authorize('update', \$player);",
            "        \$player->name = \$request->input('name');",
            "        \$player->country_id = \$request->input('country_id');",
            "        \$player->club_id = \$request->input('club_id');",
            "        \$player->update();\n",

            "        return redirect()->route('players.index')->with('success', 'Successfully updated instance.');",
            "    }"
        ]);
    }

    protected function getDevelopedMethodWithoutAuthorization(): string
    {
        return implode("\n", [
            "    public function update(PlayerRequest \$request, Player \$player)",
            "    {",
            "        \$player->name = \$request->input('name');",
            "        \$player->country_id = \$request->input('country_id');",
            "        \$player->club_id = \$request->input('club_id');",
            "        \$player->update();\n",

            "        return redirect()->route('players.index')->with('success', 'Successfully updated instance.');",
            "    }"
        ]);
    }
}
