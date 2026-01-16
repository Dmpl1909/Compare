@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="relative overflow-hidden rounded-2xl border border-purple-500/20 bg-gradient-to-br from-purple-900/30 via-blue-900/30 to-slate-900/50 p-8 backdrop-blur-sm shadow-xl shadow-purple-500/10">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDQwIDAgTCAwIDAgMCA0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDUpIiBzdHJva2Utd2lkdGg9IjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JpZCkiLz48L3N2Zz4=')] opacity-20"></div>
        <div class="relative flex items-start justify-between gap-4 flex-col sm:flex-row">
            <div>
                <div class="mb-2 inline-flex items-center gap-1.5 rounded-full bg-purple-500/20 px-3 py-1 text-xs font-semibold text-purple-300 backdrop-blur-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Painel de Administração
                </div>
                <h1 class="text-4xl font-bold tracking-tight bg-gradient-to-r from-purple-400 to-blue-400 bg-clip-text text-transparent">Gestão de Utilizadores</h1>
                <p class="text-slate-300 mt-2">Gere utilizadores e as suas permissões de acesso ao sistema</p>
            </div>
            <div class="flex items-center gap-2 rounded-xl bg-slate-900/50 px-4 py-3 backdrop-blur-sm border border-slate-700/50">
                <svg class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="text-sm font-semibold text-slate-300">{{ $users->total() }} {{ $users->total() === 1 ? 'Utilizador' : 'Utilizadores' }}</span>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('status'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-500/50 bg-gradient-to-r from-emerald-900/30 to-green-900/30 px-5 py-4 backdrop-blur-sm">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-500/20">
                <svg class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <p class="text-emerald-100 font-medium">{{ session('status') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center gap-3 rounded-xl border border-red-500/50 bg-gradient-to-r from-red-900/30 to-rose-900/30 px-5 py-4 backdrop-blur-sm">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-500/20">
                <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <p class="text-red-100 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Users Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-800/50 bg-gradient-to-br from-slate-900/50 to-slate-900/80 backdrop-blur-sm shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-slate-800/50 bg-gradient-to-r from-cyan-900/20 to-teal-900/20">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-cyan-300">Utilizador</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-cyan-300">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-cyan-300">Permissão</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-cyan-300">Membro desde</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-cyan-300">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/30">
                    @forelse($users as $user)
                        <tr class="group transition hover:bg-slate-800/30">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="relative flex-shrink-0">
                                        @if($user->avatar)
                                            <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="h-12 w-12 rounded-xl object-cover border-2 border-cyan-500/50 shadow-lg shadow-cyan-500/30 transition group-hover:scale-110 group-hover:shadow-cyan-500/50 group-hover:border-cyan-500">
                                        @else
                                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-cyan-500 to-teal-500 font-bold text-white shadow-lg shadow-cyan-500/30 transition group-hover:scale-110 group-hover:shadow-cyan-500/50">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        @if($user->id === auth()->id())
                                            <div class="absolute -right-1 -top-1 h-4 w-4 rounded-full bg-emerald-500 border-2 border-slate-900"></div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-white group-hover:text-cyan-300 transition">{{ $user->name }}</p>
                                        @if($user->id === auth()->id())
                                            <p class="text-xs text-emerald-400 font-medium">Você</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2 text-sm text-slate-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $user->email }}
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('manage.users.update', $user) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" onchange="this.form.submit()" class="rounded-lg border border-slate-700/50 bg-slate-950/50 backdrop-blur-sm px-4 py-2 text-sm font-semibold text-slate-50 transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 cursor-pointer hover:border-cyan-500/50">
                                            <option value="cliente" {{ $user->role === 'cliente' ? 'selected' : '' }}>Cliente</option>
                                            <option value="gestor" {{ $user->role === 'gestor' ? 'selected' : '' }}>Gestor</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </form>
                                @else
                                    @php
                                        $roleColors = [
                                            'admin' => 'from-amber-500/20 to-orange-500/20 border-amber-500/50 text-amber-300',
                                            'gestor' => 'from-cyan-500/20 to-teal-500/20 border-cyan-500/50 text-cyan-300',
                                            'cliente' => 'from-slate-700/20 to-slate-600/20 border-slate-600/50 text-slate-300'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 rounded-lg border bg-gradient-to-br px-3 py-1.5 text-xs font-bold uppercase tracking-wide {{ $roleColors[$user->role] ?? $roleColors['cliente'] }}">
                                        @if($user->role === 'admin')
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                            </svg>
                                        @elseif($user->role === 'gestor')
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        @endif
                                        {{ $user->role }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2 text-sm text-slate-400">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $user->created_at->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('manage.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja eliminar {{ $user->name }}?\n\nEsta ação é irreversível.');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="group/btn inline-flex items-center gap-2 rounded-lg border-2 border-rose-500/50 bg-rose-500/10 px-4 py-2 text-sm font-semibold text-rose-300 transition hover:border-rose-400 hover:bg-rose-500/20 hover:text-rose-200">
                                            <svg class="h-4 w-4 transition group-hover/btn:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-lg bg-slate-800/50 px-4 py-2 text-xs font-medium text-slate-500">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        Conta protegida
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="mx-auto mb-4 h-16 w-16 rounded-full bg-slate-800/50 flex items-center justify-center">
                                    <svg class="h-8 w-8 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-400 text-lg">Nenhum utilizador encontrado</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
