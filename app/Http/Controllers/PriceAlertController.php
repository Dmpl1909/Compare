<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PriceAlertController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'target_price' => ['required', 'numeric', 'min:0'],
        ]);

        $user = auth()->user();

        $user->priceAlerts()->updateOrCreate(
            ['product_id' => $product->id],
            [
                'target_price' => $validated['target_price'],
                'active' => true,
                'last_triggered_at' => null,
            ]
        );

        return back()->with('status', 'Alerta de preço guardado.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $user = auth()->user();

        $user->priceAlerts()->where('product_id', $product->id)->delete();

        return back()->with('status', 'Alerta removido.');
    }
}
