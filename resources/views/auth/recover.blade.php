@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-md space-y-6">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">Recuperar acesso</h1>
        <p class="text-sm text-slate-600 dark:text-slate-400">Enviaremos um link para repores a password.</p>
    </div>

    <form action="{{ route('password.email') }}" method="POST" class="space-y-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-6 shadow-lg">
        @csrf
        <div class="space-y-2">
            <label for="email" class="text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-3 py-2.5 text-slate-900 dark:text-slate-50 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition-all" />
        </div>
        <button type="submit" class="w-full rounded-lg bg-gradient-to-r from-cyan-600 to-teal-600 px-4 py-3 font-bold text-white transition hover:from-cyan-500 hover:to-teal-500 shadow-lg shadow-cyan-500/30 focus:outline-none focus:ring-2 focus:ring-cyan-500/50">Enviar link de recuperação</button>
    </form>

    <p class="text-sm text-slate-600 dark:text-slate-400">Lembraste a password? <a href="{{ route('login') }}" class="text-cyan-600 dark:text-cyan-300 hover:text-cyan-700 dark:hover:text-cyan-200">Volta ao login</a>.</p>
    <p class="text-sm text-slate-600 dark:text-slate-400">Precisas de conta? <a href="{{ route('register') }}" class="text-cyan-600 dark:text-cyan-300 hover:text-cyan-700 dark:hover:text-cyan-200">Regista-te aqui</a>.</p>
</div>
@endsection
