<?php

namespace Shomisha\Crudly\Test\Unit\Exceptions;

use Shomisha\Crudly\Exceptions\IncompletePolicyException;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;

class IncompletePolicyExceptionTest extends DeveloperTestCase
{
    /** @test */
    public function exception_can_be_instantiated_using_named_constructor()
    {
        $exception = IncompletePolicyException::missingAction('create', 'User');


        $this->assertInstanceOf(\Throwable::class, $exception);

        $this->assertEquals(
            "Missing policy action for model 'User': 'create'", $exception->getMessage()
        );
    }
}
