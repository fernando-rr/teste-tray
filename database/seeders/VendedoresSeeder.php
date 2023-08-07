<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Adiciona os vendedores
         \App\Models\Vendedor::factory(10)->create([
             'comissao' => 8.5
         ]);
    }
}
