@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <section class="space-y-4">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-semibold tracking-tight">Catálogo de Jogos</h1>
                <p class="text-sm text-gray-500">Jogos adicionados pelos gestores - compare preços em várias lojas.</p>
            </div>
        </div>
        <form method="GET" action="{{ route('products.catalog') }}" class="flex flex-col gap-3 sm:flex-row">
            <label class="sr-only" for="q">Pesquisa</label>
            <input id="q" name="q" value="{{ $term }}" placeholder="Pesquisar por título, editora ou SKU" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 focus:border-indigo-500 focus:outline-none" />
            <button type="submit" class="rounded-lg bg-indigo-600 px-6 py-3 font-semibold text-white transition hover:bg-indigo-700">Procurar</button>
        </form>
    </section>

    <section class="grid gap-6">
        @forelse ($products as $product)
            @php
                $bestOffer = $product->offers->sortBy('price')->first();
                $isFavorite = in_array($product->id, $favoriteIds);
                $alert = $alertsByProduct[$product->id] ?? null;
            @endphp
            <article class="rounded-2xl border border-gray-200 bg-white p-6 shadow-lg">
                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div class="space-y-2">
                        <h2 class="text-xl font-semibold">
                            <a href="{{ route('products.show', $product) }}" class="hover:text-indigo-700">{{ $product->name }}</a>
                        </h2>
                        <p class="text-sm text-gray-500">{{ $product->brand ?? 'Marca desconhecida' }} @if($product->sku) · SKU {{ $product->sku }} @endif</p>
                        <p class="text-sm text-gray-600">{{ $product->description }}</p>
                        <div class="flex flex-wrap gap-2 text-xs text-gray-500">
                            @foreach ($product->offers as $offer)
                                <span class="rounded-full border border-gray-300 px-3 py-1">{{ $offer->source->name }} · €{{ number_format($offer->price, 2, ',', '.') }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-3 md:min-w-[220px]">
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Melhor preço</p>
                            <p class="text-3xl font-semibold text-emerald-600">{{ $bestOffer ? '€' . number_format($bestOffer->price, 2, ',', '.') : '—' }}</p>
                            @if($bestOffer)
                                <p class="text-xs text-gray-400">{{ $bestOffer->source->name }}</p>
                            @endif
                        </div>
                        <div class="flex flex-wrap justify-end gap-2">
                            @auth
                                <form action="{{ $isFavorite ? route('favorites.destroy', $product) : route('favorites.store', $product) }}" method="POST">
                                    @csrf
                                    @if($isFavorite)
                                        @method('DELETE')
                                    @endif
                                    <button type="submit" class="rounded-full border border-gray-300 px-3 py-1 text-sm transition hover:border-indigo-500 hover:text-indigo-700">
                                                <div class="flex gap-4">
                                                    @if($product->image_url)
                                                        <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-lg border border-slate-800 bg-slate-950">
                                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                                                        </div>
                                                    @endif
                                                    <div class="space-y-2">
                                    </button>
                                </form>
                                <form action="{{ $alert ? route('alerts.destroy', $product) : route('alerts.store', $product) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    @if($alert)
                                        @method('DELETE')
                                        <button type="submit" class="rounded-full border border-amber-500/80 px-3 py-1 text-sm text-amber-600 transition hover:border-amber-400">Remover alerta</button>
                                    @else
                                        <input type="number" step="0.01" name="target_price" placeholder="€ alvo" class="w-28 rounded-lg border border-gray-300 bg-white px-3 py-1 text-sm focus:border-indigo-500 focus:outline-none" />
                                        <button type="submit" class="rounded-full bg-amber-500 px-3 py-1 text-sm font-semibold text-white transition hover:bg-amber-600">Criar alerta</button>
                                    @endif
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="rounded-full bg-indigo-600 px-3 py-1 text-sm font-semibold text-white transition hover:bg-indigo-700">Inicia sessão para guardar</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-gray-200 bg-white p-6 text-center text-gray-500">Sem resultados para já.</div>
        @endforelse

        <div>
            {{ $products->links() }}
        </div>
    </section>
</div>
@endsection
