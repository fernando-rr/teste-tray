<?php

namespace App\DTOs\Vendas;

use Illuminate\Support\Collection;

/**
 * Estrutura de dados do relatório diário de vendas
 * @package App\DTOs\Vendas
 */
class VendasRelatorioDiarioDTO
{
    public $valorVendas;

    public function __construct(Collection $vendas)
    {
        $this->valorVendas = $vendas->sum('valor');
    }
}
