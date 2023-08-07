<?php

namespace App\Repositories;

use App\Models\Vendedor;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Regras de manipulação de dados do vendedor
 * @package App\Repositories
 */
class VendedorRepository extends BaseRepository
{
    public function __construct(Vendedor $model)
    {
        parent::__construct($model);
    }
}
