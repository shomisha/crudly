<?php

namespace Shomisha\Crudly\Templates\Crud\Web;

use Illuminate\Http\Request;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Variable;
use Shomisha\Stubless\Utilities\Importable;

class WebCrudMethod extends CrudMethod
{
    public function withRequestArgument(): Variable
    {
        $this->addArgument(
            $requestArgument = Argument::name('request')->type(new Importable(Request::class))
        );

        return Variable::fromArgument($requestArgument);
    }

    public function withFormRequestArgument(string $formRequestClass): Variable
    {
        $this->addArgument(
            $requestArgument = Argument::name('request')->type(new Importable($formRequestClass))
        );

        return Variable::fromArgument($requestArgument);
    }

    public function withModelArgument(string $name, string $modelClass): Variable
    {
        $this->addArgument(
            $modelArgument = Argument::name($name)->type(new Importable($modelClass))
        );

        return Variable::fromArgument($modelArgument);
    }

    public function returnRouteRedirect(string $route, array $with = []): self
    {
        $redirectResponse = Block::invokeFunction('redirect')->chain('route', [$route]);

        if (!empty($with)) {
            $redirectResponse->chain('with', $with);
        }

        return $this->withResponseBlock($redirectResponse);
    }

    public function returnView(string $viewName, array $data = []): self
    {
        $viewResponse = Block::invokeFunction('view', array_filter([
            $viewName,
            $data,
        ]));

        return $this->withResponseBlock($viewResponse);
    }
}
