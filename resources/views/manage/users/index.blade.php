@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-start justify-between gap-3 flex-col sm:flex-row">
        <div>
            <p class="text-sm text-slate-400">Gestão</p>
            <h1 class="text-3xl font-semibold tracking-tight">Utilizadores</h1>
            <p class="text-slate-300">Gere utilizadores e as suas permissões.</p>
        </div>
    </div>

    @if(session('status'))
        <div class="rounded-lg border border-emerald-700 bg-emerald-950/60 px-4 py-3 text-sm text-emerald-100">{{ session('status') }}</div>
    @endif

    @if(session('error'))
        <div class="rounded-lg border border-red-700 bg-red-950/60 px-4 py-3 text-sm text-red-100">{{ session('error') }}</div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-slate-800 bg-slate-900/60">
        <table class="w-full">
            <thead class="border-b border-slate-800 bg-slate-950/50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Nome</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Permissão</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-300">Registado</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-slate-300">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse($users as $user)
                    <tr class="transition hover:bg-slate-800/30">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600 font-bold text-white">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-medium">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-400">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if(auth()->user()->role === 'admin')
                                <form action="{{ route('manage.users.update', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" onchange="this.form.submit()" class="rounded-lg border border-slate-700 bg-slate-950 px-3 py-1 text-sm text-slate-50 focus:border-indigo-500 focus:outline-none">
                                        <option value="cliente" {{ $user->role === 'cliente' ? 'selected' : '' }}>Cliente</option>
                                        <option value="gestor" {{ $user->role === 'gestor' ? 'selected' : '' }}>Gestor</option>
                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </form>
                            @else
                                <span class="rounded-full border border-slate-700 bg-slate-900 px-3 py-1 text-xs uppercase tracking-wide text-slate-200">
                                    {{ $user->role }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-400">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('manage.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Eliminar utilizador {{ $user->name }}?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-rose-400 px-3 py-1 text-sm text-rose-200 transition hover:bg-rose-500 hover:text-slate-900">
                                        Eliminar
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-slate-500">(Tu)</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400">Nenhum utilizador encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
