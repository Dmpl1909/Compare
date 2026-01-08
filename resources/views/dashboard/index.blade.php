@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-start justify-between gap-3 flex-col sm:flex-row">
        <div>
            <p class="text-sm text-slate-400">Dashboard</p>
            <h1 class="text-3xl font-semibold tracking-tight">Olá, {{ $user->name }}</h1>
            <p class="text-slate-300">{{ $roleMessage }}</p>
        </div>
        <span class="rounded-full border border-slate-700 bg-slate-900 px-3 py-1 text-sm uppercase tracking-wide text-slate-200">Perfil: {{ $user->role }}</span>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-4 shadow">
            <p class="text-sm text-slate-400">Produtos</p>
            <p class="text-3xl font-semibold text-indigo-300">{{ $stats['produtos'] }}</p>
        </div>
        <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-4 shadow">
            <p class="text-sm text-slate-400">Ofertas</p>
            <p class="text-3xl font-semibold text-emerald-300">{{ $stats['ofertas'] }}</p>
        </div>
        <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-4 shadow">
            <p class="text-sm text-slate-400">Utilizadores</p>
            <p class="text-3xl font-semibold text-amber-300">{{ $stats['utilizadores'] }}</p>
        </div>
        <div class="rounded-xl border border-slate-800 bg-slate-900/70 p-4 shadow">
            <p class="text-sm text-slate-400">Favoritos</p>
            <p class="text-3xl font-semibold text-rose-300">{{ $stats['favoritos'] }}</p>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-2xl border border-slate-800 bg-slate-900/60 p-6 shadow-lg">
            <h2 class="text-lg font-semibold">Atalhos rápidos</h2>
            <div class="mt-4 flex flex-wrap gap-3 text-sm">
                <a href="{{ route('home') }}" class="rounded-full border border-indigo-400 px-4 py-2 text-indigo-100 hover:bg-indigo-500 hover:text-slate-900">Ver catálogo</a>
                <a href="{{ route('home', ['q' => '']) }}" class="rounded-full border border-emerald-400 px-4 py-2 text-emerald-100 hover:bg-emerald-500 hover:text-slate-900">Pesquisar jogos</a>
                @if($user->isAdmin() || $user->isManager())                    <a href="{{ route('manage.products.index') }}" class="rounded-full border border-purple-400 px-4 py-2 text-purple-100 hover:bg-purple-400 hover:text-slate-900">Gerir jogos</a>                    <a href="{{ route('manage.users.index') }}" class="rounded-full border border-amber-400 px-4 py-2 text-amber-100 hover:bg-amber-400 hover:text-slate-900">Gerir utilizadores</a>
                @endif
            </div>
        </div>
        <div class="rounded-2xl border border-slate-800 bg-slate-900/60 p-6 shadow-lg">
            <h2 class="text-lg font-semibold">Alertas</h2>
            <p class="mt-2 text-sm text-slate-300">Alertas ativos: {{ $stats['alertas'] }}</p>
            <p class="text-xs text-slate-500">Em breve: envio de email/SMS quando o preço descer.</p>
        </div>
    </div>
</div>
@endsection
