@extends('layouts.app')

@section('content')
<div class="space-y-8 max-w-4xl">
    <div>
        <p class="text-sm text-slate-400">Perfil</p>
        <h1 class="text-3xl font-semibold tracking-tight">Os teus dados</h1>
        <p class="text-slate-300">Edita o teu perfil e revê os teus favoritos.</p>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4 rounded-2xl border border-slate-800 bg-slate-900/60 p-6 shadow-lg">
        @csrf
        @method('PUT')
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <label class="text-sm text-slate-300" for="name">Nome</label>
                <input id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
            </div>
            <div class="space-y-2">
                <label class="text-sm text-slate-300" for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
            </div>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <label class="text-sm text-slate-300" for="password">Nova password (opcional)</label>
                <input id="password" name="password" type="password" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
            </div>
            <div class="space-y-2">
                <label class="text-sm text-slate-300" for="password_confirmation">Confirmar password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded-full bg-indigo-500 px-5 py-2 font-semibold text-slate-50 transition hover:bg-indigo-400">Guardar</button>
            <a href="{{ route('dashboard') }}" class="rounded-full border border-slate-700 px-5 py-2 text-slate-300 hover:border-indigo-400 hover:text-indigo-200">Cancelar</a>
        </div>
    </form>

    <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6 shadow-lg">
        <div class="flex items-start justify-between gap-3 flex-col sm:flex-row">
            <div>
                <h2 class="text-lg font-semibold">Favoritos recentes</h2>
                <p class="text-sm text-slate-400">Os últimos jogos que guardaste.</p>
            </div>
            <a href="{{ route('favorites.index') }}" class="text-sm text-indigo-300 hover:text-indigo-200">Ver todos</a>
        </div>
        <div class="mt-4 grid gap-4 md:grid-cols-2">
            @forelse($favorites as $favorite)
                @php $product = $favorite->product; $bestOffer = $product->offers->sortBy('price')->first(); @endphp
                <article class="rounded-xl border border-slate-800 bg-slate-950/60 p-4 flex gap-3">
                    @if($product->image_url)
                        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-lg border border-slate-800 bg-slate-950">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                        </div>
                    @endif
                    <div class="flex-1 space-y-1">
                        <a href="{{ route('products.show', $product) }}" class="font-semibold hover:text-indigo-300">{{ $product->name }}</a>
                        <p class="text-xs text-slate-400">{{ $product->brand ?? 'Marca desconhecida' }}</p>
                        <p class="text-sm text-emerald-300">{{ $bestOffer ? '€' . number_format($bestOffer->price, 2, ',', '.') : '—' }}</p>
                    </div>
                </article>
            @empty
                <p class="text-sm text-slate-400">Ainda não tens favoritos.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
