@extends('layouts.app')
@section('title', "Notre Histoire — M.E.SI")

@section('content')

<section class="py-16 text-center relative overflow-hidden" style="background:linear-gradient(135deg,#2D6A27 0%,#1C3A18 100%);">
    <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(232,160,32,.07) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="relative z-10 max-w-2xl mx-auto px-6">
        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest mb-5" style="background:rgba(232,160,32,.15);color:#E8A020;">L'Église</span>
        <h1 class="font-serif font-black text-white mb-4" style="font-size:clamp(2rem,4vw,3rem);">Notre <span style="color:#E8A020;">Histoire</span></h1>
        <p class="text-white/65">Plus de trente ans de témoignage fidèle pour la gloire de Dieu.</p>
    </div>
</section>

{{-- Nav --}}
<section class="py-4 bg-white border-b border-slate-100 sticky top-[72px] z-30">
    <div class="max-w-7xl mx-auto px-6 flex gap-2 overflow-x-auto">
        @foreach([['eglise.index','Présentation'],['eglise.histoire','Notre Histoire'],['eglise.vision','Vision & Mission'],['eglise.pasteurs','Nos Pasteurs'],['eglise.departements','Départements']] as [$r,$l])
        <a href="{{ route($r) }}" class="px-4 py-2 rounded-xl text-sm font-bold whitespace-nowrap transition-all {{ request()->routeIs($r) ? 'text-white' : 'text-slate-500 hover:bg-slate-50' }}"
           style="{{ request()->routeIs($r) ? 'background:linear-gradient(135deg,#4A8C3F,#2D6A27);' : '' }}">{{ $l }}</a>
        @endforeach
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-6">

        {{-- Intro --}}
        <div class="text-center mb-16">
            <p class="font-serif italic text-xl text-slate-700 leading-relaxed">
                "Fondée sur la Parole de Dieu, portée par la foi de ses membres, M.E.SI est une histoire de grâce divine."
            </p>
        </div>

        {{-- Timeline --}}
        <div class="relative">
            {{-- Ligne verticale --}}
            <div class="absolute left-1/2 top-0 bottom-0 w-0.5 -translate-x-1/2 hidden md:block" style="background:linear-gradient(to bottom,#4A8C3F,#E8A020);"></div>

            @php
            $timeline = [
                ['1990','Fondation','La Mission Évangélique Sion est fondée à Abidjan avec une poignée de fidèles animés d\'une vision : proclamer l\'Évangile en Côte d\'Ivoire.'],
                ['1995','Premier bâtiment','L\'église acquiert son premier local permanent, permettant d\'accueillir une congrégation grandissante dans un cadre propice au culte.'],
                ['2000','Expansion','Ouverture de nouvelles cellules de maison dans plusieurs quartiers d\'Abidjan. La communauté dépasse les 200 membres.'],
                ['2005','Département Jeunesse','Création du département jeunesse qui devient un pilier essentiel de l\'église, touchant des centaines de jeunes chaque année.'],
                ['2010','Lancement des missions','Envoi des premiers missionnaires à l\'intérieur du pays et dans la sous-région ouest-africaine.'],
                ['2015','M.E.SI en ligne','Lancement des retransmissions en direct des cultes, permettant à des milliers de fidèles de participer à distance.'],
                ['2020','Nouvelle saison','Malgré les défis de la pandémie, l\'église renforce sa présence numérique et maintient sa communauté soudée.'],
                ['Aujourd\'hui','Une église vivante','M.E.SI continue de croître, de servir et d\'impacter sa communauté avec la même passion pour l\'Évangile.'],
            ];
            @endphp

            <div class="space-y-10">
                @foreach($timeline as $i => [$annee,$titre,$desc])
                <div class="relative flex {{ $i % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse' }} items-center gap-8">
                    {{-- Contenu --}}
                    <div class="flex-1 {{ $i % 2 === 0 ? 'md:text-right' : 'md:text-left' }}">
                        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                            <span class="font-serif font-black text-2xl" style="color:#E8A020;">{{ $annee }}</span>
                            <h3 class="font-bold text-slate-900 text-lg mt-1 mb-2">{{ $titre }}</h3>
                            <p class="text-sm text-slate-500 leading-relaxed">{{ $desc }}</p>
                        </div>
                    </div>
                    {{-- Point central --}}
                    <div class="hidden md:flex w-4 h-4 rounded-full flex-shrink-0 z-10 shadow-md" style="background:linear-gradient(135deg,#4A8C3F,#2D6A27);"></div>
                    {{-- Espace --}}
                    <div class="flex-1 hidden md:block"></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-16 text-center" style="background:#F8F6F2;">
    <div class="max-w-xl mx-auto px-6">
        <h2 class="font-serif font-black text-slate-900 text-2xl mb-4">Écrivez l'histoire avec nous</h2>
        <p class="text-slate-500 text-sm leading-relaxed mb-6">Rejoignez M.E.SI et participez à l'avancement de l'Évangile dans notre génération.</p>
        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl text-white font-bold"
           style="background:linear-gradient(135deg,#4A8C3F,#2D6A27);">
            <i class="fas fa-church"></i> Nous rejoindre
        </a>
    </div>
</section>

@endsection
