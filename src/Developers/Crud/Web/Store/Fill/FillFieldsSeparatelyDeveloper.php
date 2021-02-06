<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Store\Fill;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;

/**
 * Class FillFieldsSeparatelyDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager getManager()
 */
class FillFieldsSeparatelyDeveloper extends CrudDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $properties = $specification->getProperties()->except($specification->getPrimaryKey()->getName());
        $fillFieldDeveloper = $this->getManager()->getFillFieldDeveloper();

        return Block::fromArray($properties->map(
            function (ModelPropertySpecification $property) use ($fillFieldDeveloper, $specification, $developedSet) {
                return $fillFieldDeveloper->using(['property' => $property->getName()])->develop($specification, $developedSet);
            }
        )->toArray());
    }
}
