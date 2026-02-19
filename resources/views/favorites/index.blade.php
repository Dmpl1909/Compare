@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-start justify-between gap-3 flex-col sm:flex-row">
        <div>
            <p class="text-sm text-gray-500">Favoritos</p>
            <h1 class="text-3xl font-semibold tracking-tight">Os teus jogos guardados</h1>
            <p class="text-gray-600">Gerir e abrir os jogos que marcaste como favoritos.</p>
        </div>
        <a href="{{ route('products.catalog') }}" class="rounded-full border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:border-indigo-500 hover:text-indigo-700">Voltar ao catálogo</a>
    </div>

    <div class="grid gap-4 lg:grid-cols-3 md:grid-cols-2">
        @forelse($favorites as $favorite)
            @php $product = $favorite->product; $bestOffer = $product->offers->sortBy('price')->first(); @endphp
            <article class="rounded-xl border border-gray-200 bg-white p-4 shadow flex gap-3">
                @if($product->image_url)
                    <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-lg border border-gray-200 bg-white">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                    </div>
                @endif
                <div class="flex-1">
                    <a href="{{ route('products.show', $product) }}" class="font-semibold hover:text-indigo-700">{{ $product->name }}</a>
                    <p class="text-xs text-gray-500">{{ $product->brand ?? 'Marca desconhecida' }}</p>
                    <p class="text-sm text-emerald-600 mt-1">{{ $bestOffer ? '€' . number_format($bestOffer->price, 2, ',', '.') : '—' }}</p>
                    <div class="mt-2 flex gap-2 text-xs text-gray-600">
                        <form action="{{ route('favorites.destroy', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-full border border-rose-400 px-3 py-1 text-rose-600 hover:bg-rose-500 hover:text-white">Remover</button>
                        </form>
                        <a href="{{ route('products.show', $product) }}" class="rounded-full border border-indigo-500 px-3 py-1 text-indigo-600 hover:bg-indigo-600 hover:text-white">Ver jogo</a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-xl border border-gray-200 bg-white p-6 text-center text-gray-500">Ainda não tens favoritos.</div>
        @endforelse
    </div>

    <div>
        {{ $favorites->links() }}
    </div>
</div>
@endsection
