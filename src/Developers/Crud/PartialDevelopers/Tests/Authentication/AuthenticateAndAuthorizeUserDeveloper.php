<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;

/** @method \Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager getManager() */
class AuthenticateAndAuthorizeUserDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Block
    {
        $block = Block::fromArray([
            $this->getManager()->getCreateAndAuthenticateUserDeveloper()->develop($specification, $developedSet)
        ]);

        if ($this->getParameter('hasAuthorization')) {
            $block->addCode(
                $this->getManager()->getAuthorizeUserDeveloper()->develop($specification, $developedSet)
            );
        }

        return $block;
    }
}
