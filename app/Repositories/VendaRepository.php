<?php

namespace App\Repositories;

use App\Models\Venda;

class VendaRepository extends BaseRepository
{
    public function __construct(Venda $model)
    {
        parent::__construct($model);
    }
}
