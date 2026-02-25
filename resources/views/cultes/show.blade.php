@extends('layouts.app')
@section('title', $culte->titre . ' — M.E.SI')

@section('content')

<div class="navy-gradient py-16">
    <div class="max-w-5xl mx-auto px-6">
        <nav class="text-xs text-white/40 mb-5 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-white transition-colors">Accueil</a>
            <i class="fas fa-chevron-right text-[8px]"></i>
            <a href="{{ route('cultes.index') }}" class="hover:text-white transition-colors">Cultes</a>
            <i class="fas fa-chevron-right text-[8px]"></i>
            <span class="text-white/70">{{ Str::limit($culte->titre, 40) }}</span>
        </nav>
        <div class="flex items-center gap-3 mb-4">
            @if($culte->est_live)
                <span class="bg-red-500 text-white text-[10px] font-black px-3 py-1 rounded-full flex items-center gap-1.5"><span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>LIVE</span>
            @elseif($culte->est_a_venir)
                <span class="gold-gradient text-white text-[10px] font-black px-3 py-1 rounded-full">À VENIR</span>
            @else
                <span class="bg-white/20 text-white text-[10px] font-black px-3 py-1 rounded-full">REPLAY</span>
            @endif
            @if($culte->type)
            <span class="text-white/50 text-xs capitalize">{{ ucfirst(str_replace('-', ' ', $culte->type)) }}</span>
            @endif
        </div>
        <h1 class="font-serif font-black text-white text-3xl md:text-4xl leading-tight mb-4">{{ $culte->titre }}</h1>
        <div class="flex flex-wrap gap-4 text-sm text-white/60">
            <span><i class="fas fa-calendar text-gold/70 mr-1.5"></i>{{ \Carbon\Carbon::parse($culte->date_culte)->isoFormat('dddd D MMMM YYYY') }}</span>
            @if($culte->heure)<span><i class="fas fa-clock text-gold/70 mr-1.5"></i>{{ $culte->heure }}</span>@endif
            @if($culte->predicateur)<span><i class="fas fa-user text-gold/70 mr-1.5"></i>{{ $culte->predicateur }}</span>@endif
            @if($culte->passage_biblique)<span><i class="fas fa-bible text-gold/70 mr-1.5"></i>{{ $culte->passage_biblique }}</span>@endif
        </div>
    </div>
</div>

