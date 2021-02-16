<?php

namespace Shomisha\Crudly\Exceptions;

class IncompletePolicyException extends \Exception
{
    public static function missingAction(string $action, string $model): self
    {
        return new self("Missing policy action for model '{$model}': '{$action}'");
    }
}
