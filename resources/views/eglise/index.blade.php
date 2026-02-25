@extends('layouts.app')
@section('title', "L'Église — M.E.SI")

@section('content')

{{-- HERO --}}
<section class="py-24 relative overflow-hidden" style="background:linear-gradient(135deg,#2D6A27 0%,#1C3A18 100%);">
    <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(232,160,32,.07) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
        <div>
            <span class="inline-block px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest mb-6" style="background:rgba(232,160,32,.15);color:#E8A020;">Qui sommes-nous</span>
            <h1 class="font-serif font-black text-white leading-tight mb-6" style="font-size:clamp(2rem,4vw,3.2rem);">
                Mission Évangélique<br><span style="color:#E8A020;">Sion</span>
            </h1>
            <p class="text-white/70 leading-relaxed text-lg mb-8">Une église vivante, enracinée dans la Parole de Dieu, engagée pour le Royaume de Christ en Côte d'Ivoire et dans le monde.</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('eglise.histoire') }}" class="px-6 py-3 rounded-xl font-bold text-white text-sm border border-white/30 hover:bg-white/10 transition-all">
                    Notre histoire <i class="fas fa-arrow-right ml-2"></i>
                </a>
                <a href="{{ route('eglise.pasteurs') }}" class="px-6 py-3 rounded-xl font-bold text-white text-sm" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
                    Nos pasteurs <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        <div class="relative hidden lg:block">
            <div class="rounded-3xl overflow-hidden shadow-2xl aspect-[4/3]">
                <img src="{{ asset('images/eglise-hero.jpg') }}" alt="Église M.E.SI" class="w-full h-full object-cover" onerror="this.src='{{ asset('images/default-culte.jpg') }}'">
                <div class="absolute inset-0" style="background:rgba(28,58,24,.2);"></div>
            </div>
            <div class="absolute -bottom-5 -left-5 bg-white rounded-2xl shadow-xl p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(74,140,63,.12);">
                    <i class="fas fa-church" style="color:#2D6A27;"></i>
                </div>
                <div>
                    <p class="font-black text-slate-900 text-sm">Fondée en 1990</p>
                    <p class="text-xs text-slate-400">Plus de 30 ans de ministère</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- NAVIGATION SECTIONS --}}
<section class="py-6 bg-white border-b border-slate-100 sticky top-[72px] z-30">
    <div class="max-w-7xl mx-auto px-6 flex gap-2 overflow-x-auto">
        @foreach([
            ['eglise.index','Présentation'],
            ['eglise.histoire','Notre Histoire'],
            ['eglise.vision','Vision & Mission'],
            ['eglise.pasteurs','Nos Pasteurs'],
            ['eglise.departements','Départements'],
        ] as [$r,$l])
        <a href="{{ route($r) }}" class="px-4 py-2 rounded-xl text-sm font-bold whitespace-nowrap transition-all {{ request()->routeIs($r) ? 'text-white' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}"
           style="{{ request()->routeIs($r) ? 'background:linear-gradient(135deg,#4A8C3F,#2D6A27);' : '' }}">{{ $l }}</a>
        @endforeach
    </div>
</section>

{{-- VALEURS --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-14">
            <span class="text-xs font-black uppercase tracking-widest" style="color:#C47D0A;">Nos fondements</span>
            <h2 class="font-serif font-black text-slate-900 mt-3" style="font-size:clamp(1.8rem,3vw,2.5rem);">Ce en quoi nous croyons</h2>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach([
                ['fas fa-bible','#2D6A27','rgba(74,140,63,.08)','La Parole de Dieu','Nous croyons que la Bible est la Parole inspirée de Dieu, authorité suprême pour notre foi et notre vie.'],
                ['fas fa-praying-hands','#C47D0A','rgba(232,160,32,.08)','La Prière','La prière est au cœur de notre vie communautaire. Nous croyons en la puissance de la prière intercessive.'],
                ['fas fa-globe','#7B4A1E','rgba(123,74,30,.08)','L\'Évangélisation','Nous sommes appelés à proclamer l\'Évangile de Jésus-Christ à toutes les nations.'],
                ['fas fa-users','#2D6A27','rgba(74,140,63,.08)','La Fraternité','L\'amour fraternel est notre marque distinctive. Nous nous soutenons mutuellement dans la foi.'],
                ['fas fa-hands-helping','#C47D0A','rgba(232,160,32,.08)','Le Service','Nous sommes serviteurs les uns des autres et de notre communauté, à l\'image du Christ.'],
                ['fas fa-dove','#7B4A1E','rgba(123,74,30,.08)','Le Saint-Esprit','Nous croyons en l\'œuvre du Saint-Esprit qui guide, transforme et équipe l\'Église.'],
            ] as [$icon,$color,$bg,$titre,$desc])
            <div class="p-6 rounded-2xl border border-slate-100 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background:{{ $bg }};">
                    <i class="{{ $icon }} text-xl" style="color:{{ $color }};"></i>
                </div>
                <h3 class="font-serif font-bold text-slate-900 text-lg mb-2">{{ $titre }}</h3>
                <p class="text-sm text-slate-500 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CHIFFRES --}}
<section class="py-16" style="background:linear-gradient(135deg,#2D6A27,#1C3A18);">
    <div class="max-w-5xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        @foreach([[$stats['membres'] ?? 0,'+','Membres'],[$stats['cultes'] ?? 0,'+','Cultes diffusés'],[$stats['missions'] ?? 0,'','Missions actives'],[$stats['annees'] ?? 30,'','Ans d\'histoire']] as [$v,$s,$l])
        <div>
            <div class="font-serif font-black text-4xl mb-1" style="color:#E8A020;">{{ $v }}{{ $s }}</div>
            <div class="text-white/60 text-xs uppercase tracking-widest">{{ $l }}</div>
        </div>
        @endforeach
    </div>
</section>

{{-- LIENS SECTIONS --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach([
                ['eglise.histoire','fas fa-history','Notre Histoire','Découvrez les origines et le parcours de M.E.SI.','#2D6A27','rgba(74,140,63,.08)'],
                ['eglise.vision','fas fa-eye','Vision & Mission','Notre raison d\'être et nos objectifs pour le Royaume.','#C47D0A','rgba(232,160,32,.08)'],
                ['eglise.pasteurs','fas fa-user-tie','Nos Pasteurs','Rencontrez les leaders qui guident notre communauté.','#7B4A1E','rgba(123,74,30,.08)'],
                ['eglise.departements','fas fa-layer-group','Départements','Trouvez votre place dans nos différents ministères.','#2D6A27','rgba(74,140,63,.08)'],
            ] as [$r,$icon,$titre,$desc,$color,$bg])
            <a href="{{ route($r) }}" class="block p-6 rounded-2xl border border-slate-100 hover:shadow-lg hover:-translate-y-1 transition-all group">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background:{{ $bg }};">
                    <i class="{{ $icon }} text-xl" style="color:{{ $color }};"></i>
                </div>
                <h3 class="font-bold text-slate-900 mb-2 group-hover:transition-colors" onmouseover="this.style.color='{{ $color }}'" onmouseout="this.style.color=''">{{ $titre }}</h3>
                <p class="text-sm text-slate-500 leading-relaxed">{{ $desc }}</p>
                <span class="inline-flex items-center gap-1 text-xs font-bold mt-3" style="color:{{ $color }};">En savoir plus <i class="fas fa-arrow-right text-[10px]"></i></span>
            </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
