<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\ImperativeCode\Block;

/**
 * Class GetModelDataMethodDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Tests\Web\WebTestsDeveloperManager getManager()
 */
class GetModelDataMethodDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $method = ClassMethod::name($this->getModelDataMethodName($specification->getModel()))->withArguments([
            Argument::name('override')->type('array')->value([])
        ])->return('array')->makePrivate();

        $method->setBody(
            Block::fromArray([
                $this->getManager()->getModelDataSpecialDefaultsDeveloper()->develop($specification, $developedSet),
                $this->getManager()->getModelDataPrimeDefaultsDeveloper()->develop($specification, $developedSet),
            ])
        );

        return $method;
    }
}
