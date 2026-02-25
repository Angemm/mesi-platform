@extends('layouts.app')
@section('title', 'Accueil — M.E.SI Mission Évangélique Sion')

@section('content')

{{-- ══════════════════════════════════
     HERO
══════════════════════════════════ --}}
<section class="relative min-h-[92vh] flex items-end overflow-hidden bg-slate-50">

    {{-- BG image --}}
    {{-- <div class="absolute inset-0 bg-cover bg-center" style="background-image:url('{{ asset('images/2026B.png') }}'); "></div> --}}

    {{-- Overlay gradient --}}
    {{-- <div class="hero-gradient absolute inset-0"></div> --}}

    {{-- Grille de points dorés --}}
    <div class="absolute inset-0 animate-drift" style="background-image:radial-gradient(circle, rgba(232,176,75,.07) 1px, transparent 1px); background-size:44px 44px;"></div>

    {{-- Badge live flottant --}}
    @if($culteLive)
    <div class="absolute top-24 right-8 md:right-16 glass rounded-2xl px-5 py-3.5 flex items-center gap-3 animate-float z-10 hidden md:flex">
        <div class="live-dot"></div>
        <div>
            <div class="text-red-400 font-black text-xs uppercase tracking-widest">En Direct</div>
            <div class="text-white/70 text-xs mt-0.5">{{ Str::limit($culteLive->titre, 30) }}</div>
        </div>
    </div>
    @endif

    {{-- Contenu principal --}}
    <div class="relative z-10 max-w-7xl mx-auto px-6 pb-40 pt-20 w-full">
        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 bg-gold/15 border border-gold/35 text-gold px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest mb-7 reveal">
                <i class="fas fa-cross text-[10px]"></i> Bienvenue dans la famille
            </div>
            <h1 class="font-serif font-black text-green-700 leading-[1.08] mb-6 reveal" style="font-size:clamp(2.4rem,5.5vw,4.2rem); animation-delay:.1s">
                Mission Évangélique<br><span class="text-gold">Sion</span>
            </h1>
            <p class="text-white/72 text-lg leading-relaxed max-w-xl mb-10 reveal" style="animation-delay:.2s">
                Une église vivante, enracinée dans la Parole de Dieu. Rejoignez-nous pour le culte, la communion fraternelle et l'avancement du Royaume.
            </p>
            <div class="flex gap-4 flex-wrap reveal" style="animation-delay:.3s">
                @if($culteLive)
                <a href="{{ route('cultes.live') }}" class="gold-gradient text-white px-7 py-3.5 rounded-xl font-bold flex items-center gap-2.5 shadow-xl shadow-gold/35 hover:-translate-y-1 hover:shadow-gold/50 transition-all">
                    <span class="live-dot w-2.5 h-2.5"></span> Rejoindre le Live
                </a>
                @else
                <a href="{{ route('cultes.index') }}" class="gold-gradient text-white px-7 py-3.5 rounded-xl font-bold flex items-center gap-2.5 shadow-xl shadow-gold/35 hover:-translate-y-1 hover:shadow-gold/50 transition-all">
                    <i class="fas fa-play-circle"></i> Voir nos Cultes
                </a>
                @endif
                <a href="{{ route('eglise.index') }}" class="bg-white/12 border border-white/25 text-white px-7 py-3.5 rounded-xl font-bold flex items-center gap-2.5 hover:bg-white/22 hover:border-gold/50 hover:text-gold transition-all">
                    <i class="fas fa-church text-sm"></i> Découvrir l'Église
                </a>
            </div>
        </div>
    </div>

    {{-- Barre de stats --}}
    <div class="absolute bottom-0 left-0 right-0 bg-dark/90 backdrop-blur-xl border-t border-white/8">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4">
            @foreach([['membres','Membres','+'],['cultes','Cultes Diffusés','+'],['missions','Missions Actives',''],['annees',"Années d'Histoire",'']] as [$k,$l,$s])
            <div class="text-center py-5 px-4 border-r border-white/6 last:border-r-0">
                <div class="font-serif font-bold text-gold text-3xl" data-count="{{ $stats[$k] }}" data-suffix="{{ $s }}">0</div>
                <div class="text-white/50 text-xs uppercase tracking-wider mt-1">{{ $l }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════
     VERSET DU JOUR
══════════════════════════════════ --}}
<section class="navy-gradient py-20 text-center relative overflow-hidden">
    <div class="absolute top-4 left-1/2 -translate-x-1/2 font-serif text-[10rem] text-gold/6 leading-none select-none pointer-events-none">"</div>
    <div class="relative z-10 max-w-3xl mx-auto px-6">
        <p class="font-serif italic text-white leading-relaxed mb-5 reveal" style="font-size:clamp(1.15rem,2.5vw,1.65rem)">
            {{ $verset->texte ?? "pour le perfectionnement des saints en vue de l'œuvre du ministère et de l'édification du corps de Christ," }}
        </p>
        <span class="text-gold font-black text-sm uppercase tracking-widest">— {{ $verset->reference ?? 'Ephésiens 4:12' }}</span>
    </div>
