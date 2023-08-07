<?php

namespace Tests\Feature\Email;

use App\Mail\RelatorioVendasDiariasMail;
use App\Models\Venda;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RelatorioVendasDiariasMailTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        Mail::fake();

        $vendas = Venda::factory()->count(3)->create();

        $mail = new RelatorioVendasDiariasMail($vendas);

        $rendered = $mail->render();

        foreach ($vendas as $venda)
        {
            $this->assert
        }
    }
}
