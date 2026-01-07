@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-start justify-between gap-3 flex-col sm:flex-row">
        <div>
            <p class="text-sm text-slate-400">Favoritos</p>
            <h1 class="text-3xl font-semibold tracking-tight">Os teus jogos guardados</h1>
            <p class="text-slate-300">Gerir e abrir os jogos que marcaste como favoritos.</p>
        </div>
        <a href="{{ route('home') }}" class="rounded-full border border-slate-700 px-4 py-2 text-sm text-slate-200 hover:border-indigo-400 hover:text-indigo-200">Voltar ao catálogo</a>
    </div>

    <div class="grid gap-4 lg:grid-cols-3 md:grid-cols-2">
        @forelse($favorites as $favorite)
            @php $product = $favorite->product; $bestOffer = $product->offers->sortBy('price')->first(); @endphp
            <article class="rounded-xl border border-slate-800 bg-slate-900/60 p-4 shadow flex gap-3">
                @if($product->image_url)
                    <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-lg border border-slate-800 bg-slate-950">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                    </div>
                @endif
                <div class="flex-1">
                    <a href="{{ route('products.show', $product) }}" class="font-semibold hover:text-indigo-300">{{ $product->name }}</a>
                    <p class="text-xs text-slate-400">{{ $product->brand ?? 'Marca desconhecida' }}</p>
                    <p class="text-sm text-emerald-300 mt-1">{{ $bestOffer ? '€' . number_format($bestOffer->price, 2, ',', '.') : '—' }}</p>
                    <div class="mt-2 flex gap-2 text-xs text-slate-300">
                        <form action="{{ route('favorites.destroy', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-full border border-rose-400 px-3 py-1 text-rose-200 hover:bg-rose-500 hover:text-slate-900">Remover</button>
                        </form>
                        <a href="{{ route('products.show', $product) }}" class="rounded-full border border-indigo-400 px-3 py-1 text-indigo-100 hover:bg-indigo-500 hover:text-slate-900">Ver jogo</a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-xl border border-slate-800 bg-slate-900/60 p-6 text-center text-slate-400">Ainda não tens favoritos.</div>
        @endforelse
    </div>

    <div>
        {{ $favorites->links() }}
    </div>
</div>
@endsection
