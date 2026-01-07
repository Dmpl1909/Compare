<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\Offer> */
class OfferFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'source_id' => Source::factory(),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'availability' => $this->faker->randomElement(['Disponível', 'Pouco stock', 'Indisponível']),
            'url' => $this->faker->url(),
            'collected_at' => now()->subMinutes(rand(5, 180)),
        ];
    }
}
