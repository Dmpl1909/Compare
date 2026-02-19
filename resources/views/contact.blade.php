@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-semibold tracking-tight">Contacto</h1>
        <p class="text-slate-300 mt-2">Tem alguma questão? Envie-nos uma mensagem.</p>
    </div>

    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6 rounded-2xl border border-slate-800 bg-slate-900/60 p-8 shadow-lg">
        @csrf
        
        <div class="space-y-2">
            <label class="text-sm font-medium text-slate-300" for="name">Nome</label>
            <input 
                id="name" 
                name="name" 
                value="{{ old('name') }}" 
                required 
                class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-50 focus:border-emerald-500 focus:outline-none" 
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium text-slate-300" for="email">Email</label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                value="{{ old('email') }}" 
                required 
                class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-50 focus:border-emerald-500 focus:outline-none" 
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium text-slate-300" for="subject">Assunto</label>
            <input 
                id="subject" 
                name="subject" 
                value="{{ old('subject') }}" 
                required 
                class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-50 focus:border-emerald-500 focus:outline-none" 
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium text-slate-300" for="message">Mensagem</label>
            <textarea 
                id="message" 
                name="message" 
                rows="6" 
                required 
                class="w-full rounded-lg border border-slate-700 bg-slate-950 px-4 py-2.5 text-slate-50 focus:border-emerald-500 focus:outline-none"
            >{{ old('message') }}</textarea>
        </div>

        <div class="flex gap-3">
            <button 
                type="submit" 
                class="rounded-full bg-emerald-600 px-6 py-2.5 font-semibold text-slate-50 transition hover:bg-emerald-500"
            >
                Enviar mensagem
            </button>
            <a 
                href="{{ route('home') }}" 
                class="rounded-full border border-slate-700 px-6 py-2.5 text-slate-300 hover:border-emerald-500 hover:text-emerald-300"
            >
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
