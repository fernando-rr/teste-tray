<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venda>
 */
class VendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_vendedor' => NULL,
            'comissao'    => NULL,
            'valor'       => $this->faker->randomFloat(2, 500, 1000),
            'created_at' => $this->faker->dateTimeBetween('2000-01-01', 'now')->format('Y-m-d H:i:s'),
            'updated_at' => $this->faker->dateTimeBetween('2000-01-01', 'now')->format('Y-m-d H:i:s'),
        ];
    }
}
