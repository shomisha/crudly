<?php

namespace Shomisha\Crudly\Specifications;

use Illuminate\Support\Collection;
use Shomisha\Crudly\Abstracts\Specification;
use Shomisha\Crudly\Data\ModelName;

class CrudlySpecification extends Specification
{
    const KEY_MODEL = 'model';

    const KEY_PROPERTIES = 'properties';

    const KEY_HAS_WEB = 'has_web';

    const KEY_HAS_API = 'has_api';

    const KEY_PRIMARY = 'primary';

    const KEY_ACTUAL_PRIMARY = 'actual_primary_key';

    public function __construct(ModelName $model, array $data = [])
    {
        parent::__construct($data);

        $this->set(self::KEY_MODEL, $model);

        $this->parseProperties();
        $this->parsePrimary();
    }

    public function getModel(): ModelName
    {
        return $this->extract(self::KEY_MODEL);
    }

    /** @return \Illuminate\Support\Collection|\Shomisha\Crudly\Specifications\ModelPropertySpecification[] */
    public function getProperties(): Collection
    {
        return $this->extract(self::KEY_PROPERTIES);
    }

    public function getPrimaryKey(): ModelPropertySpecification
    {
        return $this->extract(self::KEY_PRIMARY);
    }

    public function hasWeb(): bool
    {
        return $this->extract(self::KEY_HAS_WEB);
    }

    public function hasApi(): bool
    {
        return $this->extract(self::KEY_HAS_API);
    }

    private function parseProperties(): void
    {
        $properties = collect($this->extract(self::KEY_PROPERTIES))
            ->mapWithKeys(function (array $propertyData) {
                $propertySpecification = new ModelPropertySpecification($propertyData);

                return [
                    $propertySpecification->getName() => $propertySpecification,
                ];
            });

        $this->set(self::KEY_PROPERTIES, $properties);
    }

    private function parsePrimary(): void
    {
        if ($actualPrimaryProperty = $this->extract(self::KEY_ACTUAL_PRIMARY)) {
            $primaryKey = $this->getProperties()->first(function (ModelPropertySpecification $property) use ($actualPrimaryProperty) {
                return $property->getName() === $actualPrimaryProperty;
            });
        } else {
            $primaryKey = $this->getProperties()->first(function (ModelPropertySpecification $property) {
                return $property->isPrimaryKey();
            });
        }

        $this->set(self::KEY_PRIMARY, $primaryKey);
    }
}
