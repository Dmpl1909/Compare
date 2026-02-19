@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-md space-y-6">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight">Definir nova password</h1>
        <p class="text-sm text-gray-500">Escolhe uma nova password para voltares a entrar.</p>
    </div>

    <form action="{{ route('password.update') }}" method="POST" class="space-y-4 rounded-xl border border-gray-200 bg-white p-6 shadow-lg">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="space-y-2">
            <label for="email" class="text-sm text-gray-600">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-indigo-500 focus:outline-none" />
        </div>

        <div class="space-y-2">
            <label for="password" class="text-sm text-gray-600">Nova password</label>
            <input id="password" name="password" type="password" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-indigo-500 focus:outline-none" />
        </div>

        <div class="space-y-2">
            <label for="password_confirmation" class="text-sm text-gray-600">Confirmar password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-indigo-500 focus:outline-none" />
        </div>

        <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white transition hover:bg-indigo-700">Guardar nova password</button>
    </form>

    <p class="text-sm text-gray-500">Voltar ao <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700">login</a>.</p>
</div>
@endsection
