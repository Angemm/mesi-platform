@extends('layouts.app')
@section('title', 'Missions — M.E.SI')

@section('content')

<div class="navy-gradient py-20 text-center relative overflow-hidden">
    <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(232,176,75,.07) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="relative z-10">
        <span class="text-gold font-black text-xs uppercase tracking-widest">Évangélisation</span>
        <h1 class="font-serif font-black text-white mt-3 mb-3" style="font-size:clamp(2rem,4vw,3rem)">Nos Missions</h1>
        <p class="text-white/65 max-w-lg mx-auto text-sm leading-relaxed">Engagés pour l'avancement de l'Évangile au-delà de nos frontières.</p>
    </div>
</div>

<section class="py-20 bg-slate-50">
<div class="max-w-7xl mx-auto px-6">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">
        @forelse($missions as $mission)
        <a href="{{ route('missions.show', $mission->slug) }}" class="relative block rounded-3xl overflow-hidden h-96 group card-hover shadow-sm">
            <img src="{{ $mission->image ? asset('storage/'.$mission->image) : asset('images/default-mission.jpg') }}" alt="{{ $mission->nom }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.06]">
            <div class="absolute inset-0 bg-gradient-to-t from-navy/95 via-navy/40 to-transparent"></div>
            <div class="absolute inset-0 p-7 flex flex-col justify-end">
                <div class="text-gold text-xs font-black uppercase tracking-wider mb-2 flex items-center gap-1.5">
                    <i class="fas fa-map-marker-alt"></i> {{ $mission->pays ?? $mission->region }}
                </div>
                <h3 class="font-serif font-bold text-white text-xl mb-2 leading-snug">{{ $mission->nom }}</h3>
                <p class="text-white/65 text-sm leading-relaxed mb-4 line-clamp-2">{{ $mission->description }}</p>
                @if($mission->objectif_don > 0)
                <div>
                    <div class="h-1.5 bg-white/20 rounded-full overflow-hidden mb-2">
                        <div class="h-full gold-gradient rounded-full progress-bar" data-width="{{ min(100, round($mission->dons_recus/$mission->objectif_don*100)) }}" style="width:0"></div>
                    </div>
                    <div class="flex justify-between text-white/55 text-[10px]">
                        <span>{{ number_format($mission->dons_recus) }} FCFA</span>
                        <span>{{ round($mission->dons_recus/$mission->objectif_don*100) }}% de l'objectif</span>
                    </div>
                </div>
                @endif
                @if($mission->responsable)
                <div class="mt-4 flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-gold/30 flex items-center justify-center text-white text-xs font-bold">{{ substr($mission->responsable,0,1) }}</div>
                    <span class="text-white/60 text-xs">{{ $mission->responsable }}</span>
                </div>
                @endif
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-20 text-slate-400">
            <i class="fas fa-globe text-5xl mb-4 block text-slate-200"></i>
            <p>Aucune mission active pour le moment.</p>
        </div>
        @endforelse
    </div>
    <div class="flex justify-center gap-2 mt-12">
        {{ $missions->links('vendor.pagination.custom') }}
    </div>
</div>
</section>

{{-- CTA Don --}}
<section class="relative py-20 overflow-hidden">
    <div class="absolute inset-0 navy-gradient"></div>
    <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(232,176,75,.06) 1px,transparent 1px);background-size:36px 36px;"></div>
    <div class="relative z-10 max-w-2xl mx-auto px-6 text-center">
        <h2 class="font-serif font-black text-white text-3xl mb-4">Soutenir une Mission</h2>
        <p class="text-white/65 mb-8 leading-relaxed">Votre don, quel que soit son montant, contribue à l'avancement de l'Évangile.</p>
        <a href="{{ route('don') }}" class="gold-gradient text-white inline-flex items-center gap-3 px-8 py-4 rounded-xl font-bold shadow-xl shadow-gold/30 hover:-translate-y-1 transition-all">
            <i class="fas fa-heart"></i> Faire un Don pour les Missions
        </a>
    </div>
</section>

@endsection
