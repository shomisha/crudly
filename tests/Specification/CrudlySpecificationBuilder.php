<?php

namespace Shomisha\Crudly\Test\Specification;

use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class CrudlySpecificationBuilder
{
    private string $modelName;

    private ?string $namespace = null;

    private string $rootNamespace = 'App\Models';

    /** @var \Shomisha\Crudly\Test\Specification\PropertySpecificationBuilder[] */
    private array $properties = [];

    private bool $softDeletion = false;
    private ?string $softDeletionColumnName = null;

    private bool $timestamps = true;

    private bool $webCrud = false;
    private bool $webAuthorization = false;
    private bool $webTests = false;

    private bool $apiCrud = false;
    private bool $apiAuthorization = false;
    private bool $apiTests = false;

    public function __construct(string $modelName)
    {
        $this->modelName = $modelName;
    }

    public static function forModel(string $modelName): self
    {
        return new self($modelName);
    }

    public function namespace(?string $namespace = null): self
    {
        $this->namespace = $namespace;

        return $this;
    }

    public function rootNamespace(string $rootNamespace): self
    {
        $this->rootNamespace = $rootNamespace;

        return $this;
    }

    public function property(string $propertyName, ModelPropertyType $propertyType): PropertySpecificationBuilder
    {
        $this->properties[$propertyName] = new PropertySpecificationBuilder($propertyName, $propertyType);

        return $this->properties[$propertyName];
    }

    public function softDeletes(bool $softDeletes = true): self
    {
        $this->softDeletion = $softDeletes;

        return $this;
    }

    public function softDeletionColumn(?string $column): self
    {
        $this->softDeletionColumnName = $column;

        return $this;
    }

    public function timestamps(bool $timestamps = true): self
    {
        $this->timestamps = $timestamps;

        return $this;
    }

    public function webCrud(bool $webCrud = true): self
    {
        $this->webCrud = $webCrud;

        return $this;
    }

    public function webAuthorization(bool $webAuthorization = true): self
    {
        $this->webAuthorization = $webAuthorization;

        return $this;
    }

    public function webTests(bool $webTests = true): self
    {
        $this->webTests = $webTests;

        return $this;
    }

    public function apiCrud(bool $apiCrud = true): self
    {
        $this->apiCrud = $apiCrud;

        return $this;
    }

    public function apiAuthorization(bool $apiAuthorization = true): self
    {
        $this->apiAuthorization = $apiAuthorization;

        return $this;
    }

    public function apiTests(bool $apiTests = true): self
    {
        $this->apiTests = $apiTests;

        return $this;
    }

    public function build(): CrudlySpecification
    {
        $model = new ModelName($this->modelName, $this->rootNamespace, $this->namespace);

        return new CrudlySpecification($model, [
            'properties' => $this->buildProperties(),
            'has_soft_deletion' => $this->softDeletion,
            'soft_delete_column_name' => $this->softDeletionColumnName,
            'has_timestamps' => $this->timestamps,
            'has_web' => $this->webCrud,
            'has_web_authorization' => $this->webAuthorization,
            'has_web_tests' => $this->webTests,
            'has_api' => $this->apiCrud,
            'has_api_authorization' => $this->apiAuthorization,
            'has_api_tests' => $this->apiTests,
        ]);
    }

    /** @return array[] */
    private function buildProperties(): array
    {
        return array_map(function (PropertySpecificationBuilder $propertyBuilder) {
            return $propertyBuilder->buildArray();
        }, $this->properties);
    }
}
