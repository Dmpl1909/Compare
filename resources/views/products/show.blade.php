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
                    <button type="submit" class="rounded-full border border-gray-300 px-4 py-2 text-sm transition hover:border-indigo-500 hover:text-indigo-700">
                        {{ $isFavorite ? 'Remover favorito' : 'Guardar favorito' }}
                    </button>
                </form>
                <form action="{{ $alert ? route('alerts.destroy', $product) : route('alerts.store', $product) }}" method="POST" class="flex gap-2">
                    @csrf
                    @if($alert)
                        @method('DELETE')
                        <button type="submit" class="rounded-full border border-amber-500/80 px-4 py-2 text-sm text-amber-600 transition hover:border-amber-400">Remover alerta ({{ '€' . number_format($alert->target_price, 2, ',', '.') }})</button>
                    @else
                        <input type="number" step="0.01" name="target_price" placeholder="€ alvo" class="w-32 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none" />
                        <button type="submit" class="rounded-full bg-amber-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-amber-600">Criar alerta</button>
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
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-lg">
                <h2 class="text-lg font-semibold">Ofertas</h2>
                <div class="mt-4 divide-y divide-gray-200">
                    @foreach ($product->offers as $offer)
                        <div class="flex flex-col gap-3 py-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-semibold">{{ $offer->source->name }}</p>
                                <p class="text-sm text-gray-500">{{ $offer->availability ?? 'Disponibilidade desconhecida' }}</p>
                                <p class="text-xs text-gray-400">Atualizado {{ $offer->collected_at?->diffForHumans() ?? 'há pouco' }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="text-2xl font-semibold text-emerald-600">€{{ number_format($offer->price, 2, ',', '.') }}</span>
                                <a href="{{ $offer->url }}" target="_blank" class="rounded-full border border-indigo-500 px-4 py-2 text-sm text-indigo-600 transition hover:bg-indigo-600 hover:text-white">Ver na loja</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-lg">
                <p class="text-sm text-gray-500">Melhor preço</p>
                <p class="text-3xl font-semibold text-emerald-600">{{ $bestOffer ? '€' . number_format($bestOffer->price, 2, ',', '.') : '—' }}</p>
                @if($bestOffer)
                    <p class="text-xs text-gray-400">{{ $bestOffer->source->name }}</p>
                @endif
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-lg">
                <h3 class="text-lg font-semibold">Histórico recente</h3>
                <ul class="mt-3 space-y-2 text-sm text-gray-600">
                    @php
                        $histories = $product->offers->flatMap->priceHistories->sortByDesc('recorded_at')->take(8);
                    @endphp
                    @forelse ($histories as $history)
                        <li class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 px-3 py-2">
                            <span>{{ $history->recorded_at?->format('d/m H:i') }}</span>
                            <span class="font-semibold text-emerald-600">€{{ number_format($history->price, 2, ',', '.') }}</span>
                        </li>
                    @empty
                        <li class="text-gray-400">Sem registos de histórico.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
