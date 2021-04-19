<?php

namespace Shomisha\Crudly\Developers\Crud;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Exceptions\IncompletePolicyException;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Utilities\Importable;

class PolicyDeveloper extends Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassTemplate
    {
        $policy = ClassTemplate::name($this->guessPolicyName($specification))->setNamespace(
            'App\Policies'
        );

        $developedSet->setPolicy($policy);

        $policy->withMethods($this->getMethods($specification));

        return $policy;
    }

    protected function guessPolicyName(CrudlySpecification $specification): string
    {
        return $specification->getModel()->getName() . "Policy";
    }

    /** @return \Shomisha\Stubless\DeclarativeCode\ClassMethod[] */
    protected function getMethods(CrudlySpecification $specification): array
    {
        $methods = [
            $this->viewAnyMethod($specification),
            $this->viewMethod($specification),
            $this->createMethod($specification),
            $this->updateMethod($specification),
            $this->deleteMethod($specification),
        ];

        if ($specification->hasSoftDeletion()) {
            $methods = array_merge($methods, [
                $this->forceDeleteMethod($specification),
                $this->restoreMethod($specification),
            ]);
        }

        return $methods;
    }

    protected function viewAnyMethod(CrudlySpecification $specification): ClassMethod
    {
        return ClassMethod::name('viewAny')->arguments([
            $this->userArgument($specification)
        ])->body(Block::throw(
            Block::invokeStaticMethod(
                new Importable(IncompletePolicyException::class),
                'missingAction',
                ['viewAny']
            )
        ));
    }

    protected function viewMethod(CrudlySpecification $specification): ClassMethod
    {
        return ClassMethod::name('view')->arguments([
            $this->userArgument($specification),
            $this->modelArgument($specification),
        ])->body(Block::throw(
            Block::invokeStaticMethod(
                new Importable(IncompletePolicyException::class),
                'missingAction',
                ['view']
            )
        ));
    }

    protected function createMethod(CrudlySpecification $specification): ClassMethod
    {
        return ClassMethod::name('create')->arguments([
            $this->userArgument($specification),
        ])->body(Block::throw(
            Block::invokeStaticMethod(
                new Importable(IncompletePolicyException::class),
                'missingAction',
                ['create']
            )
        ));
    }

    protected function updateMethod(CrudlySpecification $specification): ClassMethod
    {
        return ClassMethod::name('update')->arguments([
            $this->userArgument($specification),
            $this->modelArgument($specification),
        ])->body(Block::throw(
            Block::invokeStaticMethod(
                new Importable(IncompletePolicyException::class),
                'missingAction',
                ['update']
            )
        ));
    }

    protected function deleteMethod(CrudlySpecification $specification): ClassMethod
    {
        return ClassMethod::name('delete')->arguments([
            $this->userArgument($specification),
            $this->modelArgument($specification),
        ])->body(Block::throw(
            Block::invokeStaticMethod(
                new Importable(IncompletePolicyException::class),
                'missingAction',
                ['delete']
            )
        ));
    }

    protected function forceDeleteMethod(CrudlySpecification $specification): ClassMethod
    {
        return ClassMethod::name('forceDelete')->arguments([
            $this->userArgument($specification),
            $this->modelArgument($specification),
        ])->body(Block::throw(
            Block::invokeStaticMethod(
                new Importable(IncompletePolicyException::class),
                'missingAction',
                ['forceDelete']
            )
        ));
    }

    protected function restoreMethod(CrudlySpecification $specification): ClassMethod
    {
        return ClassMethod::name('restore')->arguments([
            $this->userArgument($specification),
            $this->modelArgument($specification),
        ])->body(Block::throw(
            Block::invokeStaticMethod(
                new Importable(IncompletePolicyException::class),
                'missingAction',
                ['restore']
            )
        ));
    }

    protected function userArgument(CrudlySpecification $specification): Argument
    {
        return Argument::name('user')->type(new Importable('App\Models\User'));
    }

    protected function modelArgument(CrudlySpecification $specification): Argument
    {
        return Argument::name($this->guessSingularModelVariableName($specification->getModel()))->type(new Importable($specification->getModel()->getFullyQualifiedName()));
    }
}
