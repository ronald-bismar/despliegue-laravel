<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'CategoriaID' => Categoria::factory(),
            'Nombre'=> $this->faker->name,
            'PrecioUnitario' => $this->faker->randomFloat(2,10, 100),
            'stock'=> $this->faker->randomNumber(2,10, 100),
            'Descripcion' => $this->faker->sentence,

        ];
    }
}