</section>

{{-- ══════════════════════════════════
     QUI SOMMES-NOUS
══════════════════════════════════ --}}
<section class="py-24 bg-white relative overflow-hidden">
    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/3 w-96 h-96 bg-gold/8 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/3 w-96 h-96 bg-navy/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="grid lg:grid-cols-2 gap-16 items-center">

            {{-- COLONNE GAUCHE : IMAGE --}}
            <div class="reveal relative">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl aspect-[4/5]">
                    <img
                        src="{{ asset('images/2026.jpg') }}"
                        alt="Notre Mission"
                        class="w-full h-full object-cover"
                    >
                    {{-- Overlay optionnel --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/30 to-transparent"></div>
                </div>

                {{-- Badge flottant optionnel --}}
                <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl p-4 flex items-center gap-3">
                    <div class="p-2 bg-gold/10 rounded-xl">
                        <i class="fas fa-church text-gold-dark text-xl"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-900 text-sm">Voeux du couple pastoral</p>
                        <p class="text-xs text-slate-500"></p>
                    </div>
                </div>

                {{-- Décoration derrière l'image --}}
                <div class="absolute -z-10 -bottom-4 -left-4 w-full h-full rounded-3xl border-2 border-gold/20"></div>
            </div>

            {{-- COLONNE DROITE : CONTENU --}}
            <div class="reveal">
                {{-- <span class="inline-block px-4 py-1.5 rounded-full bg-gold/12 text-gold-dark text-xs font-black uppercase tracking-widest mb-6">Notre Mission</span> --}}
                <h2 class="font-serif font-black text-slate-900 leading-tight mb-8" style="font-size:clamp(1.9rem,3.5vw,2.8rem)">
                    Un lieu de <span class="text-gold-dark italic">transformation</span><br>spirituelle et d'unité.
                </h2>
                <div class="grid sm:grid-cols-1 gap-5">
                    @foreach([
                        ['bg-gold/10 text-gold-dark','fas fa-users','Une Famille en Christ','Enracinés dans l\'amour du Christ, nous formons une communauté fraternelle chaleureuse.'],
                        ['bg-emerald-50 text-emerald-600','fas fa-heart','Une Communauté d\'Amour','Un réseau de soutien et d\'entraide pour chaque membre de notre famille spirituelle.'],
                        ['bg-blue-50 text-blue-600','fas fa-globe','Une Église en Mission','Engagés pour la proclamation de l\'Évangile au-delà de nos frontières.'],
                    ] as [$bg,$icon,$title,$desc])
                    <div class="flex items-start gap-4 p-4 rounded-2xl hover:bg-slate-50 transition-colors">
                        <div class="p-3 {{ $bg }} rounded-xl flex-shrink-0">
                            <i class="{{ $icon }} text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-900 mb-1">{{ $title }}</h4>
                            <p class="text-sm text-slate-500 leading-relaxed">{{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

            {{-- Horaires --}}
            {{-- <div class="reveal" style="animation-delay:.15s">
                <div class="relative">
                    <div class="absolute inset-0 gold-gradient rounded-3xl rotate-2 scale-105 opacity-8"></div>
                    <div class="relative bg-white rounded-3xl border border-gold/15 shadow-2xl shadow-slate-200 p-8 md:p-10">
                        <h3 class="font-serif font-black text-slate-900 text-2xl mb-8 pb-5 border-b border-gold/15">Nos Cultes</h3>
                        <ul class="space-y-5">
                            @foreach(\App\Models\HoraireCulte::actif()->orderBy('ordre')->get() as $h)
                            <li class="flex justify-between items-center p-4 rounded-2xl hover:bg-gold/5 transition-colors group">
                                <div>
                                    <span class="block font-black text-gold-dark text-lg">{{ $h->jour }}</span>
                                    @if($h->type_culte)<span class="text-slate-500 text-sm">{{ $h->type_culte }}</span>@endif
                                </div>
                                <span class="text-xl font-black text-slate-900 group-hover:text-gold-dark transition-colors">{{ $h->heure }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('contact') }}" class="gold-gradient text-white w-full text-center mt-8 py-3.5 rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-gold/30 hover:shadow-gold/50 hover:-translate-y-0.5 transition-all">
                            <i class="fas fa-map-marker-alt text-sm"></i> Rejoignez-nous ce Dimanche
                        </a>
                    </div>
                </div>
            </div> --}}


{{-- ══════════════════════════════════
     CULTES / LIVE
══════════════════════════════════ --}}
<section class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14 reveal">
            <span class="text-gold-dark font-black tracking-widest uppercase text-xs">Retransmissions</span>
            <h2 class="font-serif font-black text-slate-900 mt-3 mb-4" style="font-size:clamp(1.8rem,3vw,2.5rem)">Cultes à Venir & Replays</h2>
            <div class="w-14 h-0.5 gold-gradient mx-auto rounded-full"></div>
            <p class="text-slate-500 mt-4 max-w-lg mx-auto text-sm leading-relaxed">Participez en présentiel ou suivez nos cultes en direct depuis chez vous.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">
            @forelse($prochainsCultes as $culte)
            <article class="bg-white rounded-3xl overflow-hidden border border-slate-100 card-hover card-hover-gold group">
                <div class="relative aspect-video img-zoom">
                    <img src="{{ $culte->image ? asset('storage/'.$culte->image) : asset('images/default-culte.jpg') }}" alt="{{ $culte->titre }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/60 via-transparent to-transparent"></div>
                    @if($culte->est_live)
                        <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-black px-3 py-1 rounded-full flex items-center gap-1.5">
                            <span class="live-dot w-1.5 h-1.5"></span> LIVE
                        </span>
                    @elseif($culte->est_a_venir)
                        <span class="absolute top-3 left-3 gold-gradient text-white text-xs font-black px-3 py-1 rounded-full">À VENIR</span>
                    @else
                        <span class="absolute top-3 left-3 bg-navy text-white text-xs font-black px-3 py-1 rounded-full">REPLAY</span>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="font-serif font-bold text-slate-900 text-lg mb-3 group-hover:text-gold-dark transition-colors leading-snug">{{ $culte->titre }}</h3>
                    <div class="flex flex-wrap gap-3 text-xs text-slate-400 mb-4">
                        <span class="flex items-center gap-1"><i class="fas fa-calendar text-gold/60"></i> {{ \Carbon\Carbon::parse($culte->date_culte)->isoFormat('D MMM YYYY') }}</span>
                        @if($culte->heure)<span class="flex items-center gap-1"><i class="fas fa-clock text-gold/60"></i> {{ $culte->heure }}</span>@endif
                        @if($culte->predicateur)<span class="flex items-center gap-1"><i class="fas fa-user text-gold/60"></i> {{ $culte->predicateur }}</span>@endif
                    </div>
                    @if($culte->description)
                    <p class="text-sm text-slate-500 leading-relaxed mb-5">{{ Str::limit($culte->description, 90) }}</p>
                    @endif
                    @if($culte->est_live || $culte->lien_video)
                    <a href="{{ route('cultes.show', $culte->slug) }}" class="inline-flex items-center gap-2 bg-navy text-white text-sm font-bold px-5 py-2.5 rounded-xl hover:bg-gold-dark transition-colors">
                        <i class="fas fa-{{ $culte->est_live ? 'satellite-dish' : 'play' }} text-xs"></i>
                        {{ $culte->est_live ? 'Rejoindre le Live' : 'Voir le Replay' }}
                    </a>
                    @endif
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-16 text-slate-400">
                <i class="fas fa-church text-5xl mb-4 block text-slate-200"></i>
                <p>Aucun culte planifié pour le moment.</p>
            </div>
            @endforelse
        </div>

        <div class="text-center mt-10 reveal">
            <a href="{{ route('cultes.index') }}" class="inline-flex items-center gap-2 gold-gradient text-white px-7 py-3.5 rounded-xl font-bold shadow-lg shadow-gold/30 hover:-translate-y-0.5 transition-all">
                Tous les Cultes <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════
     ACTUALITÉS
══════════════════════════════════ --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-14">
            <div class="reveal">
                <span class="text-gold-dark font-black tracking-widest uppercase text-xs">Publications</span>
                <h2 class="font-serif font-black text-slate-900 mt-3" style="font-size:clamp(1.8rem,3vw,2.5rem)">Actualités de l'Église</h2>
            </div>
            <a href="{{ route('actualites.index') }}" class="text-sm font-black text-gold-dark hover:underline mt-4 md:mt-0 flex items-center gap-1">
                Toutes les actualités <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($dernieresActualites as $actu)
            <article class="group flex flex-col rounded-3xl overflow-hidden border border-slate-100 card-hover bg-white">
                <div class="aspect-[4/3] img-zoom">
                    <img src="{{ $actu->image ? asset('storage/'.$actu->image) : asset('images/default-news.jpg') }}" alt="{{ $actu->titre }}" class="w-full h-full object-cover">
                </div>
                <div class="p-7 flex flex-col flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs font-black text-gold-dark uppercase tracking-wider">{{ $actu->categorie?->nom ?? 'Général' }}</span>
                        <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                        <span class="text-xs text-slate-400">{{ $actu->created_at->isoFormat('D MMM YYYY') }}</span>
                    </div>
                    <h3 class="font-serif font-bold text-slate-900 text-xl leading-snug mb-3 group-hover:text-gold-dark transition-colors">
                        <a href="{{ route('actualites.show', $actu->slug) }}">{{ $actu->titre }}</a>
                    </h3>
                    <p class="text-sm text-slate-500 leading-relaxed flex-1 mb-5">{{ Str::limit(strip_tags($actu->extrait ?? $actu->contenu), 120) }}</p>
                    <a href="{{ route('actualites.show', $actu->slug) }}" class="inline-flex items-center gap-1.5 text-sm font-black text-slate-900 group-hover:text-gold-dark group-hover:gap-3 transition-all">
                        Lire la suite <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════
     ÉPHÉSIENS — CITATION
══════════════════════════════════ --}}
{{-- <section class="navy-gradient py-24 text-white text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <svg class="w-14 h-14 text-gold/40 mx-auto mb-8" fill="currentColor" viewBox="0 0 24 24">
            <path d="M14.017 21V18c0-1.1.9-2 2-2h3c.55 0 1-.45 1-1V9c0-.55-.45-1-1-1h-3c-1.1 0-2-.9-2-2V3h-3v18h3zm-11 0h3V18c0-1.1.9-2 2-2h3c.55 0 1-.45 1-1V9c0-.55-.45-1-1-1H8c-1.1 0-2-.9-2-2V3H3v18z"/>
        </svg>
        <blockquote class="font-serif font-light italic text-2xl md:text-4xl leading-tight mb-8 reveal">
            "pour le perfectionnement des saints en vue de l'œuvre du ministère et de l'édification du corps de Christ,"
        </blockquote>
        <div class="text-gold font-black text-sm uppercase tracking-widest">— Éphésiens 4:12</div>
    </div>
</section> --}}

{{-- ══════════════════════════════════
     AGENDA + HORAIRES
══════════════════════════════════ --}}
<section class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14 reveal">
            <span class="text-gold-dark font-black tracking-widest uppercase text-xs">Agenda</span>
            <h2 class="font-serif font-black text-slate-900 mt-3" style="font-size:clamp(1.8rem,3vw,2.5rem)">Prochains Événements</h2>
            <div class="w-14 h-0.5 gold-gradient mx-auto rounded-full mt-4"></div>
        </div>

        <div class="grid lg:grid-cols-5 gap-10">
            {{-- Événements --}}
            <div class="lg:col-span-3 space-y-4">
                @forelse($evenements as $evt)
                <div class="bg-white rounded-2xl p-5 flex gap-4 items-start border-l-4 border-gold card-hover">
                    <div class="flex-shrink-0 w-14 text-center bg-navy rounded-xl py-2 px-1">
                        <div class="font-serif font-bold text-gold text-2xl leading-none">{{ \Carbon\Carbon::parse($evt->date_debut)->format('d') }}</div>
                        <div class="text-white/60 text-[10px] uppercase mt-0.5">{{ \Carbon\Carbon::parse($evt->date_debut)->isoFormat('MMM') }}</div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-slate-900 mb-1 truncate">{{ $evt->titre }}</h4>
                        <p class="text-xs text-slate-400 flex gap-3">
                            @if($evt->heure)<span><i class="fas fa-clock text-gold/60 mr-1"></i>{{ $evt->heure }}</span>@endif
                            <span><i class="fas fa-map-marker-alt text-gold/60 mr-1"></i>{{ $evt->lieu ?? 'Église principale' }}</span>
                        </p>
                        @if($evt->type)<span class="inline-block mt-2 text-[10px] font-black uppercase tracking-wider bg-gold/10 text-gold-dark px-2.5 py-0.5 rounded-full">{{ $evt->type }}</span>@endif
                    </div>
                </div>
                @empty
                <div class="text-center py-12 text-slate-400 bg-white rounded-2xl">
                    <i class="fas fa-calendar-times text-4xl mb-3 block text-slate-200"></i>
                    Aucun événement à venir
                </div>
                @endforelse
            </div>

            {{-- Horaires --}}
            <div class="lg:col-span-2 reveal">
                <div class="bg-gold/5 border border-gold/20 rounded-3xl p-8 h-full">
                    <h3 class="font-serif font-black text-slate-900 text-xl mb-2">Horaires des Cultes</h3>
                    <p class="text-sm text-slate-500 mb-7 leading-relaxed">Rejoignez-nous chaque semaine pour adorer Dieu ensemble.</p>
                    @foreach(\App\Models\HoraireCulte::actif()->orderBy('ordre')->get() as $h)
                    <div class="flex justify-between items-center py-3.5 border-b border-gold/15 last:border-b-0">
                        <div>
                            <span class="font-bold text-slate-900 text-sm">{{ $h->jour }}</span>
                            @if($h->type_culte)<span class="text-xs text-slate-400 ml-2">{{ $h->type_culte }}</span>@endif
                        </div>
                        <span class="text-gold-dark font-black text-sm">{{ $h->heure }}</span>
                    </div>
                    @endforeach
                    <a href="{{ route('contact') }}" class="gold-gradient text-white flex items-center justify-center gap-2 mt-7 py-3 rounded-xl text-sm font-bold shadow-lg shadow-gold/25 hover:-translate-y-0.5 transition-all">
                        <i class="fas fa-map-marker-alt text-xs"></i> Nous trouver
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════
     MISSIONS
══════════════════════════════════ --}}
@if($missions->count() > 0)
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14 reveal">
            <span class="text-gold-dark font-black tracking-widest uppercase text-xs">Évangélisation</span>
            <h2 class="font-serif font-black text-slate-900 mt-3 mb-4" style="font-size:clamp(1.8rem,3vw,2.5rem)">Nos Missions</h2>
            <div class="w-14 h-0.5 gold-gradient mx-auto rounded-full"></div>
            <p class="text-slate-500 mt-4 max-w-lg mx-auto text-sm leading-relaxed">Engagés pour l'avancement de l'Évangile dans le monde.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">
            @foreach($missions as $mission)
            <a href="{{ route('missions.show', $mission->slug) }}" class="relative block rounded-3xl overflow-hidden h-80 group card-hover">
                <img src="{{ $mission->image ? asset('storage/'.$mission->image) : asset('images/default-mission.jpg') }}" alt="{{ $mission->nom }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-106">
                <div class="absolute inset-0 bg-gradient-to-t from-navy/95 via-navy/40 to-transparent"></div>
                <div class="absolute inset-0 p-7 flex flex-col justify-end">
                    <div class="text-gold text-xs font-black uppercase tracking-wider mb-2">
                        <i class="fas fa-map-marker-alt mr-1"></i> {{ $mission->pays ?? $mission->region }}
                    </div>
                    <h3 class="font-serif font-bold text-white text-xl mb-2 leading-snug">{{ $mission->nom }}</h3>
                    <p class="text-white/65 text-sm leading-relaxed mb-4">{{ Str::limit($mission->description, 85) }}</p>
                    @if($mission->objectif_don > 0)
                    <div>
                        <div class="h-1 bg-white/20 rounded-full overflow-hidden mb-1.5">
                            <div class="h-full gold-gradient rounded-full progress-bar" data-width="{{ min(100, round($mission->dons_recus / $mission->objectif_don * 100)) }}" style="width:0"></div>
                        </div>
                        <div class="flex justify-between text-white/55 text-[10px]">
                            <span>{{ number_format($mission->dons_recus) }} FCFA</span>
                            <span>{{ round($mission->dons_recus / $mission->objectif_don * 100) }}%</span>
                        </div>
                    </div>
                    @endif
                </div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-10 reveal">
            <a href="{{ route('missions.index') }}" class="inline-flex items-center gap-2 gold-gradient text-white px-7 py-3.5 rounded-xl font-bold shadow-lg shadow-gold/30 hover:-translate-y-0.5 transition-all">
                Toutes les Missions <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════
     DIRIGEANTS — CAROUSEL
══════════════════════════════════ --}}
@if(isset($dirigeants) && $dirigeants->count() > 0)
<section class="py-24 bg-slate-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16 reveal">
            <span class="text-gold-dark font-black tracking-widest uppercase text-xs">Leadership</span>
            <h2 class="font-serif font-black text-slate-900 mt-3" style="font-size:clamp(1.8rem,3vw,2.5rem)">Nos Dirigeants</h2>
            <div class="w-14 h-0.5 gold-gradient mx-auto rounded-full mt-4"></div>
        </div>

        <div class="max-w-4xl mx-auto">
            <div id="leaderCarousel" class="overflow-hidden" style="min-height:340px">
                @foreach($dirigeants as $i => $leader)
                <div data-carousel-item class="w-full">
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-100 p-8 md:p-12 flex flex-col md:flex-row items-center gap-10">
                        <div class="relative flex-shrink-0 w-48 h-48 md:w-56 md:h-56">
                            <div class="absolute inset-0 gold-gradient rounded-3xl rotate-6 scale-105 opacity-15"></div>
                            <img src="{{ $leader->photo ? asset('storage/'.$leader->photo) : asset('images/default-membre.jpg') }}" alt="{{ $leader->prenom }} {{ $leader->nom }}"
                                 class="relative z-10 w-full h-full object-cover rounded-3xl shadow-xl">
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h3 class="font-serif font-black text-slate-900 text-2xl md:text-3xl mb-1">{{ $leader->prenom }} {{ $leader->nom }}</h3>
                            <p class="text-gold-dark font-black text-sm uppercase tracking-widest mb-6">{{ $leader->role }}</p>
                            <div class="relative">
                                <svg class="absolute -top-4 -left-4 w-10 h-10 text-gold/15" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21V18c0-1.1.9-2 2-2h3c.55 0 1-.45 1-1V9c0-.55-.45-1-1-1h-3c-1.1 0-2-.9-2-2V3h-3v18h3zm-11 0h3V18c0-1.1.9-2 2-2h3c.55 0 1-.45 1-1V9c0-.55-.45-1-1-1H8c-1.1 0-2-.9-2-2V3H3v18z"/></svg>
                                <p class="text-slate-600 italic leading-relaxed text-lg relative z-10">
                                    "{{ $leader->citation ?? 'Notre mission est d\'étendre le Royaume de Dieu par la proclamation de l\'Évangile.' }}"
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Controls --}}
            <div class="flex items-center justify-center gap-4 mt-8">
                <button id="carouselPrev" class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:text-gold-dark hover:border-gold/40 transition-all">
                    <i class="fas fa-chevron-left text-sm"></i>
                </button>
                <div id="carouselDots" class="flex items-center gap-2"></div>
                <button id="carouselNext" class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:text-gold-dark hover:border-gold/40 transition-all">
                    <i class="fas fa-chevron-right text-sm"></i>
                </button>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ══════════════════════════════════
     DON — CTA
