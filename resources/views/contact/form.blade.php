@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-semibold tracking-tight text-gray-900">Contacto</h1>
        <p class="text-gray-600 mt-2">Tem alguma questão? Envie-nos uma mensagem.</p>
    </div>

    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6 rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
        @csrf
        
        <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700" for="name">Nome</label>
            <input 
                id="name" 
                name="name" 
                value="{{ old('name') }}" 
                required 
                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20" 
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700" for="email">Email</label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                value="{{ old('email') }}" 
                required 
                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20" 
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700" for="subject">Assunto</label>
            <input 
                id="subject" 
                name="subject" 
                value="{{ old('subject') }}" 
                required 
                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20" 
            />
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium text-gray-700" for="message">Mensagem</label>
            <textarea 
                id="message" 
                name="message" 
                rows="6" 
                required 
                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-900 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20"
            >{{ old('message') }}</textarea>
        </div>

        <div class="flex gap-3">
            <button 
                type="submit" 
                class="rounded-full bg-indigo-600 px-6 py-2.5 font-semibold text-white transition hover:bg-indigo-700"
            >
                Enviar mensagem
            </button>
            <a 
                href="{{ route('home') }}" 
                class="rounded-full border border-gray-300 px-6 py-2.5 text-gray-700 hover:border-gray-400 hover:bg-gray-50"
            >
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
