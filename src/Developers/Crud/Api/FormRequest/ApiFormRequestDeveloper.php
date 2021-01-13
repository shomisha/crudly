<?php

namespace Shomisha\Crudly\Developers\Crud\Api\FormRequest;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\FormRequest\FormRequestDeveloper;
use Shomisha\Stubless\Contracts\Code;

class ApiFormRequestDeveloper extends FormRequestDeveloper
{
    protected function getFormRequestNamespace(): string
    {
        // TODO: make this domain-aware using specification
        return "App\Http\Requests\Api";
    }

    protected function addFormRequestToSet(Code $formRequest, CrudlySet $developedSet)
    {
        $developedSet->setApiCrudFormRequest($formRequest);
    }
}
