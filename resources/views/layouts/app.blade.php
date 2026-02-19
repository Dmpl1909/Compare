<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare - Preços de Jogos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-50">
    <header class="border-b border-slate-800 bg-slate-900/70 backdrop-blur">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo-icon.svg') }}" alt="Compare" class="h-10 w-10">
                <div>
                    <div class="text-xl font-bold text-slate-50">Compare</div>
                    <div class="text-xs text-slate-400">Preços de Jogos</div>
                </div>
            </a>
            <nav class="flex items-center gap-4 text-sm">
                <a href="{{ route('products.catalog') }}" class="text-slate-300 hover:text-emerald-300 font-medium">Jogos</a>
                <a href="{{ route('games.deals') }}" class="text-slate-300 hover:text-emerald-300 font-medium">Promoções</a>
                <a href="{{ route('contact.form') }}" class="text-slate-300 hover:text-emerald-300 font-medium">Contacto</a>
                @auth
                    <a href="{{ route('favorites.index') }}" class="text-slate-300 hover:text-emerald-300 font-medium">Favoritos</a>
                    @if(auth()->user()->role === 'gestor' || auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="text-slate-300 hover:text-emerald-300 font-medium">Dashboard</a>
                    @endif
                @endauth
                @auth
                    <div class="relative flex items-center gap-2">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="h-7 w-7 rounded-full object-cover border border-slate-700">
                        @else
                            <span class="flex h-7 w-7 items-center justify-center rounded-full border border-slate-700 bg-slate-800 text-xs font-semibold text-emerald-300">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="hidden sm:inline text-slate-300 hover:text-emerald-300 font-medium">{{ auth()->user()->name }}</a>
                        <a href="{{ route('profile.edit') }}" class="sm:hidden rounded-full border border-slate-700 px-3 py-1 transition hover:border-emerald-500 hover:text-emerald-300">Perfil</a>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-full border border-slate-700 px-3 py-1 transition hover:border-emerald-500 hover:text-emerald-300">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-full border border-slate-700 px-3 py-1 transition hover:border-emerald-500 hover:text-emerald-300">Entrar</a>
                    <a href="{{ route('register') }}" class="rounded-full bg-emerald-600 px-3 py-1 font-semibold text-slate-50 transition hover:bg-emerald-500">Criar conta</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-4 rounded-lg border border-emerald-700 bg-emerald-950/50 px-4 py-3 text-sm text-emerald-200">
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
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p>Projeto final · Comparador de preços online</p>
                    <a href="{{ route('contact.form') }}" class="font-medium text-emerald-300 hover:text-emerald-200">Contacte-nos</a>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('terms') }}" class="hover:text-emerald-300">Termos</a>
                    <a href="{{ route('privacy') }}" class="hover:text-emerald-300">Política de Privacidade</a>
                    <a href="https://www.livroreclamacoes.pt/inicio/" target="_blank" class="hover:text-emerald-300">Livro de Reclamações</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
