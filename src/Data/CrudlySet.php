<?php

namespace Shomisha\Crudly\Data;

use Shomisha\Stubless\Contracts\Code;

class CrudlySet
{
    private Code $migration;

    private Code $model;

    private Code $factory;

    private Code $webCrudController;

    private ?Code $webCrudFormRequest = null;

    private Code $webTests;

    private ?Code $apiCrudFormRequest = null;

    private Code $apiCrudApiResource;

    private Code $apiCrudController;

    private Code $apiTests;

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

    public function getFactory(): Code
    {
        return $this->factory;
    }

    public function setFactory(Code $factory): self
    {
        $this->factory = $factory;

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

    public function getWebTests(): Code
    {
        return $this->webTests;
    }

    public function setWebTests(Code $webTests): self
    {
        $this->webTests = $webTests;

        return $this;
    }

    public function getApiCrudFormRequest(): ?Code
    {
        return $this->apiCrudFormRequest;
    }

    public function setApiCrudFormRequest(?Code $apiCrudFormRequest): self
    {
        $this->apiCrudFormRequest = $apiCrudFormRequest;

        return $this;
    }

    public function getApiCrudApiResource(): Code
    {
        return $this->apiCrudApiResource;
    }

    public function setApiCrudApiResource(Code $apiCrudApiResource): self
    {
        $this->apiCrudApiResource = $apiCrudApiResource;

        return $this;
    }

    public function getApiCrudController(): Code
    {
        return $this->apiCrudController;
    }

    public function setApiCrudController(Code $apiCrudController): self
    {
        $this->apiCrudController = $apiCrudController;

        return $this;
    }

    public function getApiTests(): Code
    {
        return $this->apiTests;
    }

    public function setApiTests(Code $apiTests): self
    {
        $this->apiTests = $apiTests;

        return $this;
    }
}
