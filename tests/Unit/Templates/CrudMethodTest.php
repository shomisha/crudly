<?php

namespace Shomisha\Crudly\Test\Unit\Templates;

use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class CrudMethodTest extends DeveloperTestCase
{
    /** @test */
    public function crud_method_will_be_printed_using_load_authorization_main_and_response_blocks()
    {
        /** @var \Shomisha\Crudly\Templates\Crud\CrudMethod $crudMethod */
        $crudMethod = CrudMethod::name('update')->withArguments([
            Argument::name('request'),
            Argument::name('userId')
        ]);

        $crudMethod->withResponseBlock(Block::return(
            Block::invokeFunction('redirect')->chain('route', ['users.index'])
        ));

        $crudMethod->withMainBlock(Block::assign(
            Reference::objectProperty(
                Reference::variable('user'),
                'name'
            ),
            Reference::objectProperty(
                Reference::variable('request'),
                'name'
            )
        ));

        $crudMethod->withLoadBlock(Block::assign(
            Reference::variable('user'),
            Block::invokeStaticMethod(
                'User',
                'find',
                [
                    Reference::variable('userId')
                ]
            )
        ));

        $crudMethod->withAuthorization(Block::invokeMethod(
            Reference::this(),
            'authorize',
            ['whatever']
        ));


        $printedMethod = $crudMethod->print();


        $this->assertStringContainsString(implode("\n", [
            "public function update(\$request, \$userId)",
            "{",
            "    \$user = User::find(\$userId);",
            "    \$this->authorize('whatever');",
            "    \$user->name = \$request->name;",
            "    return redirect()->route('users.index');",
            "}",
        ]), $printedMethod);
    }
}
