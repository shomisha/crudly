<?php

namespace Shomisha\Crudly\Stubless;

use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\Enums\ClassAccess;

class TestMethod extends ClassMethod
{
    private ?string $dataProvider = null;

    public function __construct(string $name, array $arguments = [], ClassAccess $access = null, string $returnType = null)
    {
        parent::__construct($name, $arguments, $access, $returnType);

        $this->withDocBlock("@test");
    }

    public function withDataProvider(?string $dataProvider): self
    {
        $docBlock = "@test";

        if ($dataProvider !== null) {
            $docBlock .= "\n@dataProvider {$dataProvider}";
        }

        return $this->withDocBlock($docBlock);
    }
}
