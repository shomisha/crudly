<?php

namespace Shomisha\Crudly\Developers\Crud\Web\FormRequest;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\FormRequest\FormRequestDeveloper;
use Shomisha\Stubless\Contracts\Code;

class WebFormRequestDeveloper extends FormRequestDeveloper
{
    protected function getFormRequestNamespace(): string
    {
        // TODO: make this domain-aware using specification
        return "App\Http\Requests\Web";
    }

    protected function addFormRequestToSet(Code $formRequest, CrudlySet $developedSet)
    {
        $developedSet->setWebCrudFormRequest($formRequest);
    }
}
