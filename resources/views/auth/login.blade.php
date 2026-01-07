@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-md space-y-6">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight">Entrar</h1>
        <p class="text-sm text-slate-400">Acede para gerir favoritos e alertas.</p>
    </div>

    <form action="{{ route('login') }}" method="POST" class="space-y-4 rounded-xl border border-slate-800 bg-slate-900/60 p-6 shadow-lg">
        @csrf
        <div class="space-y-2">
            <label for="email" class="text-sm text-slate-300">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
        </div>
        <div class="space-y-2">
            <label for="password" class="text-sm text-slate-300">Password</label>
            <input id="password" name="password" type="password" required class="w-full rounded-lg border border-slate-700 bg-slate-950 px-3 py-2 text-slate-50 focus:border-indigo-500 focus:outline-none" />
        </div>
        <label class="inline-flex items-center gap-2 text-sm text-slate-300">
            <input type="checkbox" name="remember" class="rounded border-slate-700 bg-slate-950 text-indigo-500 focus:ring-indigo-500" />
            Lembrar sessão
        </label>
        <button type="submit" class="w-full rounded-lg bg-indigo-500 px-4 py-2 font-semibold text-slate-50 transition hover:bg-indigo-400">Entrar</button>
    </form>
    <p class="text-sm text-slate-400">Ainda não tens conta? <a href="{{ route('register') }}" class="text-indigo-300 hover:text-indigo-200">Regista-te aqui</a>.</p>
</div>
@endsection
