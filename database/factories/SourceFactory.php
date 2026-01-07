<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\Source> */
class SourceFactory extends Factory
{
    public function definition(): array
    {
        $stores = [
            ['name' => 'Game Galaxy', 'base_url' => 'https://game-galaxy.test'],
            ['name' => 'PlayZone', 'base_url' => 'https://playzone.test'],
            ['name' => 'NextLevel', 'base_url' => 'https://nextlevel.test'],
            ['name' => 'PixelShop', 'base_url' => 'https://pixelshop.test'],
        ];

        $store = $this->faker->randomElement($stores);

        return [
            'name' => $store['name'],
            'base_url' => $store['base_url'],
            'logo_url' => null,
        ];
    }
}
