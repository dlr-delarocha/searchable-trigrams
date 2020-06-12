<?php

namespace Searchable\Fuzzy;

use Spatie\Searchable\Exceptions\InvalidSearchableModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\Searchable\ModelSearchAspect;


class AutocompleteSearchAspect extends ModelSearchAspect
{
    protected function addSearchConditions(Builder $query, string $term)
    {
        $attributes = $this->attributes;

        $query->select($attributes);

        foreach (Arr::wrap($attributes) as $attribute) {
            $sql = "? % ANY(STRING_TO_ARRAY({$attribute->getAttribute()}, ?))";

            $query->select(['id', "{$attribute->getAttribute()}" . ' as search']);
            $query->orWhereRaw($sql, ["{$term}", ' ']);
        }
    }

}