<?php

namespace Shomisha\Crudly\Data;

use Illuminate\Support\Fluent;
use Shomisha\Stubless\Contracts\Code;

/**
 * Class ValidationRules
 *
 * @method self required()
 * @method self nullable()
 * @method self array()
 * @method self boolean()
 * @method self date()
 * @method self dateFormat(string $format)
 * @method self integer()
 * @method self numeric()
 * @method self email()
 * @method self string()
 * @method self max(int $max)
 * @method self min(int $min)
 */
class ValidationRules extends Fluent
{
    private array $otherRules = [];

    public static function new(): self
    {
        return new self();
    }

    public function withRules(array $rules): self
    {
        $this->otherRules = array_merge($this->otherRules, $rules);

        return $this;
    }

    public function getRules(): array
    {
        return collect($this->getAttributes())->concat($this->otherRules)->map(function ($rule, $name) {
            return $this->normalizeRule($name, $rule);
        })->values()->toArray();
    }

    private function normalizeRule(string $name, $rule)
    {
        if ($rule instanceof Code) {
            return $rule;
        }

        if ($rule === true || empty($rule)) {
            return $name;
        }

        return "{$name}:{$rule}";
    }
}
