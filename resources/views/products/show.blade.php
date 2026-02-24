@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
                @if($product->image_url)
                    <div class="h-28 w-28 flex-shrink-0 overflow-hidden rounded-xl border border-gray-200 bg-white">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                    </div>
                @endif
                <a href="{{ route('products.catalog') }}" class="text-sm text-indigo-600 hover:text-indigo-700">← Voltar ao catálogo</a>
                <h1 class="text-3xl font-semibold tracking-tight">{{ $product->name }}</h1>
                <p class="text-sm text-gray-500">{{ $product->brand ?? 'Marca desconhecida' }} @if($product->sku) · SKU {{ $product->sku }} @endif</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            @auth
                <form action="{{ $isFavorite ? route('favorites.destroy', $product) : route('favorites.store', $product) }}" method="POST">
                    @csrf
                    @if($isFavorite)
                        @method('DELETE')
                    @endif
                    <button type="submit" class="rounded-2xl border border-pink-500/50 bg-gradient-to-r from-pink-600 to-rose-600 px-5 py-2.5 text-sm font-medium text-white shadow-lg shadow-pink-900/30 transition hover:from-pink-500 hover:to-rose-500">
                        {{ $isFavorite ? 'Remover favorito' : 'Nos Favoritos' }}
                    </button>
                </form>
                <form action="{{ $alert ? route('alerts.destroy', $product) : route('alerts.store', $product) }}" method="POST" class="flex gap-2">
                    @csrf
                    @if($alert)
                        @method('DELETE')
                        <button type="submit" class="rounded-2xl border border-amber-200 bg-gradient-to-r from-amber-50 to-orange-50 px-5 py-2.5 text-sm font-medium text-amber-800 shadow-lg shadow-amber-900/10 transition hover:border-amber-400">Remover alerta ({{ '€' . number_format($alert->target_price, 2, ',', '.') }})</button>
                    @else
                        <input type="number" step="0.01" name="target_price" placeholder="€ 29.99" class="w-36 rounded-2xl border border-slate-600 bg-slate-800 px-4 py-2.5 text-sm text-white shadow-lg shadow-slate-900/50 placeholder:text-gray-400 focus:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-500/20" />
                        <button type="submit" class="rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-orange-900/40 transition hover:from-orange-400 hover:to-amber-400">Criar Alerta</button>
                    @endif
                </form>
            @else
                <a href="{{ route('login') }}" class="rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">Inicia sessão para guardar</a>
            @endauth
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <div class="md:col-span-2 space-y-4">
            <p class="text-gray-700">{{ $product->description }}</p>
            <div class="rounded-3xl border border-indigo-500/30 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-6 shadow-lg shadow-indigo-900/20">
                <h2 class="text-lg font-semibold text-white">Ofertas</h2>
                <div class="mt-4 divide-y divide-gray-600">
                    @foreach ($product->offers as $offer)
                        <div class="flex flex-col gap-3 py-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-semibold text-white">{{ $offer->source->name }}</p>
                                <p class="text-sm text-gray-400">{{ $offer->availability ?? 'Disponibilidade desconhecida' }}</p>
                                <p class="text-xs text-gray-500">Atualizado {{ $offer->collected_at?->diffForHumans() ?? 'há pouco' }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-2xl font-semibold text-emerald-400">€{{ number_format($offer->price, 2, ',', '.') }}</span>
                                <a href="{{ $offer->url }}" target="_blank" class="rounded-2xl border border-indigo-400 bg-indigo-600 px-4 py-2 text-sm text-white transition hover:bg-indigo-500">Ver na fonte</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-3xl border border-emerald-500/30 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-5 shadow-lg shadow-emerald-900/20">
                <p class="text-xs font-semibold uppercase tracking-wider text-emerald-400">Melhor preço</p>
                <p class="text-4xl font-bold text-emerald-400">{{ $bestOffer ? '€' . number_format($bestOffer->price, 2, ',', '.') : '—' }}</p>
                @if($bestOffer)
                    <p class="text-sm text-gray-400">disponível em {{ $bestOffer->source->name }}</p>
                @endif
            </div>

            <div class="rounded-3xl border border-violet-500/30 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-5 shadow-lg shadow-violet-900/20">
                <h3 class="text-lg font-semibold text-white">Histórico recente</h3>
                <ul class="mt-3 space-y-2 text-sm">
                    @php
                        $histories = $product->offers->flatMap->priceHistories->sortByDesc('recorded_at')->take(8);
                    @endphp
                    @forelse ($histories as $history)
                        <li class="flex items-center justify-between rounded-xl border border-slate-600 bg-slate-800 px-3 py-2 text-gray-300 shadow-sm">
                            <span>{{ $history->recorded_at?->format('d/m H:i') }}</span>
                            <span class="font-semibold text-emerald-400">€{{ number_format($history->price, 2, ',', '.') }}</span>
                        </li>
                    @empty
                        <li class="text-gray-500">Sem registos de histórico.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
