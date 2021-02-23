<?php

namespace Shomisha\Crudly\Test\Mocks;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Constraint\LogicalNot;
use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\NullClassDeveloper;
use Shomisha\Crudly\Developers\NullDeveloper;
use Shomisha\Crudly\Developers\NullMethodDeveloper;
use Shomisha\Crudly\Developers\NullPropertyDeveloper;
use Shomisha\Crudly\Developers\NullValueDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

class DeveloperManagerMock extends BaseDeveloperManager
{
    private array $classDeveloperMethods = [];
    private array $requestedClassDevelopers = [];
    private ?Developer $classDeveloper = null;

    private array $classMethodDeveloperMethods = [];
    private array $requestedClassMethodDevelopers = [];
    private ?Developer $classMethodDeveloper = null;

    private array $classPropertyDeveloperMethods = [];
    private array $requestedClassPropertyDevelopers = [];
    private ?Developer $classPropertyDeveloper = null;

    private array $imperativeCodeDeveloperMethods = [];
    private array $requestedCodeDevelopers = [];
    private ?Developer $codeDeveloper;

    private array $valueDeveloperMethods = [];
    private array $requestedValueDevelopers = [];
    private ?Developer $valueDeveloper;

    private array $arraysOfDevelopers = [];
    private array $requestedArraysOfDevelopers = [];

    private array $unexpectedRequests = [];

    public function __construct()
    {
    }

    public function __call($method, $arguments)
    {
        if (in_array($method, $this->classDeveloperMethods)) {
            $this->requestedClassDevelopers[] = $method;

            return $this->classDeveloper ?? new NullClassDeveloper();
        }

        if (in_array($method, $this->classMethodDeveloperMethods)) {
            $this->requestedClassMethodDevelopers[] = $method;

            return $this->classMethodDeveloper ?? new NullMethodDeveloper();
        }

        if (in_array($method, $this->classPropertyDeveloperMethods)) {
            $this->requestedClassPropertyDevelopers[] = $method;

            return $this->classPropertyDeveloper ?? new NullPropertyDeveloper();
        }

        if (in_array($method, $this->imperativeCodeDeveloperMethods)) {
            $this->requestedCodeDevelopers[] = $method;

            return $this->codeDeveloper ?? new NullDeveloper();
        }

        if (in_array($method, $this->valueDeveloperMethods)) {
            $this->requestedValueDevelopers[] = $method;

            return $this->valueDeveloper ?? new NullValueDeveloper();
        }

        if (in_array($method, $this->arraysOfDevelopers)) {
            $this->requestedArraysOfDevelopers[] = $method;

            return [];
        }

        return new NullDeveloper();
    }

    public function classDevelopers(array $expectedMethods): self
    {
        $this->classDeveloperMethods = $expectedMethods;

        return $this;
    }

    public function methodDevelopers(array $expectedMethods): self
    {
        $this->classMethodDeveloperMethods = $expectedMethods;

        return $this;
    }

    public function propertyDevelopers(array $expectedProperties): self
    {
        $this->classPropertyDeveloperMethods = $expectedProperties;

        return $this;
    }

    public function imperativeCodeDevelopers(array $expectedMethods): self
    {
        $this->imperativeCodeDeveloperMethods = $expectedMethods;

        return $this;
    }

    public function valueDevelopers(array $expectedMethods): self
    {
        $this->valueDeveloperMethods = $expectedMethods;

        return $this;
    }

    public function arraysOfDevelopers(array $expectedMethods): self
    {
        $this->arraysOfDevelopers = $expectedMethods;

        return $this;
    }

    public function assertClassDeveloperRequested(string $developerGetterMethod): void
    {
        Assert::assertThat(
            $this->requestedClassDevelopers,
            Assert::containsIdentical($developerGetterMethod),
            "Developer getter '{$developerGetterMethod}' was not invoked."
        );
    }

