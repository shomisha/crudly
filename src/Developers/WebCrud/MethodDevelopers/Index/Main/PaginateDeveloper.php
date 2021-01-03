<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Index\Main;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodBodyDeveloper;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\References\Variable;
use Shomisha\Stubless\Utilities\Importable;

class PaginateDeveloper extends MethodBodyDeveloper
{
    protected function getMethodFromSet(CrudlySet $developedSet): CrudMethod
    {
        return $developedSet->getWebCrudController()->getMethods()['index'];
    }

    protected function performDevelopment(Specification $specification, CrudMethod $method)
    {
        $variableName = $this->guessPluralModelVariableName($specification->getModel()->getName());
        $fullModelName = $specification->getModel()->getFullyQualifiedName();

        $method->withMainBlock(
            Block::assign(
                Variable::name($variableName),
                Block::invokeStaticMethod(
                    Reference::classReference(new Importable($fullModelName)),
                    'paginate'
                )
            )
        );
    }
}
