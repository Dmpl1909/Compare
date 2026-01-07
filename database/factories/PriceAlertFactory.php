<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\PriceAlert> */
class PriceAlertFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'target_price' => $this->faker->randomFloat(2, 10, 100),
            'active' => true,
            'last_triggered_at' => null,
        ];
    }
}
