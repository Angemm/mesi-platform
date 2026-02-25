@extends('layouts.app')
@section('title', "Nos Départements — M.E.SI")

@section('content')

<section class="py-16 text-center relative overflow-hidden" style="background:linear-gradient(135deg,#2D6A27 0%,#1C3A18 100%);">
    <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(232,160,32,.07) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="relative z-10 max-w-2xl mx-auto px-6">
        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest mb-5" style="background:rgba(232,160,32,.15);color:#E8A020;">Ministères</span>
        <h1 class="font-serif font-black text-white mb-4" style="font-size:clamp(2rem,4vw,3rem);">Nos <span style="color:#E8A020;">Départements</span></h1>
        <p class="text-white/65">Trouvez votre place et exprimez vos dons dans l'un de nos ministères.</p>
    </div>
</section>

<section class="py-4 bg-white border-b border-slate-100 sticky top-[72px] z-30">
    <div class="max-w-7xl mx-auto px-6 flex gap-2 overflow-x-auto">
        @foreach([['eglise.index','Présentation'],['eglise.histoire','Notre Histoire'],['eglise.vision','Vision & Mission'],['eglise.pasteurs','Nos Pasteurs'],['eglise.departements','Départements']] as [$r,$l])
        <a href="{{ route($r) }}" class="px-4 py-2 rounded-xl text-sm font-bold whitespace-nowrap transition-all {{ request()->routeIs($r) ? 'text-white' : 'text-slate-500 hover:bg-slate-50' }}"
           style="{{ request()->routeIs($r) ? 'background:linear-gradient(135deg,#4A8C3F,#2D6A27);' : '' }}">{{ $l }}</a>
        @endforeach
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14">
            <p class="text-slate-600 max-w-xl mx-auto leading-relaxed">Chaque département est un ministère à part entière, avec sa propre vision et ses activités pour servir l'Église et la communauté.</p>
        </div>

        @php
        $colors = ['#2D6A27','#C47D0A','#7B4A1E','#2D6A27','#C47D0A','#7B4A1E'];
        $bgs = ['rgba(74,140,63,.08)','rgba(232,160,32,.08)','rgba(123,74,30,.08)','rgba(74,140,63,.08)','rgba(232,160,32,.08)','rgba(123,74,30,.08)'];
        $icons = ['fas fa-music','fas fa-child','fas fa-female','fas fa-male','fas fa-hands-helping','fas fa-globe'];
        @endphp

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($departements ?? [] as $i => $dept)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all p-6">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $bgs[$i % 6] }};">
                        <i class="{{ $dept->icone ?? $icons[$i % 6] }} text-xl" style="color:{{ $colors[$i % 6] }};"></i>
                    </div>
                    <div>
                        <h3 class="font-serif font-bold text-slate-900 text-lg leading-tight">{{ $dept->nom }}</h3>
                        @if($dept->responsable)
                        <p class="text-xs text-slate-400 mt-0.5">Resp. : {{ $dept->responsable }}</p>
                        @endif
                    </div>
                </div>
                @if($dept->description)
                <p class="text-sm text-slate-500 leading-relaxed mb-4">{{ Str::limit($dept->description, 130) }}</p>
                @endif
                @if($dept->membres_count ?? false)
                <div class="flex items-center gap-2 text-xs text-slate-400">
                    <i class="fas fa-users" style="color:{{ $colors[$i % 6] }};"></i>
                    <span>{{ $dept->membres_count }} membres</span>
                </div>
                @endif
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <a href="{{ route('contact') }}?dept={{ $dept->id }}" class="text-xs font-black uppercase tracking-wider flex items-center gap-1 hover:gap-2 transition-all" style="color:{{ $colors[$i % 6] }};">
                        Rejoindre ce ministère <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
            @empty
            {{-- Départements par défaut --}}
            @foreach([
                ['fas fa-music','Louange & Adoration','Diriger la congrégation dans l\'adoration à travers le chant et la musique lors des cultes.'],
                ['fas fa-child','Enfants & Jeunesse','Accompagner les enfants et adolescents dans leur découverte de la foi chrétienne.'],
                ['fas fa-female','Femmes','Encourager et équiper les femmes pour qu\'elles accomplissent leur appel divin.'],
                ['fas fa-male','Hommes','Susciter des hommes forts dans la foi, leaders dans leurs familles et dans l\'église.'],
                ['fas fa-hands-helping','Diaconie & Social','Porter l\'amour du Christ aux plus vulnérables par des actions concrètes de solidarité.'],
                ['fas fa-globe','Évangélisation','Aller au-delà des murs de l\'église pour partager la Bonne Nouvelle.'],
            ] as $j => [$icon,$titre,$desc])
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all p-6">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background:{{ $bgs[$j % 6] }};">
                    <i class="{{ $icon }} text-xl" style="color:{{ $colors[$j % 6] }};"></i>
                </div>
                <h3 class="font-serif font-bold text-slate-900 text-lg mb-2">{{ $titre }}</h3>
                <p class="text-sm text-slate-500 leading-relaxed mb-4">{{ $desc }}</p>
                <a href="{{ route('contact') }}" class="text-xs font-black uppercase tracking-wider flex items-center gap-1 hover:gap-2 transition-all" style="color:{{ $colors[$j % 6] }};">
                    Rejoindre <i class="fas fa-arrow-right text-[10px]"></i>
                </a>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 text-center" style="background:#F8F6F2;">
    <div class="max-w-xl mx-auto px-6">
        <h2 class="font-serif font-black text-slate-900 text-2xl mb-4">Vous ne savez pas par où commencer ?</h2>
        <p class="text-slate-500 text-sm leading-relaxed mb-6">Contactez-nous et nous vous aiderons à trouver le ministère qui correspond à vos dons et votre passion.</p>
        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl text-white font-bold"
           style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
            <i class="fas fa-envelope"></i> Nous contacter
        </a>
    </div>
</section>

@endsection
