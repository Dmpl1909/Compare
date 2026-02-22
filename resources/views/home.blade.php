@extends('layouts.app')

@section('content')
<div class="space-y-12 sm:space-y-16">
    <!-- Hero Section com animação -->
    <section class="relative overflow-hidden rounded-2xl sm:rounded-3xl border border-emerald-500/20 bg-gradient-to-br from-emerald-900/30 via-teal-900/30 to-slate-900/50 p-6 sm:p-8 md:p-12 lg:p-16 shadow-2xl shadow-emerald-500/10">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDQwIDAgTCAwIDAgMCA0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDUpIiBzdHJva2Utd2lkdGg9IjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JpZCkiLz48L3N2Zz4=')] opacity-20"></div>
        <div class="relative z-10 max-w-4xl">

            <h1 class="mb-4 sm:mb-6 text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-extrabold tracking-tight">
                Encontre os <span class="bg-gradient-to-r from-emerald-400 via-teal-400 to-cyan-400 bg-clip-text text-transparent animate-float">Melhores Preços</span><br/>
                de Jogos Online
            </h1>
            <p class="mb-6 sm:mb-8 max-w-2xl text-base sm:text-lg md:text-xl text-slate-300 leading-relaxed">
                Compare instantaneamente preços de milhares de jogos em dezenas de lojas. Poupe até 70% nas suas compras com alertas inteligentes.
            </p>
            <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4">
                <a href="{{ route('products.catalog') }}" class="group rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 px-6 sm:px-8 py-3 sm:py-4 text-sm sm:text-base font-bold text-white transition hover:from-emerald-500 hover:to-teal-500 shadow-lg shadow-emerald-500/40 flex items-center justify-center gap-2">
                    Explorar Catálogo
                    <svg class="h-5 w-5 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="{{ route('games.deals') }}" class="rounded-xl border-2 border-emerald-500/50 bg-slate-900/50 px-6 sm:px-8 py-3 sm:py-4 text-sm sm:text-base font-bold backdrop-blur-sm transition hover:border-emerald-400 hover:bg-slate-900/80 text-center">
                    Ver Promoções
                </a>
            </div>
        </div>
        <div class="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-emerald-600/10 via-teal-600/5 to-transparent hidden sm:block"></div>
    </section>

    <!-- Jogos em Destaque -->
    <section class="space-y-6 sm:space-y-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent">Jogos em Destaque</h2>
                <p class="text-slate-400 mt-2 text-sm sm:text-base">Produtos curados pela nossa equipa de gestores</p>
            </div>
            <a href="{{ route('products.catalog') }}" class="group flex items-center gap-2 text-emerald-400 font-semibold hover:text-emerald-300 transition text-sm sm:text-base">
                Ver todos
                <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        @if($products->count() > 0)
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($products->take(6) as $product)
                    @php
                        $bestOffer = $product->offers->sortBy('price')->first();
                    @endphp
                    <article class="group relative overflow-hidden rounded-2xl border border-slate-800/50 bg-gradient-to-br from-slate-900/50 to-slate-900/80 backdrop-blur-sm transition hover:border-emerald-500/50 hover:shadow-xl hover:shadow-emerald-500/10">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/0 to-teal-600/0 opacity-0 transition group-hover:from-emerald-600/5 group-hover:to-teal-600/5 group-hover:opacity-100"></div>
                        <div class="relative p-6">
                            @if($product->image_url)
                                <div class="mb-4 overflow-hidden rounded-lg aspect-video">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition group-hover:scale-105" />
                                </div>
                            @endif
                            <h3 class="mb-2 text-lg font-bold group-hover:text-emerald-300 transition">
                                <a href="{{ route('products.show', $product) }}" class="after:absolute after:inset-0">{{ $product->name }}</a>
                            </h3>
                            <p class="mb-4 line-clamp-2 text-sm text-slate-400">{{ $product->description }}</p>
                            
                            <div class="flex items-center justify-between border-t border-slate-800/50 pt-4">
                                <div>
                                    <p class="text-xs text-slate-500 mb-1">Melhor preço</p>
                                    <p class="text-2xl font-bold bg-gradient-to-r from-emerald-400 to-green-400 bg-clip-text text-transparent">
                                        {{ $bestOffer ? '€' . number_format($bestOffer->price, 2, ',', '.') : '—' }}
                                    </p>
                                    @if($bestOffer)
                                        <p class="text-xs text-slate-500">em {{ $bestOffer->source->name }}</p>
                                    @endif
                                </div>
                                <div class="rounded-full bg-emerald-600/20 p-3 text-emerald-400 transition group-hover:bg-emerald-600/30">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-slate-800/50 bg-slate-900/40 p-16 text-center">
                <div class="mx-auto mb-4 h-16 w-16 rounded-full bg-slate-800/50 flex items-center justify-center">
                    <svg class="h-8 w-8 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <p class="text-slate-400">Nenhum jogo disponível no momento</p>
            </div>
        @endif
    </section>

    <!-- Funcionalidades -->
    <section class="space-y-6 sm:space-y-8">
        <div class="text-center">
            <h2 class="text-2xl sm:text-3xl font-bold tracking-tight bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent">Porquê usar o Compare?</h2>
            <p class="text-slate-400 mt-2 text-sm sm:text-base">Tudo o que precisa para encontrar as melhores ofertas</p>
        </div>
        <div class="grid gap-4 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="group relative overflow-hidden rounded-2xl border border-slate-800/50 bg-gradient-to-br from-slate-900/50 to-slate-900/80 p-6 sm:p-8 backdrop-blur-sm transition hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-500/10">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/0 to-teal-600/0 opacity-0 transition group-hover:from-emerald-600/5 group-hover:to-teal-600/5 group-hover:opacity-100"></div>
                <div class="relative">
                    <div class="mb-4 inline-flex h-12 w-12 sm:h-14 sm:w-14 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500/20 to-teal-500/20 text-emerald-400 transition group-hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="mb-2 sm:mb-3 text-lg sm:text-xl font-bold group-hover:text-emerald-300 transition">Comparação Instantânea</h3>
                    <p class="text-slate-400 leading-relaxed text-sm sm:text-base">Compare preços de dezenas de lojas online em segundos e encontre a melhor oferta sem esforço.</p>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl border border-slate-800/50 bg-gradient-to-br from-slate-900/50 to-slate-900/80 p-6 sm:p-8 backdrop-blur-sm transition hover:border-emerald-500/50 hover:shadow-lg hover:shadow-emerald-500/10">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-600/0 to-teal-600/0 opacity-0 transition group-hover:from-emerald-600/5 group-hover:to-teal-600/5 group-hover:opacity-100"></div>
                <div class="relative">
                    <div class="mb-4 inline-flex h-12 w-12 sm:h-14 sm:w-14 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500/20 to-teal-500/20 text-emerald-400 transition group-hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="mb-2 sm:mb-3 text-lg sm:text-xl font-bold group-hover:text-emerald-300 transition">Alertas Inteligentes</h3>
                    <p class="text-slate-400 leading-relaxed text-sm sm:text-base">Receba notificações quando o preço dos seus jogos favoritos baixar. Nunca perca uma promoção.</p>
                </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl border border-slate-800/50 bg-gradient-to-br from-slate-900/50 to-slate-900/80 p-6 sm:p-8 backdrop-blur-sm transition hover:border-pink-500/50 hover:shadow-lg hover:shadow-pink-500/10 sm:col-span-2 lg:col-span-1">
                <div class="absolute inset-0 bg-gradient-to-br from-pink-600/0 to-rose-600/0 opacity-0 transition group-hover:from-pink-600/5 group-hover:to-rose-600/5 group-hover:opacity-100"></div>
                <div class="relative">
                    <div class="mb-4 inline-flex h-12 w-12 sm:h-14 sm:w-14 items-center justify-center rounded-xl bg-gradient-to-br from-pink-500/20 to-rose-500/20 text-pink-400 transition group-hover:scale-110">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sm:h-7 sm:w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="mb-2 sm:mb-3 text-lg sm:text-xl font-bold group-hover:text-pink-300 transition">Lista de Favoritos</h3>
                    <p class="text-slate-400 leading-relaxed text-sm sm:text-base">Organize os seus jogos numa lista personalizada e acompanhe a evolução dos preços ao longo do tempo.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    @guest
    <section class="relative overflow-hidden rounded-2xl sm:rounded-3xl border border-emerald-500/30 bg-gradient-to-br from-emerald-900/40 via-teal-900/40 to-slate-900/60 p-6 sm:p-8 md:p-12 text-center shadow-2xl shadow-emerald-500/10">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDQwIDAgTCAwIDAgMCA0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSJyZ2JhKDI1NSwyNTUsMjU1LDAuMDUpIiBzdHJva2Utd2lkdGg9IjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JpZCkiLz48L3N2Zz4=')] opacity-20"></div>
        <div class="relative">
            <div class="mx-auto mb-4 sm:mb-6 inline-flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 shadow-lg shadow-emerald-500/40">
                <svg class="h-8 w-8 sm:h-10 sm:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h2 class="mb-3 sm:mb-4 text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight">Pronto para começar a poupar?</h2>
            <p class="mx-auto mb-6 sm:mb-8 max-w-2xl text-base sm:text-lg text-slate-300">Crie uma conta gratuita em segundos e tenha acesso a milhares de ofertas atualizadas diariamente.</p>
            <div class="flex flex-col sm:flex-row flex-wrap justify-center gap-3 sm:gap-4">
                <a href="{{ route('register') }}" class="group rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 px-6 sm:px-8 py-3 sm:py-4 text-sm sm:text-base font-bold text-white transition hover:from-emerald-500 hover:to-teal-500 shadow-lg shadow-emerald-500/40 flex items-center justify-center gap-2">
                    Criar Conta Grátis
                    <svg class="h-5 w-5 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="{{ route('login') }}" class="rounded-xl border-2 border-emerald-500/50 bg-slate-900/50 px-6 sm:px-8 py-3 sm:py-4 text-sm sm:text-base font-bold backdrop-blur-sm transition hover:border-emerald-400 hover:bg-slate-900/80 text-center">
                    Já tenho conta
                </a>
            </div>
        </div>
    </section>
    @endguest
</div>
@endsection
