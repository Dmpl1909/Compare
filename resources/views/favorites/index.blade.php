@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-start justify-between gap-3 flex-col sm:flex-row">
        <div>
            <p class="text-sm text-slate-500">Favoritos</p>
            <h1 class="text-3xl font-bold tracking-tight bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent">Os teus jogos guardados</h1>
            <p class="text-slate-400">Gere e abra os jogos que marcaste como favoritos.</p>
        </div>
        <a href="{{ route('products.catalog') }}" class="rounded-full border border-emerald-500/50 bg-emerald-600/10 px-6 py-2.5 text-sm text-emerald-300 transition hover:border-emerald-400 hover:bg-emerald-600/20 hover:text-emerald-200 font-medium">Voltar ao catálogo</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-3 md:grid-cols-2">
        @forelse($favorites as $favorite)
            @php $product = $favorite->product; $bestOffer = $product->offers->sortBy('price')->first(); @endphp
            <article class="group relative overflow-hidden rounded-2xl border border-slate-800/50 bg-gradient-to-br from-slate-900/50 to-slate-900/80 backdrop-blur-sm transition hover:border-emerald-500/50 hover:shadow-xl hover:shadow-emerald-500/10">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/0 to-teal-600/0 opacity-0 transition group-hover:from-emerald-600/5 group-hover:to-teal-600/5 group-hover:opacity-100"></div>
                <div class="relative p-6">
                    @if($product->image_url)
                        <div class="mb-4 overflow-hidden rounded-lg aspect-video">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition group-hover:scale-105" />
                        </div>
                    @endif
                    <h3 class="mb-2 text-lg font-bold text-white group-hover:text-emerald-300 transition">
                        <a href="{{ route('products.show', $product) }}" class="after:absolute after:inset-0">{{ $product->name }}</a>
                    </h3>
                    <p class="mb-2 text-sm text-slate-400">{{ $product->brand ?? 'Marca desconhecida' }}</p>
                    
                    <div class="flex items-center justify-between border-t border-slate-800/50 pt-4 mb-4">
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Melhor preço</p>
                            <p class="text-2xl font-bold bg-gradient-to-r from-emerald-400 to-green-400 bg-clip-text text-transparent">
                                {{ $bestOffer ? '€' . number_format($bestOffer->price, 2, ',', '.') : '—' }}
                            </p>
                            @if($bestOffer)
                                <p class="text-xs text-slate-500">em {{ $bestOffer->source->name }}</p>
                            @endif
                        </div>
                        <div class="rounded-full bg-emerald-600/20 p-3 text-emerald-400 transition group-hover:bg-emerald-600/30">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex gap-2 text-sm">
                        <form action="{{ route('favorites.destroy', $product) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full rounded-lg border-2 border-pink-500/50 bg-pink-500/10 text-pink-300 px-4 py-2.5 font-semibold transition hover:border-pink-400 hover:bg-pink-500/20 hover:text-pink-200 flex items-center justify-center gap-2">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Remover
                            </button>
                        </form>
                        <a href="{{ route('products.show', $product) }}" class="flex-1 rounded-lg bg-gradient-to-r from-emerald-600 to-teal-600 px-4 py-2.5 text-center text-sm font-bold text-white transition hover:from-emerald-500 hover:to-teal-500 shadow-lg shadow-emerald-500/30 flex items-center justify-center gap-2">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Ver jogo
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full rounded-2xl border border-slate-800/50 bg-slate-900/40 p-16 text-center">
                <div class="mx-auto mb-4 h-16 w-16 rounded-full bg-slate-800/50 flex items-center justify-center">
                    <svg class="h-8 w-8 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-300 mb-2">Ainda não tens favoritos</h3>
                <p class="text-slate-500 mb-4">Adiciona jogos aos teus favoritos para os encontrares facilmente aqui.</p>
                <a href="{{ route('products.catalog') }}" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-3 text-sm font-bold text-white transition hover:from-emerald-500 hover:to-teal-500 shadow-lg shadow-emerald-500/30">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Explorar catálogo
                </a>
            </div>
        @endforelse
    </div>

    <div>
        {{ $favorites->links() }}
    </div>
</div>
@endsection