    public function assertClassDeveloperNotRequested(string $developerGetterMethod): void
    {
        Assert::assertThat(
            $this->requestedClassDevelopers,
            new LogicalNot(Assert::containsIdentical($developerGetterMethod)),
            "Developer getter '{$developerGetterMethod}' was invoked."
        );
    }

    public function assertMethodDeveloperRequested(string $developerGetterMethod): void
    {
        Assert::assertThat(
            $this->requestedClassMethodDevelopers,
            Assert::containsIdentical($developerGetterMethod),
            "Developer getter '{$developerGetterMethod}' was not invoked."
        );
    }

    public function assertMethodDeveloperNotRequested(string $developerGetterMethod): void
    {
        Assert::assertThat(
            $this->requestedClassMethodDevelopers,
            new LogicalNot(Assert::containsIdentical($developerGetterMethod)),
            "Developer getter '{$developerGetterMethod}' was invoked."
        );
    }

    public function assertPropertyDeveloperRequested(string $developerGetterMethod): void
    {
        Assert::assertThat(
            $this->requestedClassPropertyDevelopers,
            Assert::containsIdentical($developerGetterMethod),
            "Developer getter '{$developerGetterMethod}' was not invoked."
        );
    }

    public function assertPropertyDeveloperNotRequested(string $developerGetterMethod): void
    {
        Assert::assertThat(
            $this->requestedClassPropertyDevelopers,
            new LogicalNot(Assert::containsIdentical($developerGetterMethod)),
            "Developer getter '{$developerGetterMethod}' was invoked."
        );
    }

    public function assertCodeDeveloperRequested(string $developerGetterMethod): void
    {
        Assert::assertThat(
            $this->requestedCodeDevelopers,
            Assert::containsIdentical($developerGetterMethod),
            "Developer getter '{$developerGetterMethod}' was not invoked."
        );
    }

    public function assertCodeDeveloperNotRequested(string $developerGetterMethod): void
    {
        Assert::assertThat(
            $this->requestedCodeDevelopers,
            new LogicalNot(Assert::containsIdentical($developerGetterMethod)),
            "Developer getter '{$developerGetterMethod}' was invoked."
        );
    }

    public function assertValueDeveloperRequested(string $developerGetterMethod): void
    {
        Assert::assertThat(
            $this->requestedValueDevelopers,
            Assert::containsIdentical($developerGetterMethod),
            "Developer getter '{$developerGetterMethod}' was not invoked."
        );
    }

    public function assertValueDeveloperNotRequested(string $developerGetterMethod): void
    {
        Assert::assertThat(
            $this->requestedValueDevelopers,
            new LogicalNot(Assert::containsIdentical($developerGetterMethod)),
            "Developer getter '{$developerGetterMethod}' was invoked."
        );
    }

    public function assertArrayOfDevelopersRequested(string $developerGetterMethod): void
    {
        Assert::assertThat(
            $this->requestedArraysOfDevelopers,
            Assert::containsIdentical($developerGetterMethod),
            "Developer getter '{$developerGetterMethod}' was not invoked."
        );
    }

    public function assertArrayOfDevelopersNotRequested(string $developerGetterMethod): void
    {
        Assert::assertThat(
            $this->requestedArraysOfDevelopers,
            new LogicalNot(Assert::containsIdentical($developerGetterMethod)),
            "Developer getter '{$developerGetterMethod}' was invoked."
        );
    }

    public function useClassDeveloper(?Developer $developer): self
    {
        $this->classDeveloper = $developer;

        return $this;
    }

    public function useMethodDeveloper(?Developer $developer): self
    {
        $this->classMethodDeveloper = $developer;

        return $this;
    }

    public function usePropertyDeveloper(?Developer $developer): self
    {
        $this->classPropertyDeveloper = $developer;

        return $this;
    }

    public function useImperativeCodeDeveloper(?Developer $developer): self
    {
        $this->codeDeveloper = $developer;

        return $this;
    }

    public function useValueDeveloper(?Developer $developer): self
    {
        $this->valueDeveloper = $developer;

        return $this;
    }
}
