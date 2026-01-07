<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $term = (string) $request->input('q', '');

        $products = Product::with(['offers' => function ($query) {
            $query->with('source')->orderBy('price');
        }])
            ->when($term, function ($query) use ($term) {
                $query->where(function ($builder) use ($term) {
                    $builder->where('name', 'like', "%{$term}%")
                        ->orWhere('brand', 'like', "%{$term}%")
                        ->orWhere('sku', 'like', "%{$term}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $favoriteIds = auth()->check()
            ? auth()->user()->favorites()->pluck('product_id')->all()
            : [];

        $alertsByProduct = auth()->check()
            ? auth()->user()->priceAlerts()->get()->keyBy('product_id')
            : collect();

        return view('products.index', [
            'products' => $products,
            'favoriteIds' => $favoriteIds,
            'alertsByProduct' => $alertsByProduct,
            'term' => $term,
        ]);
    }

    public function show(Product $product): View
    {
        $product->load([
            'offers.source',
            'offers.priceHistories' => function ($query) {
                $query->orderByDesc('recorded_at')->limit(10);
            },
        ]);

        $bestOffer = $product->offers->sortBy('price')->first();

        $isFavorite = auth()->check()
            ? auth()->user()->favorites()->where('product_id', $product->id)->exists()
            : false;

        $alert = auth()->check()
            ? auth()->user()->priceAlerts()->where('product_id', $product->id)->first()
            : null;

        return view('products.show', [
            'product' => $product,
            'bestOffer' => $bestOffer,
            'isFavorite' => $isFavorite,
            'alert' => $alert,
        ]);
    }
}
