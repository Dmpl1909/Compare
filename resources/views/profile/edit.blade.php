@extends('layouts.app')

@section('content')
<div class="space-y-8 max-w-4xl">
    <div>
        <p class="text-sm text-slate-400">Perfil</p>
        <h1 class="text-3xl font-semibold tracking-tight">Os teus dados</h1>
        <p class="text-slate-300">Visualiza e edita o teu perfil.</p>
    </div>

    <!-- Modo de Visualização -->
    <div id="view-mode" class="space-y-4 rounded-2xl border border-slate-800 bg-slate-900/60 p-6 shadow-lg">
        <div class="flex items-center gap-6 mb-6">
            <div class="flex-shrink-0">
                <img src="{{ $user->avatar_url }}" alt="Avatar" class="h-24 w-24 rounded-full object-cover border-2 border-slate-700">
            </div>
            <div>
                <h2 class="text-xl font-semibold text-slate-50">{{ $user->name }}</h2>
                <p class="text-sm text-slate-400">{{ $user->email }}</p>
            </div>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <label class="text-sm text-slate-400">Nome</label>
                <p class="text-lg text-slate-50">{{ $user->name }}</p>
            </div>
            <div class="space-y-2">
                <label class="text-sm text-slate-400">Email</label>
                <p class="text-lg text-slate-50">{{ $user->email }}</p>
            </div>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <label class="text-sm text-slate-400">Password</label>
                <p class="text-lg text-slate-50">••••••••</p>
            </div>
        </div>
        <div class="flex gap-3">
            <button onclick="enableEditMode()" type="button" class="rounded-full bg-indigo-500 px-5 py-2 font-semibold text-slate-50 transition hover:bg-indigo-400">Editar Perfil</button>
        </div>
    </div>

    <!-- Modo de Edição -->
    <form id="edit-mode" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="hidden space-y-4 rounded-2xl border border-slate-800 bg-slate-900/60 p-6 shadow-lg">
        @csrf
        @method('PUT')
        
        <!-- Avatar Upload -->
        <div class="flex items-center gap-6 mb-6">
            <div class="flex-shrink-0">
                <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="Avatar" class="h-24 w-24 rounded-full object-cover border-2 border-slate-700">
            </div>
            <div class="space-y-2">
                <label class="text-sm text-slate-300" for="avatar">Imagem de Perfil</label>
                <input id="avatar" name="avatar" type="file" accept="image/*" onchange="previewAvatar(event)" class="block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-500 file:text-white hover:file:bg-indigo-400 cursor-pointer" />
                <p class="text-xs text-slate-500">JPG, PNG ou GIF (max. 2MB)</p>
            </div>
        </div>

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
            <button onclick="cancelEdit(event)" type="button" class="rounded-full border border-slate-700 px-5 py-2 text-slate-300 hover:border-indigo-400 hover:text-indigo-200">Cancelar</button>
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

<script>
function enableEditMode() {
    document.getElementById('view-mode').classList.add('hidden');
    document.getElementById('edit-mode').classList.remove('hidden');
}

function cancelEdit(event) {
    event.preventDefault();
    document.getElementById('edit-mode').classList.add('hidden');
    document.getElementById('view-mode').classList.remove('hidden');
}

function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            preview.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
