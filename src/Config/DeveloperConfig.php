<?php

namespace Shomisha\Crudly\Config;

use Shomisha\Crudly\Abstracts\Specification;

class DeveloperConfig extends Specification
{
    private ?DeveloperConfig $defaults = null;

    public function getConfiguredDevelopersGroup(string $configurationKey): array
    {
        $developerClasses = $this->extract($configurationKey);

        if (empty($developerClasses)) {
            $developerClasses = optional($this->defaults)->getConfiguredDevelopersGroup($configurationKey) ?? [];
        }

        return $developerClasses;
    }

    public function getConfiguredDeveloperClass(string $configurationKey): ?string
    {
        $class = $this->extract($configurationKey);

        if ($class === null) {
            $class = optional($this->defaults)->getConfiguredDeveloperClass($configurationKey);
        }

        return $class;
    }

    public function withDefaults(DeveloperConfig $defaults): self
    {
        $this->defaults = $defaults;

        return $this;
    }
}
