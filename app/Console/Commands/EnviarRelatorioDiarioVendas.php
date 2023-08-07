<?php

namespace App\Console\Commands;

use App\Mail\RelatorioVendasDiariasMail;
use App\Services\VendaService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnviarRelatorioDiarioVendas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:enviar-relatorio-diario-vendas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia o relatório de vendas diário';

    /**
     * Execute the console command.
     */
    public function handle(VendaService $vendaService)
    {
        $relatorioDiario = $vendaService->getRelatorioDiarioVendas();

        Mail::to(env('MAIL_RELATORIO_VENDAS_DIARIAS'))->send(new RelatorioVendasDiariasMail($relatorioDiario));
    }
}
