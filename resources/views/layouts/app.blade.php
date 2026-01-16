<!DOCTYPE html>
<html lang="pt-PT" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compare - Comparador de Preços de Jogos</title>
    <script>
        // Prevent flash of wrong theme
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            document.documentElement.classList.toggle('dark', theme === 'dark');
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
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
        
        /* Menu Hamburger Animation */
        #mobile-menu-toggle.menu-open .menu-line:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }
        #mobile-menu-toggle.menu-open .menu-line:nth-child(2) {
            opacity: 0;
            transform: scaleX(0);
        }
        #mobile-menu-toggle.menu-open .menu-line:nth-child(3) {
            transform: translateY(-10px) rotate(-45deg);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 dark:bg-gradient-to-br dark:from-slate-950 dark:via-teal-950 dark:to-cyan-950 text-slate-900 dark:text-slate-50 transition-all duration-300">
    <!-- Background decorative elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 h-96 w-96 rounded-full bg-gradient-to-br from-emerald-400/20 to-teal-400/20 dark:from-emerald-500/20 dark:to-teal-500/20 blur-3xl animate-pulse"></div>
        <div class="absolute top-1/2 -left-40 h-96 w-96 rounded-full bg-gradient-to-br from-teal-400/20 to-cyan-400/20 dark:from-teal-500/20 dark:to-cyan-500/20 blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute -bottom-40 right-1/4 h-96 w-96 rounded-full bg-gradient-to-br from-cyan-400/20 to-sky-400/20 dark:from-cyan-500/20 dark:to-sky-500/20 blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <header class="relative border-b border-emerald-200/50 dark:border-teal-500/30 bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl sticky top-0 z-50 shadow-lg shadow-emerald-500/5 dark:shadow-teal-500/10">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="group flex items-center gap-2 sm:gap-3">
                <div class="flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 via-teal-600 to-cyan-600 font-bold text-white shadow-lg shadow-emerald-500/50 transition group-hover:shadow-emerald-500/70 group-hover:scale-110">
                    C
                </div>
                <span class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 bg-clip-text text-transparent">Compare</span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center gap-6 xl:gap-8 text-sm font-medium">
                <a href="{{ route('products.catalog') }}" class="text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gradient-to-r after:from-emerald-500 after:via-teal-500 after:to-cyan-500 after:transition-all hover:after:w-full">Catálogo</a>
                <a href="{{ route('games.deals') }}" class="text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gradient-to-r after:from-emerald-500 after:via-teal-500 after:to-cyan-500 after:transition-all hover:after:w-full">Promoções</a>
                <a href="{{ route('contact') }}" class="text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gradient-to-r after:from-emerald-500 after:via-teal-500 after:to-cyan-500 after:transition-all hover:after:w-full">Contato</a>
                @auth
                    <a href="{{ route('favorites.index') }}" class="text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gradient-to-r after:from-emerald-500 after:via-teal-500 after:to-cyan-500 after:transition-all hover:after:w-full">Favoritos</a>
                    @if(auth()->user()->role === 'gestor' || auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors relative after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-0 after:bg-gradient-to-r after:from-emerald-500 after:via-teal-500 after:to-cyan-500 after:transition-all hover:after:w-full">Dashboard</a>
                    @endif
                @endauth
            </nav>

            <!-- Right side buttons -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Theme Toggle Button -->
                <button type="button" id="theme-toggle" class="group rounded-xl p-2 sm:p-2.5 text-slate-600 dark:text-slate-300 hover:bg-emerald-100 dark:hover:bg-teal-800/50 transition-all duration-300 border-2 border-transparent hover:border-emerald-300 dark:hover:border-teal-500 hover:scale-110" aria-label="Alternar tema" title="Alternar tema">
                    <!-- Sun icon - shown in dark mode -->
                    <svg class="h-5 w-5 hidden dark:block group-hover:rotate-180 transition-transform duration-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                    </svg>
                    <!-- Moon icon - shown in light mode -->
                    <svg class="h-5 w-5 block dark:hidden group-hover:rotate-12 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                    </svg>
                </button>

                <!-- Desktop Auth Buttons -->
                @auth
                    <div class="hidden xl:flex items-center gap-2 rounded-full bg-emerald-100 dark:bg-teal-900/50 px-3 py-1.5 border border-emerald-200 dark:border-teal-700">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset(auth()->user()->avatar) }}" alt="Avatar" class="h-6 w-6 rounded-full object-cover border border-emerald-300 dark:border-teal-600">
                        @else
                            <div class="h-6 w-6 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center flex-shrink-0">
                                <span class="text-xs text-white font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <span class="text-xs text-emerald-900 dark:text-teal-200 font-medium">{{ auth()->user()->name }}</span>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="hidden sm:block rounded-xl border-2 border-emerald-300 dark:border-teal-600 bg-white dark:bg-teal-900/30 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm text-emerald-900 dark:text-teal-200 font-medium transition hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-teal-800/50 hover:scale-105">Perfil</a>
                    <form action="{{ route('logout') }}" method="POST" class="hidden sm:block">
                        @csrf
                        <button type="submit" class="rounded-xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white transition hover:from-emerald-500 hover:via-teal-500 hover:to-cyan-500 shadow-lg shadow-emerald-500/40 hover:shadow-emerald-500/60 hover:scale-105">Sair</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:block rounded-xl border-2 border-emerald-300 dark:border-teal-600 bg-white dark:bg-teal-900/30 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm text-emerald-900 dark:text-teal-200 font-medium transition hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-teal-800/50 hover:scale-105">Entrar</a>
                    <a href="{{ route('register') }}" class="hidden sm:block rounded-xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 px-3 sm:px-5 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white transition hover:from-emerald-500 hover:via-teal-500 hover:to-cyan-500 shadow-lg shadow-emerald-500/40 hover:shadow-emerald-500/60 hover:scale-105">Criar Conta</a>
                @endauth

                <!-- Mobile Menu Button (Hamburger) -->
                <button type="button" id="mobile-menu-toggle" class="lg:hidden flex flex-col justify-center items-center w-10 h-10 rounded-xl hover:bg-emerald-100 dark:hover:bg-teal-800/50 transition-all border-2 border-transparent hover:border-emerald-300 dark:hover:border-teal-500 group" aria-label="Menu" title="Menu">
                    <div class="w-6 h-5 relative flex flex-col justify-between">
                        <span class="menu-line w-full h-0.5 bg-slate-600 dark:bg-slate-300 rounded-full transition-all duration-300 origin-center"></span>
                        <span class="menu-line w-full h-0.5 bg-slate-600 dark:bg-slate-300 rounded-full transition-all duration-300 origin-center"></span>
                        <span class="menu-line w-full h-0.5 bg-slate-600 dark:bg-slate-300 rounded-full transition-all duration-300 origin-center"></span>
                    </div>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-emerald-200/50 dark:border-teal-500/30 bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl">
            <nav class="mx-auto max-w-7xl px-4 py-4 space-y-2">
                <a href="{{ route('products.catalog') }}" class="block px-4 py-3 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-emerald-100 dark:hover:bg-teal-800/50 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all font-medium">Catálogo</a>
                <a href="{{ route('games.deals') }}" class="block px-4 py-3 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-emerald-100 dark:hover:bg-teal-800/50 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all font-medium">Promoções</a>
                <a href="{{ route('contact') }}" class="block px-4 py-3 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-emerald-100 dark:hover:bg-teal-800/50 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all font-medium">Contato</a>
                @auth
                    <a href="{{ route('favorites.index') }}" class="block px-4 py-3 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-emerald-100 dark:hover:bg-teal-800/50 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all font-medium">Favoritos</a>
                    @if(auth()->user()->role === 'gestor' || auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl text-slate-700 dark:text-slate-300 hover:bg-emerald-100 dark:hover:bg-teal-800/50 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all font-medium">Dashboard</a>
                    @endif
                    
                    <div class="pt-2 mt-2 border-t border-emerald-200/50 dark:border-teal-500/30 space-y-2">
                        <div class="px-4 py-2 rounded-xl bg-emerald-100 dark:bg-teal-900/50 border border-emerald-200 dark:border-teal-700">
                            <div class="flex items-center gap-2">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset(auth()->user()->avatar) }}" alt="Avatar" class="h-8 w-8 rounded-full object-cover border border-emerald-300 dark:border-teal-600">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center flex-shrink-0">
                                        <span class="text-sm text-white font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                                <span class="text-sm text-emerald-900 dark:text-teal-200 font-medium">{{ auth()->user()->name }}</span>
                            </div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 rounded-xl border-2 border-emerald-300 dark:border-teal-600 bg-white dark:bg-teal-900/30 text-emerald-900 dark:text-teal-200 font-medium text-center transition hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-teal-800/50">Perfil</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-3 rounded-xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 text-white font-semibold transition hover:from-emerald-500 hover:via-teal-500 hover:to-cyan-500 shadow-lg shadow-emerald-500/40">Sair</button>
                        </form>
                    </div>
                @else
                    <div class="pt-2 mt-2 border-t border-emerald-200/50 dark:border-teal-500/30 space-y-2">
                        <a href="{{ route('login') }}" class="block px-4 py-3 rounded-xl border-2 border-emerald-300 dark:border-teal-600 bg-white dark:bg-teal-900/30 text-emerald-900 dark:text-teal-200 font-medium text-center transition hover:border-emerald-500 hover:bg-emerald-50 dark:hover:bg-teal-800/50">Entrar</a>
                        <a href="{{ route('register') }}" class="block px-4 py-3 rounded-xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 text-white font-semibold text-center transition hover:from-emerald-500 hover:via-teal-500 hover:to-cyan-500 shadow-lg shadow-emerald-500/40">Criar Conta</a>
                    </div>
                @endauth
            </nav>
        </div>
    </header>

    <main class="relative mx-auto max-w-7xl px-4 py-6 sm:py-8 md:py-12 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="mb-6 rounded-2xl border-2 border-emerald-400/50 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/40 dark:to-teal-900/40 backdrop-blur-sm px-6 py-4 text-sm text-emerald-900 dark:text-emerald-100 shadow-lg shadow-emerald-500/20">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('status') }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-500/50 bg-gradient-to-r from-rose-100 to-rose-50 dark:from-rose-900/40 dark:to-rose-800/40 backdrop-blur-sm px-6 py-4 text-sm text-rose-800 dark:text-rose-100 shadow-lg">
                <div class="flex gap-3">
                    <svg class="h-5 w-5 text-rose-600 dark:text-rose-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

    <footer class="relative border-t border-slate-200 dark:border-slate-800/50 bg-slate-50/50 dark:bg-slate-900/50 backdrop-blur-xl mt-12 sm:mt-16 md:mt-20">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:py-10 md:py-12 sm:px-6 lg:px-8">
            <div class="grid gap-6 sm:gap-8 sm:grid-cols-2 md:grid-cols-3">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-cyan-500 to-teal-600 font-bold text-white">
                            C
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-cyan-400 to-teal-500 bg-clip-text text-transparent">Compare</span>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-400 max-w-xs">O melhor comparador de preços de jogos online. Poupe dinheiro encontrando as melhores ofertas.</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-4 text-slate-800 dark:text-slate-200">Links Rápidos</h3>
                    <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                        <li><a href="{{ route('products.catalog') }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition">Catálogo</a></li>
                        <li><a href="{{ route('games.deals') }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition">Promoções</a></li>
                        @auth
                            <li><a href="{{ route('favorites.index') }}" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition">Meus Favoritos</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold mb-4 text-slate-800 dark:text-slate-200">Legal</h3>
                    <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                        <li><a href="https://www.livroreclamacoes.pt/inicio/" target="_blank" class="hover:text-cyan-600 dark:hover:text-cyan-400 transition flex items-center gap-2">
                            Livro de Reclamações
                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-slate-200 dark:border-slate-800/50 text-center text-sm text-slate-500 dark:text-slate-500">
                <p>© {{ date('Y') }} Compare. Projeto Final - Comparador de Preços Online.</p>
            </div>
        </div>
    </footer>
</body>
</html>
