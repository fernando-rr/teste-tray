<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use App\Repositories\VendedorRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Regras de negócio do vendedor
 * @package App\Services
 */
class VendedorService extends BaseRestService
{
    public function __construct(VendedorRepository $repository)
    {
        parent::__construct($repository);
    }

    public static function getCreateRules(): array
    {
        return [
            'nome'     => 'required|string|min:3|max:255',
            'email'    => 'required|email|unique:vendedores,email',
            'comissao' => 'required|numeric|gt:0',
        ];
    }

    public static function getUpdateRules(): array
    {
        return [
            'nome'     => 'required|string|min:3|max:255',
            'comissao' => 'required|numeric|gt:0',
        ];
    }
}
