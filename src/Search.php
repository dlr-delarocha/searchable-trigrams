<?php

namespace Searchable\Fuzzy;

use Illuminate\Support\Arr;
use Spatie\Searchable\Search as BaseSearch;

class Search extends BaseSearch
{
    public $method;

    public function registerSearchMethod(string $modelClass, ...$attributes) : BaseSearch
    {
        $indexes = $this->getAttributes($attributes);
        if ($this->isAutocomplete($attributes)) {
            $searchAspect = new AutocompleteSearchAspect($modelClass, $indexes);
        } else {
            $searchAspect = new FuzzySearchAspect($modelClass, $indexes);
        }

        $this->registerAspect($searchAspect);

        return $this;

    }

    protected function isAutocomplete($attributes, $default = false)
    {
        if (isset($attributes[1]) && $attributes[1] === true) {
           return true;
        }
        return $default;
    }

    public function getAttributes(array $attributes)
    {
        if (isset($attributes[0]) && is_callable($attributes[0])) {
            return $attributes[0];
        }

        if (is_array(Arr::get($attributes, 0))) {
            return $attributes[0];
        }
    }
}