<?php

namespace Shomisha\Crudly\Exceptions;

class IncompleteTestException extends \Exception
{
    public static function provideUserAuthorization(): self
    {
        return new self("Missing user authorization for CRUD tests.");
    }

    public static function provideUserDeauthorization(): self
    {
        return new self("Missing user deauthorization for CRUD tests.");
    }

    public static function missingRouteGetter(string $route): self
    {
        return new self("Missing '{$route}' route getter for CRUD tests.");
    }

    public static function provideMissingForeignKey(string $keyName): self
    {
        return new self("Missing '{$keyName}' default value for CRUD tests.");
    }
}
