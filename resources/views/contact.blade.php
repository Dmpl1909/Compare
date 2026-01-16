@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-slate-900 dark:text-slate-100">Entre em Contato</h1>
        <p class="mt-2 text-lg text-slate-600 dark:text-slate-400">Tem alguma questão ou sugestão? Envie-nos uma mensagem!</p>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/30 p-4">
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/30 p-4">
            <div class="flex items-start gap-3">
                <svg class="h-5 w-5 text-red-600 dark:text-red-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-red-800 dark:text-red-200">Ocorreram alguns erros:</p>
                    <ul class="mt-1 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('contact.send') }}" method="POST" class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-6 md:p-8 shadow-xl">
        @csrf
        
        <div class="space-y-6">
            <!-- Nome -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Nome <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}" 
                    required
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-slate-50 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 focus:outline-none transition"
                    placeholder="O seu nome"
                />
            </div>

            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Email <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-slate-50 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 focus:outline-none transition"
                    placeholder="seuemail@exemplo.com"
                />
            </div>

            <!-- Assunto -->
            <div class="space-y-2">
                <label for="subject" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Assunto <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="subject" 
                    name="subject" 
                    value="{{ old('subject') }}" 
                    required
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-slate-50 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 focus:outline-none transition"
                    placeholder="Qual é o assunto da sua mensagem?"
                />
            </div>

            <!-- Mensagem -->
            <div class="space-y-2">
                <label for="message" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Mensagem <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="message" 
                    name="message" 
                    rows="6" 
                    required
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-slate-50 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/20 focus:outline-none transition resize-none"
                    placeholder="Escreva a sua mensagem aqui..."
                >{{ old('message') }}</textarea>
            </div>

            <!-- Botão Submit -->
            <div class="flex gap-3 pt-4">
                <button 
                    type="submit" 
                    class="flex-1 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-6 py-3 font-semibold text-white transition hover:from-cyan-400 hover:to-blue-400 shadow-lg shadow-cyan-500/40 hover:shadow-cyan-500/60 hover:scale-[1.02]"
                >
                    <span class="flex items-center justify-center gap-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Enviar Mensagem
                    </span>
                </button>
            </div>
        </div>
    </form>

    <!-- Informações de contato adicionais -->
    <div class="grid md:grid-cols-3 gap-4 mt-8">
        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-6 text-center">
            <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-cyan-100 dark:bg-cyan-900/30 mb-3">
                <svg class="h-6 w-6 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="font-semibold text-slate-900 dark:text-slate-100">Email</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Resposta em 24h</p>
        </div>

        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-6 text-center">
            <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/30 mb-3">
                <svg class="h-6 w-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="font-semibold text-slate-900 dark:text-slate-100">Disponibilidade</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Seg-Sex, 9h-18h</p>
        </div>

        <div class="rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 p-6 text-center">
            <div class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900/30 mb-3">
                <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                </svg>
            </div>
            <h3 class="font-semibold text-slate-900 dark:text-slate-100">Suporte</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Sempre disponível</p>
        </div>
    </div>
</div>
@endsection
