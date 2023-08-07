<?php

namespace App\Specifications;

use Illuminate\Database\Eloquent\Builder;

/**
 * Filtra as vendas pelo id/e-mail
 */
class VendasIdEmailSpecification implements Specification
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function apply(Builder $query): Builder
    {
        return $query->whereHas('vendedor', function ($vendedor) {
            /** @var Builder $vendedor */
            $vendedor->where('id', (int) $this->data)
                     ->orWhere('email', 'like', "%{$this->data}%");
        });
    }
}
