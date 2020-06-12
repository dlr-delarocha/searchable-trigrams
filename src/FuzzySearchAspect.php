<?php

namespace Searchable\Fuzzy;

use Spatie\Searchable\Exceptions\InvalidSearchableModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\Searchable\ModelSearchAspect;

class FuzzySearchAspect extends ModelSearchAspect
{
    protected function addSearchConditions(Builder $query, string $term)
    {
        $attributes = $this->attributes;

        foreach (Arr::wrap($attributes) as $attribute) {
            $sql = "? % ANY(STRING_TO_ARRAY({$attribute->getAttribute()}, ?))";

            $attribute->isPartial()
                ? $query->orWhereRaw($sql, ["{$term}", ' '])
                : $query->orWhere($attribute->getAttribute(), $term);
        }
    }
}