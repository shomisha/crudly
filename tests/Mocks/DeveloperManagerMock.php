<?php

namespace Shomisha\Crudly\Test\Mocks;

use PHPUnit\Framework\Assert;
use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\NullClassDeveloper;
use Shomisha\Crudly\Developers\NullDeveloper;
use Shomisha\Crudly\Developers\NullMethodDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

class DeveloperManagerMock extends BaseDeveloperManager
{
    private array $classDeveloperMethods = [];
    private array $requestedClassDevelopers = [];

    private array $classMethodDeveloperMethods = [];
    private array $requestedClassMethodDevelopers = [];

    private array $imperativeCodeDeveloperMethods = [];
    private array $requestedCodeDevelopers = [];

    private array $unexpectedRequests = [];

    public function __construct()
    {
    }

    public function __call($method, $arguments)
    {
        if (in_array($method, $this->classDeveloperMethods)) {
            $this->requestedClassDevelopers[] = $method;

            return new NullClassDeveloper();
        }

        if (in_array($method, $this->classMethodDeveloperMethods)) {
            $this->requestedClassMethodDevelopers[] = $method;

            return new NullMethodDeveloper();
        }

        if (in_array($method, $this->imperativeCodeDeveloperMethods)) {
            $this->requestedCodeDevelopers[] = $method;

            return new NullDeveloper();
        }

        return new NullDeveloper();
    }

    public function assertClassDeveloperRequested(string $developerGetterMethod): void
    {
        Assert::assertThat(
            $this->requestedClassDevelopers,
            Assert::containsIdentical($developerGetterMethod),
            "Developer getter '{$developerGetterMethod}' was not invoked."
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

    public function assertCodeDeveloperRequested(string $developerGetterMethod): void
    {
        Assert::assertThat(
            $this->requestedCodeDevelopers,
            Assert::containsIdentical($developerGetterMethod),
            "Developer getter '{$developerGetterMethod}' was not invoked."
        );
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

    public function imperativeCodeDevelopers(array $expectedMethods): self
    {
        $this->imperativeCodeDeveloperMethods = $expectedMethods;

        return $this;
    }
}
