<?php

namespace Database\Seeders;

use App\Jobs\CriarVendasTesteJob;
use App\Models\Vendedor;
use Illuminate\Database\Seeder;

class VendasSeeder extends Seeder
{
    /**
    * Run the database seeds.
    */
    public function run(): void
    {
        // Busca todos os vendedores
        $vendedores = Vendedor::all();

        /**
         * Cria de 1 À 10 vendas por vendedor, exceto o primeiro que irá possuir 150.000
         *
         * @var Vendedor $vendedor
         */
        foreach ($vendedores as $i => $vendedor)
        {
            // Cria as vendas do primeiro vendedor pela queue
            if(!$i)
            {
                // Job para adicionar as vendas na fila para não travar o seed
                CriarVendasTesteJob::dispatch($vendedor->id, 150000);
                continue;
            }

            // Define a quantidade de vendas
            //$totalVendas = rand(1, 10);

            // Adiciona as vendas
            \App\Models\Venda::factory()->count(10)->create([
                'id_vendedor' => $vendedor->id,
                'comissao'    => $vendedor->comissao,
            ]);
        }
    }
}