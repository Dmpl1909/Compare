<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Product;
use App\Models\Source;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ManageProductController extends Controller
{
    public function index(): View
    {
        $products = Product::latest()->paginate(12);

        return view('manage.products.index', [
            'products' => $products,
        ]);
    }

    public function create(): View
    {
        return view('manage.products.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url', 'max:500'],
            'source_name' => ['nullable', 'string', 'max:255', 'required_with:price,offer_url'],
            'price' => ['nullable', 'numeric', 'min:0', 'required_with:source_name,offer_url'],
            'availability' => ['nullable', 'string', 'max:255'],
            'offer_url' => ['nullable', 'url', 'max:2048', 'required_with:price,source_name'],
        ], [
            'source_name.required_with' => 'Indica o nome da loja quando adicionas preço ou link.',
            'price.required_with' => 'O preço é obrigatório quando preenches loja ou link.',
            'offer_url.required_with' => 'O link da oferta é obrigatório quando preenches loja ou preço.',
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'brand' => $validated['brand'] ?? null,
            'sku' => $validated['sku'] ?? null,
            'description' => $validated['description'] ?? null,
            'image_url' => $validated['image_url'] ?? null,
        ]);

        if (!empty($validated['price']) && !empty($validated['source_name']) && !empty($validated['offer_url'])) {
            $source = Source::firstOrCreate(['name' => $validated['source_name']], [
                'base_url' => null,
                'logo_url' => null,
            ]);

            Offer::create([
                'product_id' => $product->id,
                'source_id' => $source->id,
                'price' => $validated['price'],
                'availability' => $validated['availability'] ?? null,
                'url' => $validated['offer_url'],
                'collected_at' => now(),
            ]);
        }

        return redirect()->route('manage.products.index')->with('status', 'Jogo criado com sucesso.');
    }

    public function edit(Product $product): View
    {
        $product->load('offers.source');
        return view('manage.products.edit', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url', 'max:500'],
        ]);

        $product->update([
            'name' => $validated['name'],
            'brand' => $validated['brand'] ?? null,
            'sku' => $validated['sku'] ?? null,
            'description' => $validated['description'] ?? null,
            'image_url' => $validated['image_url'] ?? null,
        ]);

        return redirect()->route('manage.products.index')->with('status', 'Jogo atualizado com sucesso.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('manage.products.index')->with('status', 'Jogo eliminado.');
    }
}
