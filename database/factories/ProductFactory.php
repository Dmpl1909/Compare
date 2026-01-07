<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\Product> */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $titles = [
            'Eclipse Chronicles',
            'Legends of Aether',
            'Neon Drift',
            'Starfall Odyssey',
            'Chrono Vanguard',
            'Arcane Frontiers',
            'Ironclad Tactics',
            'Mystic Realms',
            'Rogue Protocol',
            'Echoes of Nexus',
        ];

        return [
            'name' => $this->faker->randomElement($titles),
            'sku' => $this->faker->ean13(),
            'brand' => $this->faker->randomElement(['Ubisoft', 'EA', 'Square Enix', 'Sony', 'Microsoft', 'Indie Studio']),
            'description' => $this->faker->sentence(14),
            'image_url' => $this->faker->imageUrl(640, 360, 'games', true),
        ];
    }
}
