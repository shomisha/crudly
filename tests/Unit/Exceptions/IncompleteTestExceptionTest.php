<?php

namespace Shomisha\Crudly\Test\Unit\Exceptions;

use Shomisha\Crudly\Exceptions\IncompleteTestException;
use Shomisha\Crudly\Test\TestCase;

class IncompleteTestExceptionTest extends TestCase
{
    /** @test */
    public function missing_user_authorization_exception_can_be_instantiated()
    {
        $exception = IncompleteTestException::provideUserAuthorization();


        $this->assertInstanceOf(\Throwable::class, $exception);
        $this->assertEquals("Missing user authorization for CRUD tests.", $exception->getMessage());
    }

    /** @test */
    public function missing_user_deauthorization_exception_can_be_instantiated()
    {
        $exception = IncompleteTestException::provideUserDeauthorization();


        $this->assertInstanceOf(\Throwable::class, $exception);
        $this->assertEquals("Missing user deauthorization for CRUD tests.", $exception->getMessage());
    }

    /** @test */
    public function missing_route_getter_exception_can_be_instantiated()
    {
        $exception = IncompleteTestException::missingRouteGetter('update');


        $this->assertInstanceOf(\Throwable::class, $exception);
        $this->assertEquals("Missing 'update' route getter for CRUD tests.", $exception->getMessage());
    }

    /** @test */
    public function missing_foreign_key_exception_can_be_instantiated()
    {
        $exception = IncompleteTestException::provideMissingForeignKey('company_id');


        $this->assertInstanceOf(\Throwable::class, $exception);
        $this->assertEquals("Missing 'company_id' default value for CRUD tests.", $exception->getMessage());
    }
}
