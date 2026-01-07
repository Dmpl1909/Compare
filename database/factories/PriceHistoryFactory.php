<?php

namespace Database\Factories;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\PriceHistory> */
class PriceHistoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'offer_id' => Offer::factory(),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'recorded_at' => now()->subDays(rand(0, 14)),
        ];
    }
}
