<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class FavoriteController extends Controller
{
    public function store(Product $product): RedirectResponse
    {
        $user = auth()->user();

        $user->favorites()->firstOrCreate([
            'product_id' => $product->id,
        ]);

        return back()->with('status', 'Adicionado aos favoritos.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $user = auth()->user();

        $user->favorites()->where('product_id', $product->id)->delete();

        return back()->with('status', 'Removido dos favoritos.');
    }
}
