<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Store\Fill;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\References\Variable;
use Shomisha\Stubless\Utilities\Importable;

class FillUsingDedicatedMethodDeveloper extends CrudDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $modelVar = Reference::variable($this->guessSingularModelVariableName($specification->getModel()->getName()));
        $requestVar = Reference::variable('request');

        $this->addFillMethodToController($specification, $developedSet);

        return Block::invokeMethod(
            Reference::this(),
            'fillFromRequest',
            [$modelVar, $requestVar]
        );
    }

    private function addFillMethodToController(CrudlySpecification $specification, CrudlySet $developedSet): void
    {
        $developedSet->getWebCrudController()->addMethod($this->prepareFillMethod($specification));
    }

    private function prepareFillMethod(CrudlySpecification $specification): ClassMethod
    {
        $model = $specification->getModel();

        $modelArg = Argument::name($this->guessSingularModelVariableName($model->getName()))
                            ->type(new Importable($model->getFullyQualifiedName()));
        $requestArg = Argument::name('request')->type(new Importable($this->guessFormRequestClass($model)));

        $fillMethod = ClassMethod::name('fillFromRequest')
                                 ->arguments([$modelArg, $requestArg])
                                 ->return(new Importable($model->getFullyQualifiedName()));

        $modelVar = Variable::fromArgument($modelArg);
        $requestVar = Variable::fromArgument($requestArg);

        $properties = $specification->getProperties()->except($specification->getPrimaryKey()->getName());
        $body = Block::fromArray($properties->map(function (ModelPropertySpecification $property) use ($modelVar, $requestVar) {
            return Block::assign(
                Reference::objectProperty(
                    $modelVar,
                    $property->getName()
                ),
                Block::invokeMethod(
                    $requestVar,
                    'input',
                    [$property->getName()]
                )
            );
        })->toArray())->addCode(
            Block::return($modelVar)
        );

        $fillMethod->body($body);
        return $fillMethod;
    }
}
