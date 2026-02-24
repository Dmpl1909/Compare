@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-3xl">
    <div>
        <p class="text-sm text-slate-400">Gestão de Jogos</p>
        <h1 class="text-3xl font-semibold tracking-tight">Adicionar jogo</h1>
        <p class="text-slate-300">Cria um jogo e, opcionalmente, já regista uma oferta inicial.</p>
    </div>

    <form action="{{ route('manage.products.store') }}" method="POST" class="space-y-4 rounded-2xl border border-slate-800 bg-slate-900/60 p-6 shadow-lg">
        @csrf
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2 md:col-span-2">
                <label class="text-sm text-slate-300" for="name">Título do jogo *</label>
                <input id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
            </div>
            <div class="space-y-2">
                <label class="text-sm text-slate-300" for="brand">Editora</label>
                <input id="brand" name="brand" value="{{ old('brand') }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
            </div>
            <div class="space-y-2">
                <label class="text-sm text-slate-300" for="sku">SKU</label>
                <input id="sku" name="sku" value="{{ old('sku') }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
            </div>
            <div class="space-y-2 md:col-span-2">
                <label class="text-sm text-slate-300" for="description">Descrição</label>
                <textarea id="description" name="description" rows="4" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none">{{ old('description') }}</textarea>
            </div>
            <div class="space-y-2 md:col-span-2">
                <label class="text-sm text-slate-300" for="image_url">Imagem (URL)</label>
                <input id="image_url" name="image_url" value="{{ old('image_url') }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
            </div>
        </div>

        <div class="rounded-xl border border-slate-800 bg-slate-950/40 p-4 space-y-3">
            <h2 class="text-lg font-semibold">Oferta inicial (opcional)</h2>
            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-2">
                    <label class="text-sm text-slate-300" for="source_name">Fonte (texto)</label>
                    <input id="source_name" name="source_name" value="{{ old('source_name') }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" placeholder="Ex: Game Galaxy" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm text-slate-300" for="price">Preço (€)</label>
                    <input id="price" name="price" step="0.01" type="number" value="{{ old('price') }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm text-slate-300" for="availability">Disponibilidade</label>
                    <input id="availability" name="availability" value="{{ old('availability') }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm text-slate-300" for="offer_url">Link para a fonte</label>
                    <input id="offer_url" name="offer_url" value="{{ old('offer_url') }}" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
                </div>
            </div>
            <p class="text-xs text-slate-500">Se não preencheres, o jogo é criado sem oferta inicial. Se preencheres preço, indica também fonte e link.</p>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="rounded-full bg-indigo-500 px-5 py-2 font-semibold text-slate-50 transition hover:bg-indigo-400">Guardar</button>
            <a href="{{ route('manage.products.index') }}" class="rounded-full border border-slate-700 px-5 py-2 text-slate-300 hover:border-indigo-400 hover:text-indigo-200">Cancelar</a>
        </div>
    </form>
</div>
@endsection
