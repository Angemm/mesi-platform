@extends('layouts.app')
@section('title','Cultes & Live — M.E.SI')

@section('content')

{{-- Header --}}
<div class="navy-gradient py-20 text-center relative overflow-hidden">
    <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(232,176,75,.07) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="relative z-10 max-w-3xl mx-auto px-6">
        <span class="text-gold font-black text-xs uppercase tracking-widest">Retransmissions</span>
        <h1 class="font-serif font-black text-white mt-3 mb-4" style="font-size:clamp(2rem,4vw,3rem)">Cultes & Live</h1>
        <p class="text-white/65 max-w-lg mx-auto text-sm leading-relaxed">Participez en présentiel ou suivez nos cultes en direct depuis chez vous, partout dans le monde.</p>
    </div>
</div>

<section class="py-16">
<div class="max-w-7xl mx-auto px-6">

    {{-- ── LIVE EN COURS ── --}}
    @if($culteLive)
    <div class="mb-16 reveal">
        <div class="flex items-center gap-3 mb-6">
            <div class="inline-flex items-center gap-2 bg-red-50 border border-red-200 px-4 py-2 rounded-full">
                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                <span class="text-red-600 font-black text-xs uppercase tracking-widest">En Direct Maintenant</span>
            </div>
        </div>
        <h2 class="font-serif font-black text-slate-900 text-2xl md:text-3xl mb-2">{{ $culteLive->titre }}</h2>
        @if($culteLive->predicateur)
        <p class="text-slate-500 mb-6 text-sm"><i class="fas fa-user text-gold/70 mr-1.5"></i>{{ $culteLive->predicateur }}</p>
        @endif

        <div class="bg-black rounded-3xl overflow-hidden shadow-2xl">
            <div class="bg-red-600 px-5 py-2.5 flex items-center gap-3">
                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                <span class="text-white font-black text-xs uppercase tracking-wider">M.E.SI — Culte en Direct</span>
            </div>
            @php
                preg_match('/(?:youtube\.com\/(?:watch\?v=|live\/|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $culteLive->lien_video ?? '', $m);
                $videoId = $m[1] ?? null;
            @endphp
            @if($videoId)
            <div class="relative" style="aspect-ratio:16/9;">
                <iframe src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1" frameborder="0"
                        allow="autoplay; encrypted-media; fullscreen" allowfullscreen class="w-full h-full"></iframe>
            </div>
            @elseif($culteLive->lien_video)
            <div class="relative" style="aspect-ratio:16/9;">
                <iframe src="{{ $culteLive->lien_video }}" frameborder="0" allow="autoplay; encrypted-media; fullscreen" allowfullscreen class="w-full h-full"></iframe>
            </div>
            @else
            <div class="flex items-center justify-center flex-col gap-4 text-white/50 py-20 bg-slate-950">
                <i class="fas fa-satellite-dish text-5xl text-red-500/70"></i>
                <p>Transmission en cours de démarrage…</p>
            </div>
            @endif
        </div>
        @if($culteLive->description)
        <div class="mt-5 bg-gold/5 border border-gold/15 rounded-2xl px-6 py-4">
            <p class="text-slate-700 leading-relaxed text-sm">{{ $culteLive->description }}</p>
        </div>
        @endif
    </div>
    @endif

    {{-- ── FILTRES ── --}}
    <div class="flex gap-2.5 flex-wrap mb-10">
        @foreach([null => 'Tous', 'culte-principal' => 'Cultes Principaux', 'etude-biblique' => 'Études Bibliques', 'jeunesse' => 'Jeunesse', 'priere' => 'Prières'] as $val => $label)
        <a href="{{ route('cultes.index', $val ? ['type' => $val] : []) }}"
           class="px-4 py-2 rounded-full text-sm font-bold transition-all
                  {{ request('type') === $val || (!request('type') && !$val) ? 'gold-gradient text-white shadow-md shadow-gold/25' : 'bg-slate-100 text-slate-600 hover:bg-gold/10 hover:text-gold-dark' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- ── GRILLE ── --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">
        @forelse($cultes as $culte)
        <article class="bg-white rounded-3xl overflow-hidden border border-slate-100 card-hover card-hover-gold group shadow-sm">
            <div class="relative aspect-video img-zoom">
                <img src="{{ $culte->image ? asset('storage/'.$culte->image) : asset('images/default-culte.jpg') }}" alt="{{ $culte->titre }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-navy/50 via-transparent to-transparent"></div>
                @if($culte->est_live)
                    <span class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-black px-3 py-1 rounded-full flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span> LIVE</span>
                @elseif($culte->est_a_venir)
                    <span class="absolute top-3 left-3 gold-gradient text-white text-[10px] font-black px-3 py-1 rounded-full">À VENIR</span>
                @else
                    <span class="absolute top-3 left-3 bg-navy text-white text-[10px] font-black px-3 py-1 rounded-full">REPLAY</span>
                @endif
                @if($culte->passage_biblique)
                <span class="absolute bottom-3 right-3 bg-black/60 backdrop-blur-sm text-white/80 text-[10px] px-2.5 py-1 rounded-full font-bold">
                    <i class="fas fa-bible mr-1 text-gold/80"></i>{{ $culte->passage_biblique }}
                </span>
                @endif
            </div>
            <div class="p-6">
                <h3 class="font-serif font-bold text-slate-900 text-lg mb-3 group-hover:text-gold-dark transition-colors leading-snug line-clamp-2">{{ $culte->titre }}</h3>
                <div class="flex flex-wrap gap-3 text-xs text-slate-400 mb-4">
                    <span class="flex items-center gap-1"><i class="fas fa-calendar text-gold/60"></i>{{ \Carbon\Carbon::parse($culte->date_culte)->isoFormat('D MMM YYYY') }}</span>
                    @if($culte->heure)<span class="flex items-center gap-1"><i class="fas fa-clock text-gold/60"></i>{{ $culte->heure }}</span>@endif
                    @if($culte->predicateur)<span class="flex items-center gap-1"><i class="fas fa-user text-gold/60"></i>{{ $culte->predicateur }}</span>@endif
                </div>
                @if($culte->description)
                <p class="text-sm text-slate-500 leading-relaxed mb-5 line-clamp-2">{{ $culte->description }}</p>
                @endif
                @if($culte->est_live || $culte->lien_video)
                <a href="{{ route('cultes.show', $culte->slug) }}" class="inline-flex items-center gap-2 bg-navy text-white text-sm font-bold px-5 py-2.5 rounded-xl hover:bg-gold-dark transition-colors">
                    <i class="fas fa-{{ $culte->est_live ? 'satellite-dish' : 'play' }} text-xs"></i>
                    {{ $culte->est_live ? 'Rejoindre le Live' : 'Voir le Replay' }}
                </a>
                @else
                <a href="{{ route('cultes.show', $culte->slug) }}" class="text-sm text-gold-dark font-bold hover:underline flex items-center gap-1">
                    Voir les détails <i class="fas fa-arrow-right text-xs"></i>
                </a>
                @endif
            </div>
        </article>
        @empty
        <div class="col-span-full text-center py-20 text-slate-400">
            <i class="fas fa-church text-5xl mb-4 block text-slate-200"></i>
            <p class="font-medium">Aucun culte disponible pour ce filtre.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center gap-2 mt-12">
        {{ $cultes->links('vendor.pagination.custom') }}
    </div>

</div>
</section>
@endsection
