<?php

namespace Shomisha\Crudly\Templates\Crud;

use Shomisha\Stubless\Abstractions\ImperativeCode;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\ImperativeCode\Block;

class CrudMethod extends ClassMethod
{
    private ?ImperativeCode $authorization = null;

    private ?ImperativeCode $loadBlock = null;

    private ImperativeCode $mainBlock;

    private ImperativeCode $responseBlock;

    private bool $initialized = false;

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->crudMethodName = $name;
    }

    public function getAuthorizationBlock(): ?ImperativeCode
    {
        return $this->authorization;
    }

    public function withAuthorization(?ImperativeCode $authorization): self
    {
        $this->authorization = $authorization;

        return $this;
    }

    public function getLoadBlock(): ?ImperativeCode
    {
        return $this->loadBlock;
    }

    public function withLoadBlock(?ImperativeCode $loadBlock): self
    {
        $this->loadBlock = $loadBlock;

        return $this;
    }

    public function getMainBlock(): ImperativeCode
    {
        return $this->mainBlock;
    }

    public function withMainBlock(ImperativeCode $mainBlock): self
    {
        $this->mainBlock = $mainBlock;

        return $this;
    }

    public function getResponseBlock(): ImperativeCode
    {
        return $this->responseBlock;
    }

    public function withResponseBlock(ImperativeCode $responseBlock): self
    {
        $this->responseBlock = $responseBlock;

        return $this;
    }

    public function getPrintableNodes(): array
    {
        $this->initialize();

        return parent::getPrintableNodes();
    }

    public function print(): string
    {
        $this->initialize();

        return parent::print();
    }

    public function getImportSubDelegates(): array
    {
        $this->initialize();

        return parent::getImportSubDelegates();
    }

    private function initialize(): void
    {
        if ($this->initialized) {
            return;
        }

        $body = [];

        if ($loadBlock = $this->getLoadBlock()) {
            $body[] = $loadBlock;
        }

        if ($authorization = $this->getAuthorizationBlock()) {
            $body[] = $authorization;
        }

        $body[] = $this->getMainBlock();
        $body[] = Block::return($this->getResponseBlock());

        $this->setBody(Block::fromArray($body));

        $this->initialized = true;
    }
}
