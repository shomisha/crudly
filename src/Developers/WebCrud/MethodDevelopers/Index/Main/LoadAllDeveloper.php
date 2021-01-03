<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Index\Main;

use Illuminate\Support\Str;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodBodyDeveloper;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\References\Variable;
use Shomisha\Stubless\Utilities\Importable;

class LoadAllDeveloper extends MethodBodyDeveloper
{
    protected function getMethodFromSet(CrudlySet $developedSet): CrudMethod
    {
        return $developedSet->getWebCrudController()->getMethods()['index'];
    }

    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    protected function performDevelopment(Specification $specification, CrudMethod $method)
    {
        // TODO: add note to docs that main and response developers assume some naming conventions which can be accessed by inheriting the MethodBodyDeveloper
        $variableName = $this->guessPluralModelVariableName($specification->getModel()->getName());
        $fullModelName = $specification->getModel()->getFullyQualifiedName();

        $method->withMainBlock(
            Block::assign(
                Variable::name($variableName),
                Block::invokeStaticMethod(
                    'all',
                    Reference::classReference(new Importable($fullModelName))
                )
            )
        );
    }
}
