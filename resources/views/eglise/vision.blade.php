@extends('layouts.app')
@section('title', "Vision & Mission — M.E.SI")

@section('content')

<section class="py-16 text-center relative overflow-hidden" style="background:linear-gradient(135deg,#2D6A27 0%,#1C3A18 100%);">
    <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(232,160,32,.07) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="relative z-10 max-w-2xl mx-auto px-6">
        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest mb-5" style="background:rgba(232,160,32,.15);color:#E8A020;">L'Église</span>
        <h1 class="font-serif font-black text-white mb-4" style="font-size:clamp(2rem,4vw,3rem);">Vision & <span style="color:#E8A020;">Mission</span></h1>
        <p class="text-white/65">Ce qui nous motive et nous guide au quotidien.</p>
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

{{-- Vision --}}
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-16 items-center mb-20">
            <div>
                <span class="text-xs font-black uppercase tracking-widest" style="color:#C47D0A;">Notre Vision</span>
                <h2 class="font-serif font-black text-slate-900 mt-2 mb-6 leading-tight" style="font-size:clamp(1.8rem,3vw,2.5rem);">
                    Voir des vies <span class="italic" style="color:#C47D0A;">transformées</span><br>par l'Évangile
                </h2>
                <p class="text-slate-600 leading-relaxed mb-4">
                    Notre vision est de voir chaque personne rencontrer Jésus-Christ personnellement, être transformée par Sa grâce, et devenir un agent de changement dans sa famille, sa communauté et sa nation.
                </p>
                <p class="text-slate-600 leading-relaxed">
                    Nous croyons que l'Église locale est l'espoir du monde, et que chaque croyant est appelé à accomplir l'œuvre du ministère.
                </p>
            </div>
            <div class="p-8 rounded-3xl" style="background:linear-gradient(135deg,#2D6A27,#1C3A18);">
                <i class="fas fa-quote-left text-3xl mb-4 block" style="color:rgba(232,160,32,.4);"></i>
                <p class="font-serif italic text-white text-xl leading-relaxed mb-4">
                    "Allez, faites de toutes les nations des disciples, les baptisant au nom du Père, du Fils et du Saint-Esprit,"
                </p>
                <span class="text-xs font-black uppercase tracking-widest" style="color:#E8A020;">— Matthieu 28:19</span>
            </div>
        </div>

        {{-- Mission --}}
        <div class="grid lg:grid-cols-2 gap-16 items-center mb-20">
            <div class="order-2 lg:order-1 grid grid-cols-2 gap-4">
                @foreach([
                    ['fas fa-bible','Enseigner','Transmettre fidèlement la Parole de Dieu pour édifier les croyants.'],
                    ['fas fa-globe','Évangéliser','Proclamer les Bonnes Nouvelles au-delà de nos frontières.'],
                    ['fas fa-hands-helping','Servir','Répondre aux besoins de notre prochain avec amour.'],
                    ['fas fa-users','Rassembler','Construire une communauté de foi authentique et fraternelle.'],
                ] as [$icon,$titre,$desc])
                <div class="p-5 rounded-2xl border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3" style="background:rgba(74,140,63,.1);">
                        <i class="{{ $icon }}" style="color:#2D6A27;"></i>
                    </div>
                    <h4 class="font-bold text-slate-900 text-sm mb-1">{{ $titre }}</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
            <div class="order-1 lg:order-2">
                <span class="text-xs font-black uppercase tracking-widest" style="color:#C47D0A;">Notre Mission</span>
                <h2 class="font-serif font-black text-slate-900 mt-2 mb-6 leading-tight" style="font-size:clamp(1.8rem,3vw,2.5rem);">
                    Quatre piliers fondamentaux
                </h2>
                <p class="text-slate-600 leading-relaxed">
                    Notre mission repose sur quatre piliers indissociables : enseigner, évangéliser, servir et rassembler. Ensemble, ils forment la colonne vertébrale de tout ce que nous faisons à M.E.SI.
                </p>
            </div>
        </div>

        {{-- Valeurs --}}
        <div class="text-center mb-12">
            <h2 class="font-serif font-black text-slate-900 text-2xl mb-3">Nos Valeurs fondamentales</h2>
            <div class="w-14 h-0.5 mx-auto rounded-full" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);"></div>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach([
                ['Excellence','Nous faisons tout pour la gloire de Dieu avec excellence et intégrité.','#2D6A27'],
                ['Authenticité','Nous cultivons des relations transparentes et authentiques dans notre communauté.','#C47D0A'],
                ['Compassion','Nous portons le regard du Christ sur les plus vulnérables de notre société.','#7B4A1E'],
                ['Unité','Nous célébrons la diversité tout en maintenant l\'unité dans l\'Esprit.','#2D6A27'],
                ['Foi','Nous avançons par la foi, convaincus que Dieu accomplit Sa Parole.','#C47D0A'],
                ['Transformation','Nous croyons en la puissance de l\'Évangile à changer des vies.','#7B4A1E'],
            ] as [$titre,$desc,$color])
            <div class="p-6 rounded-2xl border-l-4 bg-white shadow-sm" style="border-color:{{ $color }};">
                <h3 class="font-bold text-slate-900 mb-2 text-base" style="color:{{ $color }};">{{ $titre }}</h3>
                <p class="text-sm text-slate-500 leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
