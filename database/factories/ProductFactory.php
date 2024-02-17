<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        fake()->addProvider(new \Mmo\Faker\PicsumProvider(fake()));

        $stock = random_int(0,50);
        return [
            //

            'nombre' => fake() -> unique() -> words(3,true),
            'descripcion' => fake() -> text(),
            'imagen' => "products/" .  fake()->picsum("public/storage/products", 400, 400, false),
            'stock' => $stock,
            'disponible' => ($stock) ? 'SI' : 'NO',
            'pvp' => fake() -> randomFloat(2,1,9999.99),
            'user_id' => User::all() -> random() -> id


        ];
    }
}
