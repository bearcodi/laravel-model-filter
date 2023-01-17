<?php

namespace Lacodix\LaravelModelFilter\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

class BooleanFilter extends Filter
{
    public function __construct(?array $options = null)
    {
        $this->options = $options ?? $this->options;
    }

    public function apply(Builder $query, array|string $values): Builder
    {
        $values = Arr::wrap($values);

        foreach ($this->options() as $key) {
            $query->when(
                ! is_null($values[$key] ?? null),
                fn ($query) => $query->where($key, $this->getValueForFilter($values[$key]))
            );
        }

        return $query;
    }

    protected function getValueForFilter(string $value): bool
    {
        return (bool) $value;
    }
}