══════════════════════════════════ --}}
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 navy-gradient"></div>
    <div class="absolute inset-0" style="background-image:radial-gradient(circle, rgba(232,176,75,.06) 1px, transparent 1px); background-size:36px 36px;"></div>
    <div class="relative z-10 max-w-3xl mx-auto px-6 text-center">
        <div class="w-16 h-16 gold-gradient rounded-2xl flex items-center justify-center mx-auto mb-7 shadow-xl shadow-gold/30 animate-pulse-gold">
            <i class="fas fa-heart text-white text-xl"></i>
        </div>
        <span class="text-gold font-black text-xs uppercase tracking-widest">Soutien financier</span>
        <h2 class="font-serif font-black text-white mt-3 mb-5 text-3xl md:text-4xl leading-tight">Soutenez l'Œuvre de Dieu</h2>
        <p class="text-white/65 leading-relaxed mb-10 max-w-lg mx-auto">
            Vos dons permettent de financer les missions, soutenir les familles dans le besoin et faire avancer l'Évangile dans le monde.
        </p>
        <a href="{{ route('don') }}" class="gold-gradient text-white inline-flex items-center gap-3 px-9 py-4 rounded-xl font-bold text-lg shadow-xl shadow-gold/30 hover:shadow-gold/50 hover:-translate-y-1 transition-all">
            <i class="fas fa-heart"></i> Faire un Don
        </a>
    </div>
</section>

@endsection
