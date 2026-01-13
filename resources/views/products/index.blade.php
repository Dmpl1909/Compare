@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <section class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-4xl font-bold tracking-tight bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">Catálogo de Jogos</h1>
                <p class="text-slate-400 mt-2">Explore milhares de jogos e encontre as melhores ofertas</p>
            </div>
        </div>
        
        <!-- Search Bar Modernizado -->
        <form method="GET" action="{{ route('products.catalog') }}" class="relative group">
            <label class="sr-only" for="q">Pesquisa</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="h-5 w-5 text-slate-500 group-focus-within:text-purple-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input id="q" name="q" value="{{ $term }}" placeholder="Pesquisar por título, editora ou SKU..." 
                    class="w-full rounded-xl border border-slate-800/50 bg-slate-900/50 backdrop-blur-sm py-4 pl-12 pr-32 text-slate-50 placeholder-slate-500 transition focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-500/20" />
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-lg bg-gradient-to-r from-purple-600 to-blue-600 px-6 py-2.5 font-semibold text-white transition hover:from-purple-500 hover:to-blue-500 shadow-lg shadow-purple-500/30">
                    Procurar
                </button>
            </div>
        </form>
    </section>

    <!-- Products Grid -->
    <section class="space-y-6">
        @forelse ($products as $product)
            @php
                $bestOffer = $product->offers->sortBy('price')->first();
                $isFavorite = in_array($product->id, $favoriteIds);
                $alert = $alertsByProduct[$product->id] ?? null;
            @endphp
            <article class="group relative overflow-hidden rounded-2xl border border-slate-800/50 bg-gradient-to-br from-slate-900/50 to-slate-900/80 backdrop-blur-sm transition hover:border-purple-500/50 hover:shadow-xl hover:shadow-purple-500/10">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-600/0 to-blue-600/0 opacity-0 transition group-hover:from-purple-600/5 group-hover:to-blue-600/5 group-hover:opacity-100"></div>
                <div class="relative p-6">
                    <div class="flex flex-col gap-6 md:flex-row md:items-start md:justify-between">
                        <!-- Product Info -->
                        <div class="flex-1 space-y-4">
                            <div class="flex gap-4">
                                @if($product->image_url)
                                    <div class="h-28 w-28 flex-shrink-0 overflow-hidden rounded-lg border border-slate-800/50 bg-slate-950">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition group-hover:scale-105" />
                                    </div>
                                @endif
                                <div class="space-y-2 flex-1">
                                    <h2 class="text-2xl font-bold group-hover:text-purple-300 transition">
                                        <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                                    </h2>
                                    <p class="text-sm text-slate-500">
                                        {{ $product->brand ?? 'Marca desconhecida' }} 
                                        @if($product->sku) 
                                            <span class="mx-2">·</span> 
                                            <span class="rounded bg-slate-800/50 px-2 py-0.5 font-mono text-xs">SKU {{ $product->sku }}</span>
                                        @endif
                                    </p>
                                    <p class="text-slate-300 line-clamp-2">{{ $product->description }}</p>
                                </div>
                            </div>
                            
                            <!-- Offers Pills -->
                            <div class="flex flex-wrap gap-2">
                                @foreach ($product->offers as $offer)
                                    <span class="group/pill inline-flex items-center gap-2 rounded-full border border-slate-700/50 bg-slate-800/30 px-3 py-1.5 text-xs transition hover:border-purple-500/50 hover:bg-slate-800/50">
                                        <span class="text-slate-400">{{ $offer->source->name }}</span>
                                        <span class="font-semibold text-emerald-400">€{{ number_format($offer->price, 2, ',', '.') }}</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price & Actions -->
                        <div class="flex flex-col items-start md:items-end gap-4 md:min-w-[240px]">
                            <!-- Best Price Card -->
                            <div class="w-full rounded-xl border border-emerald-500/30 bg-gradient-to-br from-emerald-900/20 to-green-900/20 p-4 text-right backdrop-blur-sm">
                                <p class="text-xs font-semibold uppercase tracking-wider text-emerald-400/80">Melhor Preço</p>
                                <p class="my-1 text-4xl font-extrabold bg-gradient-to-r from-emerald-400 to-green-400 bg-clip-text text-transparent">
                                    {{ $bestOffer ? '€' . number_format($bestOffer->price, 2, ',', '.') : '—' }}
                                </p>
                                @if($bestOffer)
                                    <p class="text-xs text-slate-500">disponível em {{ $bestOffer->source->name }}</p>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex w-full flex-col gap-2">
                                @auth
                                    <form action="{{ $isFavorite ? route('favorites.destroy', $product) : route('favorites.store', $product) }}" method="POST" class="w-full">
                                        @csrf
                                        @if($isFavorite)
                                            @method('DELETE')
                                        @endif
                                        <button type="submit" class="w-full rounded-lg border-2 {{ $isFavorite ? 'border-pink-500/50 bg-pink-500/10 text-pink-300' : 'border-slate-700/50 text-slate-400' }} px-4 py-2.5 text-sm font-semibold transition hover:border-pink-400 hover:bg-pink-500/20 hover:text-pink-200 flex items-center justify-center gap-2">
                                            <svg class="h-4 w-4 {{ $isFavorite ? 'fill-current' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            {{ $isFavorite ? 'Nos Favoritos' : 'Adicionar aos Favoritos' }}
                                        </button>
                                    </form>
                                    
                                    <form action="{{ $alert ? route('alerts.destroy', $product) : route('alerts.store', $product) }}" method="POST" class="w-full">
                                        @csrf
                                        @if($alert)
                                            @method('DELETE')
                                            <button type="submit" class="w-full rounded-lg border-2 border-amber-500/50 bg-amber-500/10 px-4 py-2.5 text-sm font-semibold text-amber-300 transition hover:border-amber-400 hover:bg-amber-500/20 flex items-center justify-center gap-2">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                                </svg>
                                                Remover Alerta
                                            </button>
                                        @else
                                            <div class="flex gap-2">
                                                <input type="number" step="0.01" name="target_price" placeholder="€ 29.99" 
                                                    class="flex-1 rounded-lg border border-slate-700 bg-slate-950 px-3 py-2.5 text-sm focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20" required />
                                                <button type="submit" class="rounded-lg bg-gradient-to-r from-amber-500 to-orange-500 px-4 py-2.5 text-sm font-bold text-slate-900 transition hover:from-amber-400 hover:to-orange-400 shadow-lg shadow-amber-500/30 whitespace-nowrap">
                                                    Criar Alerta
                                                </button>
                                            </div>
                                        @endif
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="w-full rounded-lg bg-gradient-to-r from-purple-600 to-blue-600 px-4 py-2.5 text-center text-sm font-bold text-white transition hover:from-purple-500 hover:to-blue-500 shadow-lg shadow-purple-500/30">
                                        Inicia Sessão para Guardar
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-slate-800/50 bg-slate-900/40 p-16 text-center">
                <div class="mx-auto mb-4 h-16 w-16 rounded-full bg-slate-800/50 flex items-center justify-center">
                    <svg class="h-8 w-8 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-slate-400 text-lg">Nenhum resultado encontrado para a sua pesquisa.</p>
                <p class="text-slate-500 text-sm mt-2">Tente usar termos diferentes ou explore o catálogo completo.</p>
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </section>
</div>
@endsection
