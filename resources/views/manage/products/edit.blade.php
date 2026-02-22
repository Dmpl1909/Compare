@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-3xl">
    <div>
        <p class="text-sm text-slate-400">Gestão de Jogos</p>
        <h1 class="text-3xl font-semibold tracking-tight">Editar jogo</h1>
        <p class="text-slate-300">Atualiza as informações do jogo {{ $product->name }}.</p>
    </div>

    @if($errors->any())
        <div class="rounded-lg border border-red-700 bg-red-950/60 px-4 py-3 text-sm text-red-100">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('manage.products.update', $product) }}" method="POST" class="space-y-4 rounded-2xl border border-slate-800 bg-slate-900/60 p-6 shadow-lg">
        @csrf
        @method('PUT')
        
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2 md:col-span-2">
                <label class="text-sm text-slate-300" for="name">Título do jogo *</label>
                <input id="name" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
            </div>
            
            <div class="space-y-2">
                <label class="text-sm text-slate-300" for="brand">Editora</label>
                <input id="brand" name="brand" value="{{ old('brand', $product->brand) }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
            </div>
            
            <div class="space-y-2">
                <label class="text-sm text-slate-300" for="sku">SKU</label>
                <input id="sku" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
            </div>
            
            <div class="space-y-2 md:col-span-2">
                <label class="text-sm text-slate-300" for="description">Descrição</label>
                <textarea id="description" name="description" rows="4" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none">{{ old('description', $product->description) }}</textarea>
            </div>
            
            <div class="space-y-2 md:col-span-2">
                <label class="text-sm text-slate-300" for="image_url">Imagem (URL)</label>
                <input id="image_url" name="image_url" value="{{ old('image_url', $product->image_url) }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
                @if($product->image_url)
                    <div class="mt-2">
                        <img src="{{ $product->image_url }}" alt="Preview" class="h-32 w-32 object-cover rounded-lg border border-slate-700">
                    </div>
                @endif
            </div>
        </div>

        <!-- Ofertas existentes -->
        @if($product->offers->isNotEmpty())
            <div class="rounded-xl border border-slate-800 bg-slate-950/40 p-4 space-y-3">
                <h2 class="text-lg font-semibold">Ofertas existentes</h2>
                <div class="space-y-2">
                    @foreach($product->offers as $offer)
                        <div class="flex items-center justify-between rounded-lg border border-slate-700 bg-slate-900 px-4 py-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium">{{ $offer->source->name }}</span>
                                    <span class="text-emerald-400">€{{ number_format($offer->price, 2, ',', '.') }}</span>
                                </div>
                                @if($offer->url)
                                    <a href="{{ $offer->url }}" target="_blank" class="text-xs text-slate-400 hover:text-indigo-400 truncate block max-w-md">{{ $offer->url }}</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-xs text-slate-500">Para gerir ofertas, use a interface de scraping ou adicione manualmente pela base de dados.</p>
            </div>
        @endif

        <div class="flex gap-3">
            <button type="submit" class="rounded-full bg-indigo-500 px-5 py-2 font-semibold text-slate-50 transition hover:bg-indigo-400">Atualizar</button>
            <a href="{{ route('manage.products.index') }}" class="rounded-full border border-slate-700 px-5 py-2 text-slate-300 hover:border-indigo-400 hover:text-indigo-200">Cancelar</a>
        </div>
    </form>
</div>
@endsection
