@extends('layouts.app')

@section('content')
<div class="space-y-8 max-w-4xl">
    <div>
        <p class="text-sm text-slate-400">Perfil</p>
        <h1 class="text-3xl font-semibold tracking-tight text-slate-50">Os teus dados</h1>
        <p class="text-slate-300">Edita o teu perfil e revê os teus favoritos.</p>
    </div>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 rounded-2xl border border-slate-800 bg-slate-900/60 p-6 shadow-lg">
        @csrf
        @method('PUT')
        
        <div class="space-y-2">
            <label class="text-sm font-medium text-slate-300">Foto de perfil</label>
            <div class="flex items-center gap-4">
                @if($user->avatar)
                    <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="h-14 w-14 rounded-full object-cover border border-slate-700">
                @else
                    <div id="avatar-preview" class="h-14 w-14 rounded-full bg-emerald-700 flex items-center justify-center text-slate-50 text-lg font-bold border border-slate-700">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex-1">
                    <input 
                        id="avatar" 
                        name="avatar" 
                        type="file" 
                        accept="image/*"
                        class="block w-full text-sm text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-900 file:text-emerald-200 hover:file:bg-emerald-800"
                        onchange="previewAvatar(event)"
                    />
                    <p class="text-xs text-slate-400 mt-1">JPG, PNG ou GIF (máx. 2MB)</p>
                </div>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300" for="name">Nome</label>
                <input id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-emerald-500 focus:outline-none" />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300" for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-emerald-500 focus:outline-none" />
            </div>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300" for="password">Nova password (opcional)</label>
                <input id="password" name="password" type="password" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-emerald-500 focus:outline-none" />
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-300" for="password_confirmation">Confirmar password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-emerald-500 focus:outline-none" />
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="rounded-full bg-emerald-600 px-5 py-2 font-semibold text-slate-50 transition hover:bg-emerald-500">Guardar</button>
            <a href="{{ route('home') }}" class="rounded-full border border-slate-700 px-5 py-2 text-slate-300 hover:border-emerald-500 hover:text-emerald-300">Cancelar</a>
        </div>
    </form>

    <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6 shadow-lg">
        <div class="flex items-start justify-between gap-3 flex-col sm:flex-row">
            <div>
                <h2 class="text-lg font-semibold">Favoritos recentes</h2>
                <p class="text-sm text-slate-400">Os últimos jogos que guardaste.</p>
            </div>
            <a href="{{ route('favorites.index') }}" class="text-sm text-emerald-300 hover:text-emerald-200 font-medium">Ver todos</a>
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
                        <a href="{{ route('products.show', $product) }}" class="font-semibold hover:text-emerald-300">{{ $product->name }}</a>
                        <p class="text-xs text-slate-400">{{ $product->brand ?? 'Marca desconhecida' }}</p>
                        <p class="text-sm font-semibold text-emerald-600">{{ $bestOffer ? '€' . number_format($bestOffer->price, 2, ',', '.') : '—' }}</p>
                    </div>
                </article>
            @empty
                <p class="text-sm text-slate-400">Ainda não tens favoritos.</p>
            @endforelse
        </div>
    </div>
</div>

<script>
function previewAvatar(event) {
    const preview = document.getElementById('avatar-preview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'h-14 w-14 rounded-full object-cover border border-slate-700';
            preview.replaceWith(img);
            img.id = 'avatar-preview';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