<section class="py-14 bg-slate-50">
<div class="max-w-5xl mx-auto px-6">

    @if($culte->lien_video)
    <div class="bg-black rounded-3xl overflow-hidden shadow-2xl mb-10">
        @php
            preg_match('/(?:youtube\.com\/(?:watch\?v=|live\/|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $culte->lien_video, $m);
            $videoId = $m[1] ?? null;
        @endphp
        @if($videoId)
        <div class="relative video-wrapper" style="aspect-ratio:16/9;">
            {{-- Overlay click-to-play --}}
            <div class="video-overlay absolute inset-0 bg-navy/80 flex flex-col items-center justify-center z-10 cursor-pointer group">
                <div class="w-20 h-20 gold-gradient rounded-full flex items-center justify-center shadow-2xl shadow-gold/40 group-hover:scale-110 transition-transform animate-pulse-gold mb-4">
                    <i class="fas fa-play text-white text-2xl ml-1"></i>
                </div>
                <p class="text-white/70 text-sm font-medium">Cliquer pour lancer</p>
            </div>
            <iframe src="https://www.youtube.com/embed/{{ $videoId }}{{ $culte->est_live ? '?autoplay=1' : '' }}"
                    frameborder="0" allow="autoplay; encrypted-media; fullscreen" allowfullscreen
                    class="w-full h-full absolute inset-0"></iframe>
        </div>
        @endif
    </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-10">
        {{-- Description --}}
        <div class="lg:col-span-2">
            @if($culte->description)
            <div class="bg-white rounded-2xl p-7 border border-slate-100 shadow-sm mb-6">
                <h2 class="font-serif font-bold text-slate-900 text-xl mb-4">À propos de ce culte</h2>
                <div class="text-slate-600 leading-relaxed">{!! nl2br(e($culte->description)) !!}</div>
            </div>
            @endif

            {{-- Suggestions --}}
            @if($suggestions->count() > 0)
            <div>
                <h3 class="font-serif font-bold text-slate-900 text-lg mb-5">Autres Cultes</h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach($suggestions as $s)
                    <a href="{{ route('cultes.show', $s->slug) }}" class="bg-white rounded-2xl overflow-hidden border border-slate-100 card-hover group flex">
                        <div class="w-24 h-full img-zoom flex-shrink-0">
                            <img src="{{ $s->image ? asset('storage/'.$s->image) : asset('images/default-culte.jpg') }}" alt="{{ $s->titre }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-4 flex-1 min-w-0">
                            <p class="font-bold text-slate-800 text-sm truncate group-hover:text-gold-dark transition-colors">{{ $s->titre }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ \Carbon\Carbon::parse($s->date_culte)->isoFormat('D MMM YYYY') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Infos --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h3 class="font-serif font-bold text-slate-900 mb-5">Informations</h3>
                <dl class="space-y-4">
                    <div class="flex gap-3"><dt class="w-8 h-8 bg-gold/10 rounded-xl flex items-center justify-center flex-shrink-0"><i class="fas fa-calendar text-gold-dark text-xs"></i></dt><dd><div class="text-xs text-slate-400 mb-0.5">Date</div><div class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($culte->date_culte)->isoFormat('dddd D MMM YYYY') }}</div></dd></div>
                    @if($culte->heure)<div class="flex gap-3"><dt class="w-8 h-8 bg-gold/10 rounded-xl flex items-center justify-center flex-shrink-0"><i class="fas fa-clock text-gold-dark text-xs"></i></dt><dd><div class="text-xs text-slate-400 mb-0.5">Heure</div><div class="text-sm font-bold text-slate-800">{{ $culte->heure }}</div></dd></div>@endif
                    @if($culte->predicateur)<div class="flex gap-3"><dt class="w-8 h-8 bg-gold/10 rounded-xl flex items-center justify-center flex-shrink-0"><i class="fas fa-user text-gold-dark text-xs"></i></dt><dd><div class="text-xs text-slate-400 mb-0.5">Prédicateur</div><div class="text-sm font-bold text-slate-800">{{ $culte->predicateur }}</div></dd></div>@endif
                    @if($culte->passage_biblique)<div class="flex gap-3"><dt class="w-8 h-8 bg-gold/10 rounded-xl flex items-center justify-center flex-shrink-0"><i class="fas fa-bible text-gold-dark text-xs"></i></dt><dd><div class="text-xs text-slate-400 mb-0.5">Passage</div><div class="text-sm font-bold text-slate-800">{{ $culte->passage_biblique }}</div></dd></div>@endif
                    @if($culte->vues)<div class="flex gap-3"><dt class="w-8 h-8 bg-gold/10 rounded-xl flex items-center justify-center flex-shrink-0"><i class="fas fa-eye text-gold-dark text-xs"></i></dt><dd><div class="text-xs text-slate-400 mb-0.5">Vues</div><div class="text-sm font-bold text-slate-800">{{ number_format($culte->vues) }}</div></dd></div>@endif
                </dl>
            </div>

            <div class="bg-navy rounded-2xl p-6 text-center">
                <i class="fas fa-church text-gold text-3xl mb-3"></i>
                <p class="text-white/70 text-sm leading-relaxed mb-5">Rejoignez-nous en présentiel pour vivre l'expérience complète du culte.</p>
                <a href="{{ route('contact') }}" class="gold-gradient text-white text-sm font-bold px-5 py-2.5 rounded-xl inline-block hover:-translate-y-0.5 transition-all shadow-lg shadow-gold/25">
                    <i class="fas fa-map-marker-alt mr-1.5"></i>Nous trouver
                </a>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
