<!DOCTYPE html>
<html lang="pt-PT" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare - Comparador de Preços de Jogos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        html, body { 
            background-color: #020617 !important; 
            color: #f8fafc !important;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .gradient-mesh {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
    </style>
</head>
<body class="min-h-screen bg-slate-950 text-slate-50" style="background-color: #020617 !important; color: #f8fafc !important;">
    <!-- Background decorative elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 h-80 w-80 rounded-full bg-purple-500/10 blur-3xl"></div>
        <div class="absolute top-1/2 -left-40 h-80 w-80 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="absolute -bottom-40 right-1/4 h-80 w-80 rounded-full bg-pink-500/10 blur-3xl"></div>
    </div>

    <header class="relative border-b border-slate-800/50 bg-slate-900/80 backdrop-blur-xl sticky top-0 z-50">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="group flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-blue-600 font-bold text-white shadow-lg shadow-purple-500/50 transition group-hover:shadow-purple-500/70">
                    C
                </div>
                <span class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-blue-500 bg-clip-text text-transparent">Compare</span>
            </a>
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="{{ route('products.catalog') }}" class="text-slate-300 hover:text-white transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gradient-to-r after:from-purple-500 after:to-blue-500 after:transition-all hover:after:w-full">Catálogo</a>
                <a href="{{ route('games.deals') }}" class="text-slate-300 hover:text-white transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gradient-to-r after:from-purple-500 after:to-blue-500 after:transition-all hover:after:w-full">Promoções</a>
                @auth
                    <a href="{{ route('favorites.index') }}" class="text-slate-300 hover:text-white transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gradient-to-r after:from-purple-500 after:to-blue-500 after:transition-all hover:after:w-full">Favoritos</a>
                    @if(auth()->user()->role === 'gestor' || auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="text-slate-300 hover:text-white transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gradient-to-r after:from-purple-500 after:to-blue-500 after:transition-all hover:after:w-full">Dashboard</a>
                    @endif
                @endauth
            </nav>
            <div class="flex items-center gap-3">
                @auth
                    <div class="hidden lg:flex items-center gap-2 rounded-full bg-slate-800/50 px-4 py-2">
                        <div class="h-2 w-2 rounded-full bg-emerald-400"></div>
                        <span class="text-sm text-slate-300">{{ auth()->user()->name }}</span>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="rounded-xl border border-slate-700 bg-slate-800/30 px-4 py-2 text-sm transition hover:border-purple-500 hover:bg-slate-800/50">Perfil</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:from-purple-500 hover:to-blue-500 shadow-lg shadow-purple-500/30">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-xl border border-slate-700 bg-slate-800/30 px-4 py-2 text-sm transition hover:border-purple-500 hover:bg-slate-800/50">Entrar</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 px-5 py-2 text-sm font-semibold text-white transition hover:from-purple-500 hover:to-blue-500 shadow-lg shadow-purple-500/30">Criar Conta</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="relative mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8" style="background-color: transparent;">
        @if (session('status'))
            <div class="mb-6 rounded-2xl border border-emerald-500/50 bg-gradient-to-r from-emerald-900/40 to-emerald-800/40 backdrop-blur-sm px-6 py-4 text-sm text-emerald-100 shadow-lg" style="background-color: rgba(6, 78, 59, 0.5); color: #d1fae5; border-color: rgba(16, 185, 129, 0.5);">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('status') }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-500/50 bg-gradient-to-r from-rose-900/40 to-rose-800/40 backdrop-blur-sm px-6 py-4 text-sm text-rose-100 shadow-lg" style="background-color: rgba(127, 29, 29, 0.5); color: #ffe4e6; border-color: rgba(244, 63, 94, 0.5);">
                <div class="flex gap-3">
                    <svg class="h-5 w-5 text-rose-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="relative border-t border-slate-800/50 bg-slate-900/50 backdrop-blur-xl mt-20">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid gap-8 md:grid-cols-3">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-purple-500 to-blue-600 font-bold text-white">
                            C
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-purple-400 to-blue-500 bg-clip-text text-transparent">Compare</span>
                    </div>
                    <p class="text-sm text-slate-400 max-w-xs">O melhor comparador de preços de jogos online. Poupe dinheiro encontrando as melhores ofertas.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-4 text-slate-200">Links Rápidos</h3>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('products.catalog') }}" class="hover:text-purple-400 transition">Catálogo</a></li>
                        <li><a href="{{ route('games.deals') }}" class="hover:text-purple-400 transition">Promoções</a></li>
                        @auth
                            <li><a href="{{ route('favorites.index') }}" class="hover:text-purple-400 transition">Meus Favoritos</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold mb-4 text-slate-200">Legal</h3>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="https://www.livroreclamacoes.pt/inicio/" target="_blank" class="hover:text-purple-400 transition flex items-center gap-2">
                            Livro de Reclamações
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-slate-800/50 text-center text-sm text-slate-500">
                <p>© {{ date('Y') }} Compare. Projeto Final - Comparador de Preços Online.</p>
            </div>
        </div>
    </footer>
</body>
</html>
