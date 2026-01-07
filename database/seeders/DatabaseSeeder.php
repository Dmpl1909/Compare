<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\Offer;
use App\Models\PriceAlert;
use App\Models\PriceHistory;
use App\Models\Product;
use App\Models\Source;
use App\Models\User;
use Database\Seeders\RolesSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with demo data for quick exploration.
     */
    public function run(): void
    {
        $this->call(RolesSeeder::class);

        $user = User::factory()->create([
            'name' => 'Utilizador Demo',
            'email' => 'demo@example.com',
            'password' => 'password',
            'role' => 'cliente',
        ]);

        $products = Product::factory(5)->create();
        $sources = Source::factory()->createMany([
            ['name' => 'Loja Azul', 'base_url' => 'https://loja-azul.test', 'logo_url' => null],
            ['name' => 'Mercado Verde', 'base_url' => 'https://mercado-verde.test', 'logo_url' => null],
            ['name' => 'Tech Express', 'base_url' => 'https://tech-express.test', 'logo_url' => null],
        ]);

        $products->each(function (Product $product) use ($sources, $user) {
            $sources->each(function (Source $source) use ($product) {
                $offer = Offer::factory()->for($product)->for($source)->create([
                    'price' => fake()->randomFloat(2, 20, 400),
                ]);

                PriceHistory::factory(4)->for($offer)->create();
            });

            Favorite::factory()->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);

            PriceAlert::factory()->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'target_price' => fake()->randomFloat(2, 15, 60),
            ]);
        });
    }
}
