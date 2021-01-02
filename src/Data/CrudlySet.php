<?php

namespace Shomisha\Crudly\Data;

use Shomisha\Stubless\Contracts\Code;

class CrudlySet
{
    private Code $migration;

    private Code $model;

    private Code $webCrudController;

    private ?Code $webCrudFormRequest = null;

    public function getMigration(): Code
    {
        return $this->migration;
    }

    public function setMigration(Code $migration): self
    {
        $this->migration = $migration;

        return $this;
    }

    public function getModel(): Code
    {
        return $this->model;
    }

    public function setModel(Code $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getWebCrudController(): Code
    {
        return $this->webCrudController;
    }

    public function setWebCrudController(Code $webCrudController): self
    {
        $this->webCrudController = $webCrudController;

        return $this;
    }

    public function getWebCrudFormRequest(): ?Code
    {
        return $this->webCrudFormRequest;
    }

    public function setWebCrudFormRequest(?Code $webCrudFormRequest): self
    {
        $this->webCrudFormRequest = $webCrudFormRequest;

        return $this;
    }
}
