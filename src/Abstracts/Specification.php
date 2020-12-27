<?php

namespace Shomisha\Crudly\Abstracts;

use Illuminate\Support\Arr;
use Shomisha\Crudly\Contracts\Specification as SpecificationContract;

class Specification implements SpecificationContract
{
    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    protected function set(string $key, $value): void
    {
        Arr::set($this->data, $key, $value);
    }

    protected function extract(string $key)
    {
        return Arr::get($this->data, $key);
    }
}
