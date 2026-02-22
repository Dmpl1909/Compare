@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-start justify-between gap-3 flex-col sm:flex-row">
        <div>
            <p class="text-sm text-slate-400">Gestão de Jogos</p>
            <h1 class="text-3xl font-semibold tracking-tight">Catálogo</h1>
            <p class="text-slate-300">Cria e acompanha jogos disponíveis para comparação.</p>
        </div>
        <a href="{{ route('manage.products.create') }}" class="rounded-full bg-indigo-500 px-4 py-2 text-sm font-semibold text-slate-50 transition hover:bg-indigo-400">Adicionar jogo</a>
    </div>

    @if(session('status'))
        <div class="rounded-lg border border-emerald-700 bg-emerald-950/60 px-4 py-3 text-sm text-emerald-100">{{ session('status') }}</div>
    @endif

    <div class="grid gap-4 lg:grid-cols-3 md:grid-cols-2">
        @forelse($products as $product)
            <div class="rounded-xl border border-slate-800 bg-slate-900/60 p-4 shadow">
                    @if($product->image_url)
                        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-lg border border-slate-800 bg-slate-950">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                        </div>
                    @endif
                    <h2 class="font-semibold text-lg">{{ $product->name }}</h2>
                    <p class="text-sm text-slate-400">{{ $product->brand ?? 'Sem editora' }} @if($product->sku) · SKU {{ $product->sku }} @endif</p>
                    <p class="mt-2 text-sm text-slate-300 line-clamp-3">{{ $product->description }}</p>
                    <p class="mt-2 text-xs text-slate-500">Ofertas: {{ $product->offers()->count() }}</p>
                    <div class="mt-3 flex gap-2 text-xs text-slate-300">
                        <a href="{{ route('products.show', $product) }}" class="rounded-full border border-indigo-400 px-3 py-1 hover:bg-indigo-500 hover:text-slate-900">Ver público</a>
                        <a href="{{ route('manage.products.edit', $product) }}" class="rounded-full border border-cyan-400 px-3 py-1 hover:bg-cyan-500 hover:text-slate-900">Editar</a>
                        <form action="{{ route('manage.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Eliminar este jogo?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-full border border-rose-400 px-3 py-1 text-rose-200 hover:bg-rose-500 hover:text-slate-900">Eliminar</button>
                        </form>
                    </div>
            </div>
        @empty
            <div class="col-span-full rounded-xl border border-slate-800 bg-slate-900/60 p-6 text-center text-slate-400">Ainda sem jogos criados.</div>
        @endforelse
    </div>

    <div>
        {{ $products->links() }}
    </div>
</div>
@endsection
