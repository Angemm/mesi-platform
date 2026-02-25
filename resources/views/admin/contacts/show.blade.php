@extends('layouts.admin')
@section('title', 'Message de ' . ($contact->nom ?? '') . ' — Admin')
@section('page-title', 'Détail du message')

@section('content')

<div class="max-w-3xl">
    <div class="mb-5">
        <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition-colors">
            <i class="fas fa-arrow-left text-xs"></i> Retour aux messages
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        {{-- En-tête --}}
        <div class="p-6 border-b border-slate-100" style="background:#F8F6F2;">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center font-black text-lg text-white flex-shrink-0"
                         style="background:linear-gradient(135deg,#4A8C3F,#2D6A27);">
                        {{ strtoupper(substr($contact->nom ?? 'X', 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-900 text-lg">{{ $contact->nom }}</h2>
                        <div class="flex flex-wrap gap-3 text-xs text-slate-400 mt-1">
                            <a href="mailto:{{ $contact->email }}" class="flex items-center gap-1 hover:text-green-700 transition-colors">
                                <i class="fas fa-envelope"></i> {{ $contact->email }}
                            </a>
                            @if($contact->telephone)
                            <a href="tel:{{ $contact->telephone }}" class="flex items-center gap-1 hover:text-green-700 transition-colors">
                                <i class="fas fa-phone"></i> {{ $contact->telephone }}
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                <span class="text-xs text-slate-400">{{ $contact->created_at->isoFormat('D MMMM YYYY [à] HH:mm') }}</span>
            </div>
        </div>

        {{-- Sujet --}}
        @if($contact->sujet)
        <div class="px-6 py-4 border-b border-slate-100">
            <span class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-1">Sujet</span>
            <p class="font-bold text-slate-900">{{ $contact->sujet }}</p>
        </div>
        @endif

        {{-- Message --}}
        <div class="p-6">
            <span class="text-xs font-black uppercase tracking-wider text-slate-400 block mb-3">Message</span>
            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed whitespace-pre-wrap text-sm p-5 rounded-xl" style="background:#F8F6F2;">{{ $contact->message }}</div>
        </div>

        {{-- Actions --}}
        <div class="px-6 py-5 border-t border-slate-100 flex flex-wrap gap-3">
            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->sujet ?? 'Votre message' }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white font-bold text-sm"
               style="background:linear-gradient(135deg,#4A8C3F,#2D6A27);">
                <i class="fas fa-reply"></i> Répondre par email
            </a>
            @if($contact->telephone)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->telephone) }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white font-bold text-sm" style="background:#25D366;">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
            @endif
            <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" onsubmit="return confirm('Supprimer ce message ?')" class="ml-auto">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm text-red-500 border border-red-200 hover:bg-red-50 transition-colors">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </form>
        </div>
    </div>

    {{-- Navigation messages --}}
    <div class="flex justify-between mt-5">
        @if(isset($precedent) && $precedent)
        <a href="{{ route('admin.contacts.show', $precedent) }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition-colors">
            <i class="fas fa-chevron-left text-xs"></i> Message précédent
        </a>
        @else <span></span> @endif
        @if(isset($suivant) && $suivant)
        <a href="{{ route('admin.contacts.show', $suivant) }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition-colors">
            Message suivant <i class="fas fa-chevron-right text-xs"></i>
        </a>
        @endif
    </div>
</div>

@endsection
