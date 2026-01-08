<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparador de Preços</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-50">
    <header class="border-b border-slate-800 bg-slate-900/70 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="text-xl font-semibold tracking-tight">Compare</a>
            <nav class="flex items-center gap-4 text-sm">
                <a href="{{ route('games.index') }}" class="text-slate-300 hover:text-indigo-200">Jogos</a>
                @auth
                    <a href="{{ route('favorites.index') }}" class="text-slate-300 hover:text-indigo-200">Favoritos</a>
                    <a href="{{ route('dashboard') }}" class="text-slate-300 hover:text-indigo-200">Dashboard</a>
                @endauth
                @auth
                    <div class="relative">
                        <a href="{{ route('profile.edit') }}" class="hidden sm:inline text-slate-300 hover:text-indigo-200">Olá, {{ auth()->user()->name }}</a>
                        <a href="{{ route('profile.edit') }}" class="sm:hidden rounded-full border border-slate-700 px-3 py-1 transition hover:border-indigo-400 hover:text-indigo-200">Perfil</a>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-full border border-slate-700 px-3 py-1 transition hover:border-indigo-400 hover:text-indigo-200">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-full border border-slate-700 px-3 py-1 transition hover:border-indigo-400 hover:text-indigo-200">Entrar</a>
                    <a href="{{ route('register') }}" class="rounded-full bg-indigo-500 px-3 py-1 font-semibold text-slate-50 transition hover:bg-indigo-400">Criar conta</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-4 rounded-lg border border-emerald-600 bg-emerald-900/60 px-4 py-3 text-sm text-emerald-100">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-rose-700 bg-rose-950/60 px-4 py-3 text-sm text-rose-100">
                <ul class="list-disc space-y-1 pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="border-t border-slate-800 bg-slate-900/70 py-6 text-sm text-slate-400">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            Projeto final · Comparador de preços online
        </div>
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <a href="https://www.livroreclamacoes.pt/inicio/" target="_blank" class="hover:text-indigo-300">Livro de Reclamações</a>
            </div>
    </footer>
</body>
</html>
