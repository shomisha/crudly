<?php

namespace Shomisha\Crudly\Data;

use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class CrudlySet
{
    private ClassTemplate $migration;

    private ClassTemplate $model;

    private ClassTemplate $factory;

    private ?ClassTemplate $webCrudController = null;

    private ?ClassTemplate $webCrudFormRequest = null;

    private ?ClassTemplate $webTests = null;

    private ?ClassTemplate $apiCrudFormRequest = null;

    private ?ClassTemplate $apiCrudApiResource = null;

    private ?ClassTemplate $apiCrudController = null;

    private ?ClassTemplate $apiTests = null;

    private ?ClassTemplate $policy = null;

    public function getMigration(): ClassTemplate
    {
        return $this->migration;
    }

    public function setMigration(ClassTemplate $migration): self
    {
        $this->migration = $migration;

        return $this;
    }

    public function getModel(): ClassTemplate
    {
        return $this->model;
    }

    public function setModel(ClassTemplate $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getFactory(): ClassTemplate
    {
        return $this->factory;
    }

    public function setFactory(ClassTemplate $factory): self
    {
        $this->factory = $factory;

        return $this;
    }

    public function getWebCrudController(): ?ClassTemplate
    {
        return $this->webCrudController ?? null;
    }

    public function setWebCrudController(ClassTemplate $webCrudController): self
    {
        $this->webCrudController = $webCrudController;

        return $this;
    }

    public function getWebCrudFormRequest(): ?ClassTemplate
    {
        return $this->webCrudFormRequest;
    }

    public function setWebCrudFormRequest(?ClassTemplate $webCrudFormRequest): self
    {
        $this->webCrudFormRequest = $webCrudFormRequest;

        return $this;
    }

    public function getWebTests(): ?ClassTemplate
    {
        return $this->webTests;
    }

    public function setWebTests(ClassTemplate $webTests): self
    {
        $this->webTests = $webTests;

        return $this;
    }

    public function getApiCrudFormRequest(): ?ClassTemplate
    {
        return $this->apiCrudFormRequest;
    }

    public function setApiCrudFormRequest(?ClassTemplate $apiCrudFormRequest): self
    {
        $this->apiCrudFormRequest = $apiCrudFormRequest;

        return $this;
    }

    public function getApiCrudApiResource(): ?ClassTemplate
    {
        return $this->apiCrudApiResource;
    }

    public function setApiCrudApiResource(ClassTemplate $apiCrudApiResource): self
    {
        $this->apiCrudApiResource = $apiCrudApiResource;

        return $this;
    }

    public function getApiCrudController(): ?ClassTemplate
    {
        return $this->apiCrudController;
    }

    public function setApiCrudController(ClassTemplate $apiCrudController): self
    {
        $this->apiCrudController = $apiCrudController;

        return $this;
    }

    public function getApiTests(): ?ClassTemplate
    {
        return $this->apiTests;
    }

    public function setApiTests(ClassTemplate $apiTests): self
    {
        $this->apiTests = $apiTests;

        return $this;
    }

    public function getPolicy(): ?ClassTemplate
    {
        return $this->policy;
    }

    public function setPolicy(ClassTemplate $policy): self
    {
        $this->policy = $policy;

        return $this;
    }
}
