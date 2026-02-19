@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-md space-y-6">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight">Recuperar acesso</h1>
        <p class="text-sm text-gray-500">Enviaremos um link para repores a password.</p>
    </div>

    <form action="{{ route('password.email') }}" method="POST" class="space-y-4 rounded-xl border border-gray-200 bg-white p-6 shadow-lg">
        @csrf
        <div class="space-y-2">
            <label for="email" class="text-sm text-gray-600">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-indigo-500 focus:outline-none" />
        </div>
        <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white transition hover:bg-indigo-700">Enviar link de recuperação</button>
    </form>

    <p class="text-sm text-gray-500">Lembraste a password? <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700">Volta ao login</a>.</p>
    <p class="text-sm text-gray-500">Precisas de conta? <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700">Regista-te aqui</a>.</p>
</div>
@endsection
