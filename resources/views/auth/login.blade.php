@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-md space-y-6">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight">Entrar</h1>
        <p class="text-sm text-gray-500">Acede para gerir favoritos e alertas.</p>
    </div>

    <form action="{{ route('login') }}" method="POST" class="space-y-4 rounded-xl border border-gray-200 bg-white p-6 shadow-lg">
        @csrf
        <div class="space-y-2">
            <label for="email" class="text-sm text-gray-600">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-indigo-500 focus:outline-none" />
        </div>
        <div class="space-y-2">
            <label for="password" class="text-sm text-gray-600">Password</label>
            <input id="password" name="password" type="password" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-indigo-500 focus:outline-none" />
        </div>
        <p><a href="{{ route('password.request') }}">Forgot your password?</a></p>
        <label class="inline-flex items-center gap-2 text-sm text-gray-600">
            <input type="checkbox" name="remember" class="rounded border-gray-300 bg-white text-indigo-600 focus:ring-indigo-500" />
            Lembrar sessão
        </label>
        <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white transition hover:bg-indigo-700">Entrar</button>
    </form>
    <p class="text-sm text-gray-500">Ainda não tens conta? <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700">Regista-te aqui</a>.</p>
</div>
@endsection
