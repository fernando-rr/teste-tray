<?php

namespace App\Jobs;

use App\Repositories\VendedorRepository;
use App\Services\VendaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Dispara os jobs de criação de vendas separadamente
 * @package App\Jobs
 */
class CriarVendasTesteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $idVendedor;
    protected $totalVendas;

    /**
     * Create a new job instance.
     */
    public function __construct($idVendedor, $totalVendas)
    {
        $this->idVendedor  = $idVendedor;
        $this->totalVendas = $totalVendas;
    }

    /**
     * Execute the job.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handle(VendaService $vendaService, VendedorRepository $vendedorRepository): void
    {
        // Busca os dados do vendedor
        $vendedor = $vendedorRepository->findOrFail($this->idVendedor);

        // Quantidade de registros que vai inserir por vez
        $qtdRegistrosInserir = 1000;

        while($this->totalVendas > 0)
        {
            // Quantidade de registros que vai inserir na página atual
            $totalInserir = ($this->totalVendas < $qtdRegistrosInserir ? $this->totalVendas : $qtdRegistrosInserir);

            // Registros que serão inseridos em massa
            $dadosRegistros = [];

            for ($i = 0; $i < $totalInserir; $i++)
            {
                $dadosRegistros[] = \App\Models\Venda::factory()->make([
                    'id_vendedor' => $vendedor->id,
                    'comissao'    => $vendedor->comissao,
                ])->toArray();
            }

            $vendaService->criarVendasEmMassa($vendedor->id, $dadosRegistros);

            // Reduz o total de vendas para inserir
            $this->totalVendas -= $totalInserir;
        }
    }
}
