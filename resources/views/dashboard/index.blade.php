@extends('layouts.app')

@section('content')
<!-- Hero Header -->
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-800 via-slate-700 to-slate-900 p-8 mb-6 shadow-2xl border border-slate-700">
    <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-slate-400">DASHBOARD {{ strtoupper($user->role) }}</p>
    <h1 class="mb-4 text-4xl font-bold text-slate-100">Olá, {{ $user->name }}!</h1>
    <p class="max-w-3xl text-slate-300">{{ $roleMessage }}</p>
</div>

<!-- Statistics Cards -->
<div class="mb-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-6 shadow-lg">
        <p class="mb-1 text-sm font-semibold uppercase tracking-wide text-slate-400">Produtos</p>
        <p class="mb-2 text-5xl font-bold text-indigo-300">{{ $stats['produtos'] }}</p>
        <p class="text-sm text-slate-500">Jogos no catálogo</p>
    </div>
    
    <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-6 shadow-lg">
        <p class="mb-1 text-sm font-semibold uppercase tracking-wide text-slate-400">Ofertas Ativas</p>
        <p class="mb-2 text-5xl font-bold text-emerald-300">{{ $stats['ofertas'] }}</p>
        <p class="text-sm text-slate-500">Preços disponíveis</p>
    </div>
    
    <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-6 shadow-lg">
        <p class="mb-1 text-sm font-semibold uppercase tracking-wide text-slate-400">Favoritos</p>
        <p class="mb-2 text-5xl font-bold text-rose-300">{{ $stats['favoritos'] }}</p>
        <p class="text-sm text-slate-500">Jogos guardados</p>
    </div>
</div>

<!-- Actions and Next Steps -->
<div class="grid gap-6 lg:grid-cols-2">
    <!-- Quick Actions -->
    <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-8 shadow-lg">
        <h2 class="mb-6 text-2xl font-bold text-slate-100">Ações rápidas</h2>
        
        <div class="space-y-4">
            <a href="{{ route('home') }}" class="block rounded-xl bg-slate-800/50 border border-slate-700 p-4 transition hover:bg-slate-700/50">
                <p class="mb-1 font-semibold text-indigo-300">Ver catálogo</p>
                <p class="text-sm text-slate-400">Explora todos os jogos disponíveis</p>
            </a>
            
            @if($user->isAdmin() || $user->isManager())
                <a href="{{ route('manage.products.index') }}" class="block rounded-xl bg-slate-800/50 border border-slate-700 p-4 transition hover:bg-slate-700/50">
                    <p class="mb-1 font-semibold text-purple-300">Gerir jogos</p>
                    <p class="text-sm text-slate-400">Adiciona ou remove jogos do catálogo</p>
                </a>
            @endif
            
            @if($user->isAdmin())
                <a href="{{ route('manage.users.index') }}" class="block rounded-xl bg-slate-800/50 border border-slate-700 p-4 transition hover:bg-slate-700/50">
                    <p class="mb-1 font-semibold text-amber-300">Gerir utilizadores</p>
                    <p class="text-sm text-slate-400">Administra contas e permissões</p>
                </a>
            @endif
            
            <a href="{{ route('profile.edit') }}" class="block rounded-xl bg-slate-800/50 border border-slate-700 p-4 transition hover:bg-slate-700/50">
                <p class="mb-1 font-semibold text-emerald-300">Atualizar perfil</p>
                <p class="text-sm text-slate-400">Atualiza dados de contacto</p>
            </a>
        </div>
    </div>
    
    <!-- Next Steps -->
    <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-8 shadow-lg">
        <h2 class="mb-6 text-2xl font-bold text-slate-100">Próximos passos</h2>
        
        <div class="space-y-4">
            <div class="flex gap-4">
                <div class="mt-1 h-2 w-2 shrink-0 rounded-full bg-indigo-400"></div>
                <p class="text-sm text-slate-300">
                    Explora a seção de jogos para descobrir as melhores ofertas
                </p>
            </div>
            
            <div class="flex gap-4">
                <div class="mt-1 h-2 w-2 shrink-0 rounded-full bg-indigo-400"></div>
                <p class="text-sm text-slate-300">
                    Adiciona jogos aos favoritos para acompanhar variações de preço
                </p>
            </div>
            
            <div class="flex gap-4">
                <div class="mt-1 h-2 w-2 shrink-0 rounded-full bg-indigo-400"></div>
                <p class="text-sm text-slate-300">
                    Atualiza os teus dados no perfil para manter tudo em dia
                </p>
            </div>
            
            @if($user->isAdmin() || $user->isManager())
                <div class="flex gap-4">
                    <div class="mt-1 h-2 w-2 shrink-0 rounded-full bg-purple-400"></div>
                    <p class="text-sm text-slate-300">
                        Revê o catálogo e adiciona novas ofertas
                    </p>
                </div>
            @endif
            
            @if($user->isAdmin())
                <div class="flex gap-4">
                    <div class="mt-1 h-2 w-2 shrink-0 rounded-full bg-amber-400"></div>
                    <p class="text-sm text-slate-300">
                        Gere utilizadores e suas permissões
                    </p>
                </div>
            @endif
            
            <div class="mt-6 rounded-xl bg-slate-800/50 border border-slate-700 p-6">
                <h3 class="mb-2 font-semibold text-slate-100 flex items-center gap-2">
                    <svg class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Alertas de Preço
                </h3>
                <p class="mb-2 text-sm text-slate-300">
                    <span class="font-bold text-indigo-300">{{ $stats['alertas'] }}</span> alertas ativos
                </p>
                <p class="text-xs text-slate-400">
                    Em breve: envio de email/SMS quando o preço descer abaixo do valor definido
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
