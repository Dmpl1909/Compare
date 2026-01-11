@extends('layouts.app')

@section('content')
<div class="space-y-12">
    <!-- Hero Section -->
    <section class="relative overflow-hidden rounded-2xl border border-slate-800 bg-gradient-to-br from-indigo-900/40 via-slate-900/60 to-slate-900/60 p-8 md:p-12">
        <div class="relative z-10">
            <h1 class="mb-4 text-4xl font-bold tracking-tight md:text-5xl">
                Bem-vindo ao <span class="text-indigo-400">Compare</span>
            </h1>
            <p class="mb-6 max-w-2xl text-lg text-slate-300">
                O melhor comparador de preços de jogos online. Encontre as melhores ofertas e poupe dinheiro nas suas compras.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('products.catalog') }}" class="rounded-lg bg-indigo-600 px-6 py-3 font-semibold transition hover:bg-indigo-500">
                    Ver Todos os Jogos
                </a>
                <a href="{{ route('games.deals') }}" class="rounded-lg border border-indigo-500 px-6 py-3 font-semibold transition hover:bg-indigo-500/10">
                    Promoções em Destaque
                </a>
            </div>
        </div>
        <div class="absolute right-0 top-0 h-full w-1/2 bg-gradient-to-l from-indigo-600/10 to-transparent"></div>
    </section>

    <!-- Jogos em Destaque (da Base de Dados) -->
    <section class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight">Jogos em Destaque</h2>
                <p class="text-sm text-slate-400">Produtos adicionados pelos nossos gestores</p>
            </div>
            <a href="{{ route('products.catalog') }}" class="text-sm font-semibold text-indigo-400 hover:text-indigo-300">
                Ver todos →
            </a>
        </div>

        @if($products->count() > 0)
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($products->take(6) as $product)
                    @php
                        $bestOffer = $product->offers->sortBy('price')->first();
                    @endphp
                    <article class="group overflow-hidden rounded-xl border border-slate-800 bg-slate-900/60 transition hover:border-indigo-500 hover:shadow-lg hover:shadow-indigo-500/10">
                        <div class="p-6">
                            <h3 class="mb-2 text-lg font-semibold group-hover:text-indigo-300">
                                <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="mb-4 line-clamp-2 text-sm text-slate-400">{{ $product->description }}</p>
                            
                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-xs text-slate-500">Melhor preço</p>
                                    <p class="text-2xl font-bold text-emerald-400">
                                        {{ $bestOffer ? '€' . number_format($bestOffer->price, 2, ',', '.') : '—' }}
                                    </p>
                                    @if($bestOffer)
                                        <p class="text-xs text-slate-500">{{ $bestOffer->source->name }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product) }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold transition hover:bg-indigo-500">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-xl border border-slate-800 bg-slate-900/40 p-12 text-center">
                <p class="text-slate-400">Nenhum jogo disponível no momento</p>
            </div>
        @endif
    </section>

    <!-- Funcionalidades -->
    <section class="space-y-6">
        <h2 class="text-2xl font-bold tracking-tight">Porquê usar o Compare?</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-xl border border-slate-800 bg-slate-900/40 p-6">
                <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-lg bg-indigo-600/20 text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-semibold">Comparação de Preços</h3>
                <p class="text-sm text-slate-400">Compare preços de várias lojas online num só lugar e poupe dinheiro.</p>
            </div>

            <div class="rounded-xl border border-slate-800 bg-slate-900/40 p-6">
                <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-lg bg-emerald-600/20 text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-semibold">Promoções em Tempo Real</h3>
                <p class="text-sm text-slate-400">Acesso a milhares de ofertas atualizadas em tempo real.</p>
            </div>

            <div class="rounded-xl border border-slate-800 bg-slate-900/40 p-6">
                <div class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-lg bg-rose-600/20 text-rose-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-semibold">Lista de Favoritos</h3>
                <p class="text-sm text-slate-400">Guarde os seus jogos favoritos e receba alertas de preços.</p>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    @guest
    <section class="rounded-2xl border border-slate-800 bg-gradient-to-r from-indigo-900/40 to-purple-900/40 p-8 text-center md:p-12">
        <h2 class="mb-3 text-3xl font-bold">Pronto para começar a poupar?</h2>
        <p class="mb-6 text-slate-300">Crie uma conta gratuita e comece a comparar preços hoje mesmo.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('register') }}" class="rounded-lg bg-indigo-600 px-6 py-3 font-semibold transition hover:bg-indigo-500">
                Criar Conta Grátis
            </a>
            <a href="{{ route('login') }}" class="rounded-lg border border-indigo-500 px-6 py-3 font-semibold transition hover:bg-indigo-500/10">
                Já tenho conta
            </a>
        </div>
    </section>
    @endguest
</div>
@endsection
