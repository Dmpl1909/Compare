@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-md space-y-6">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight">Criar conta</h1>
        <p class="text-sm text-slate-400">Guarda favoritos e recebe alertas de preço.</p>
    </div>

    <form action="{{ route('register') }}" method="POST" class="space-y-4 rounded-xl border border-slate-800 bg-slate-900/60 p-6 shadow-lg">
        @csrf
        <div class="space-y-2">
            <label for="name" class="text-sm text-slate-300">Nome</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
        </div>
        <div class="space-y-2">
            <label for="email" class="text-sm text-slate-300">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
        </div>
        <div class="space-y-2">
            <label for="role" class="text-sm text-slate-300">Perfil</label>
            <select id="role" name="role" class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none">
                <option value="cliente" @selected(old('role')==='cliente')>Cliente</option>
                <option value="gestor" @selected(old('role')==='gestor')>Gestor</option>
                <option value="admin" @selected(old('role')==='admin')>Admin</option>
            </select>
        </div>
        <div class="space-y-2">
            <label for="password" class="text-sm text-slate-300">Password</label>
            <input id="password" name="password" type="password" required class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
        </div>
        <div class="space-y-2">
            <label for="password_confirmation" class="text-sm text-slate-300">Confirmar Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
        </div>
        <button type="submit" class="w-full rounded-lg bg-indigo-500 px-4 py-2 font-semibold text-slate-50 transition hover:bg-indigo-400">Criar conta</button>
    </form>
    <p class="text-sm text-slate-400">Já tens conta? <a href="{{ route('login') }}" class="text-indigo-300 hover:text-indigo-200">Entra aqui</a>.</p>
</div>
@endsection
