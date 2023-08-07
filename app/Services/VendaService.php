<?php

namespace App\Services;

use App\DTOs\Vendas\RelatorioDiario;
use App\DTOs\Vendas\VendasRelatorioDiarioDTO;
use App\Repositories\BaseRepository;
use App\Repositories\VendaRepository;
use App\Rules\CriarVendasMassaRule;
use App\Specifications\BetweenSpecification;
use Illuminate\Support\Facades\Validator;

/**
 * Regras de negócio da venda
 * @package App\Services
 */
class VendaService extends BaseRestService
{
    public function __construct(VendaRepository $repository)
    {
        parent::__construct($repository);
    }

    public static function getCreateRules(): array {
        return [
            'id_vendedor' => 'required|numeric|exists:vendedores,id',
            'valor'       => 'required|numeric|gt:0',
        ];
    }

    public static function getUpdateRules(): array {
        return [];
    }

    /**
     * Adiciona vendas em massa e efetua a validação
     *
     * @param $idVendedor
     * @param array $dadosVendas
     * @return bool
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function criarVendasEmMassa($idVendedor, array $dadosVendas)
    {
        Validator::validate(['dadosVendas' => $dadosVendas], ['dadosVendas' => new CriarVendasMassaRule()]);

        return $this->repository->createWithoutEvents($dadosVendas);
    }

    /**
     * Retorna o relatório de vendas do dia atual
     * @return VendasRelatorioDiarioDTO
     */
    public function getRelatorioDiarioVendas()
    {
        $specifications = [
            new BetweenSpecification('created_at', [now()->startOfDay(), now()]),
        ];

        // Busca as vendas de hoje
        $vendas = $this->get($specifications);

        return new VendasRelatorioDiarioDTO($vendas);
    }
}
