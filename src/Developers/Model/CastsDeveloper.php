<?php

namespace Shomisha\Crudly\Developers\Model;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\ModelPropertyGuessers\CastGuesser;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\DeclarativeCode\ClassProperty;

class CastsDeveloper implements Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassProperty
    {
        return ClassProperty::name('casts')->value($this->guessCasts($specification));
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
