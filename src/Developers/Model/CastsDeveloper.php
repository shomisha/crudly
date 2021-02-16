<?php

namespace Shomisha\Crudly\Developers\Model;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\ModelPropertyGuessers\CastGuesser;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\DeclarativeCode\ClassProperty;

class CastsDeveloper extends Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassProperty
    {
        $casts = $this->guessCasts($specification);

        if (empty($casts)) {
            return $this->getManager()->nullPropertyDeveloper()->develop($specification, $developedSet);
        }

        return ClassProperty::name('casts')->value($casts);
    }

    protected function guessCasts(CrudlySpecification $specification): array
    {
        $castGuesser = new CastGuesser();

        return $specification->getProperties()->mapWithKeys(function (ModelPropertySpecification $property) use ($castGuesser) {
            return [
                $property->getName() => $castGuesser->guess($property),
            ];
        })->filter()->toArray();
    }
}
