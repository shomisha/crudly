<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Utilities\Importable;

class AuthenticateUserMethodDeveloper extends TestsDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): ClassMethod
    {
        $userModel = $this->guessUserClass();
        $userVar = Reference::variable('user');

        $method = ClassMethod::name('createAndAuthenticateUser')->return(new Importable($userModel->getFullyQualifiedName()));

        $createUser = Block::assign(
            $userVar,
            Block::invokeStaticMethod(
                $userModel->getName(),
                'factory'
            )->chain('create')
        );

        $authenticateUser = Block::invokeMethod(
            Reference::this(),
            'be',
            [$userVar]
        );

        $returnUser = Block::return($userVar);

        return $method->body(Block::fromArray([
            $createUser,
            $authenticateUser,
            $returnUser,
        ]));
    }
}
