@extends('layouts.app')

@section('content')
<!-- Hero Header -->
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-gray-100 via-gray-50 to-white p-8 mb-6 shadow-2xl border border-gray-200">
    <p class="mb-2 text-sm font-semibold uppercase tracking-wider text-gray-500">DASHBOARD {{ strtoupper($user->role) }}</p>
    <h1 class="mb-4 text-4xl font-bold text-gray-800">Olá, {{ $user->name }}!</h1>
    <p class="max-w-3xl text-gray-600">{{ $roleMessage }}</p>
</div>

<!-- Statistics Cards -->
<div class="mb-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg">
        <p class="mb-1 text-sm font-semibold uppercase tracking-wide text-gray-500">Produtos</p>
        <p class="mb-2 text-5xl font-bold text-indigo-600">{{ $stats['produtos'] }}</p>
        <p class="text-sm text-gray-400">Jogos no catálogo</p>
    </div>
    
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg">
        <p class="mb-1 text-sm font-semibold uppercase tracking-wide text-gray-500">Ofertas Ativas</p>
        <p class="mb-2 text-5xl font-bold text-emerald-600">{{ $stats['ofertas'] }}</p>
        <p class="text-sm text-gray-400">Preços disponíveis</p>
    </div>
    
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-lg">
        <p class="mb-1 text-sm font-semibold uppercase tracking-wide text-gray-500">Favoritos</p>
        <p class="mb-2 text-5xl font-bold text-rose-600">{{ $stats['favoritos'] }}</p>
        <p class="text-sm text-gray-400">Jogos guardados</p>
    </div>
</div>

<!-- Actions and Next Steps -->
<div class="grid gap-6 lg:grid-cols-2">
    <!-- Quick Actions -->
    <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-lg">
        <h2 class="mb-6 text-2xl font-bold text-gray-800">Ações rápidas</h2>
        
        <div class="space-y-4">
            <a href="{{ route('home') }}" class="block rounded-xl bg-gray-50 border border-gray-200 p-4 transition hover:bg-gray-100">
                <p class="mb-1 font-semibold text-indigo-600">Ver catálogo</p>
                <p class="text-sm text-gray-500">Explora todos os jogos disponíveis</p>
            </a>
            
            @if($user->isAdmin() || $user->isManager())
                <a href="{{ route('manage.products.index') }}" class="block rounded-xl bg-gray-50 border border-gray-200 p-4 transition hover:bg-gray-100">
                    <p class="mb-1 font-semibold text-purple-600">Gerir jogos</p>
                    <p class="text-sm text-gray-500">Adiciona ou remove jogos do catálogo</p>
                </a>
            @endif
            
            @if($user->isAdmin())
                <a href="{{ route('manage.users.index') }}" class="block rounded-xl bg-gray-50 border border-gray-200 p-4 transition hover:bg-gray-100">
                    <p class="mb-1 font-semibold text-amber-600">Gerir utilizadores</p>
                    <p class="text-sm text-gray-500">Administra contas e permissões</p>
                </a>
            @endif
            
            <a href="{{ route('profile.edit') }}" class="block rounded-xl bg-gray-50 border border-gray-200 p-4 transition hover:bg-gray-100">
                <p class="mb-1 font-semibold text-emerald-600">Atualizar perfil</p>
                <p class="text-sm text-gray-500">Atualiza dados de contacto</p>
            </a>
        </div>
    </div>
    
    <!-- Next Steps -->
    <div class="rounded-2xl border border-gray-200 bg-white p-8 shadow-lg">
        <h2 class="mb-6 text-2xl font-bold text-gray-800">Próximos passos</h2>
        
        <div class="space-y-4">
            <div class="flex gap-4">
                <div class="mt-1 h-2 w-2 shrink-0 rounded-full bg-indigo-600"></div>
                <p class="text-sm text-gray-600">
                    Explora a seção de jogos para descobrir as melhores ofertas
                </p>
            </div>
            
            <div class="flex gap-4">
                <div class="mt-1 h-2 w-2 shrink-0 rounded-full bg-indigo-600"></div>
                <p class="text-sm text-gray-600">
                    Adiciona jogos aos favoritos para acompanhar variações de preço
                </p>
            </div>
            
            <div class="flex gap-4">
                <div class="mt-1 h-2 w-2 shrink-0 rounded-full bg-indigo-600"></div>
                <p class="text-sm text-gray-600">
                    Atualiza os teus dados no perfil para manter tudo em dia
                </p>
            </div>
            
            @if($user->isAdmin() || $user->isManager())
                <div class="flex gap-4">
                    <div class="mt-1 h-2 w-2 shrink-0 rounded-full bg-purple-600"></div>
                    <p class="text-sm text-gray-600">
                        Revê o catálogo e adiciona novas ofertas
                    </p>
                </div>
            @endif
            
            @if($user->isAdmin())
                <div class="flex gap-4">
                    <div class="mt-1 h-2 w-2 shrink-0 rounded-full bg-amber-600"></div>
                    <p class="text-sm text-gray-600">
                        Gere utilizadores e suas permissões
                    </p>
                </div>
            @endif
            
            <div class="mt-6 rounded-xl bg-gray-50 border border-gray-200 p-6">
                <h3 class="mb-2 font-semibold text-gray-800">📊 Alertas de Preço</h3>
                <p class="mb-2 text-sm text-gray-600">
                    <span class="font-bold text-indigo-600">{{ $stats['alertas'] }}</span> alertas ativos
                </p>
                <p class="text-xs text-gray-500">
                    Em breve: envio de email/SMS quando o preço descer abaixo do valor definido
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
