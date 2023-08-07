<?php

namespace App\Specifications;

use Illuminate\Database\Eloquent\Builder;

/**
 * Filtra a coluna entre os valores informados
 */
class BetweenSpecification implements Specification
{
    protected $column;
    protected $values;

    public function __construct($column, iterable $values)
    {
        $this->column = $column;
        $this->values = $values;
    }

    public function apply(Builder $query): Builder
    {
        return $query->whereBetween($this->column, $this->values);
    }
}
