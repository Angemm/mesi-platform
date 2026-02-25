@extends('layouts.app')
@section('title', 'Notre Communauté — M.E.SI')

@section('content')

{{-- HERO --}}
<section class="py-20 text-center relative overflow-hidden" style="background:linear-gradient(135deg,#2D6A27 0%,#1C3A18 100%);">
    <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(232,160,32,.07) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="relative z-10 max-w-3xl mx-auto px-6">
        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest mb-5" style="background:rgba(232,160,32,.15);color:#E8A020;">Famille</span>
        <h1 class="font-serif font-black text-white mb-4" style="font-size:clamp(2rem,4vw,3rem);">Notre <span style="color:#E8A020;">Communauté</span></h1>
        <p class="text-white/65 leading-relaxed">Nous sommes une famille unie dans l'amour du Christ, prête à vous accueillir.</p>
    </div>
</section>

{{-- STATS --}}
<section class="py-10 bg-white border-b border-slate-100">
    <div class="max-w-5xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
        @foreach([
            ['fas fa-users','#4A8C3F',$stats['membres'] ?? 0,'+','Membres'],
            ['fas fa-layer-group','#C47D0A',$stats['departements'] ?? 0,'','Départements'],
            ['fas fa-hands-helping','#2D6A27',$stats['missions'] ?? 0,'','Missions'],
            ['fas fa-calendar-check','#7B4A1E',$stats['annees'] ?? 0,'','Ans d\'histoire'],
        ] as [$icon,$color,$val,$suffix,$label])
        <div class="p-4">
            <i class="{{ $icon }} text-2xl mb-2 block" style="color:{{ $color }};"></i>
            <div class="font-serif font-black text-3xl text-slate-900">{{ $val }}{{ $suffix }}</div>
            <div class="text-xs text-slate-400 uppercase tracking-wider mt-1">{{ $label }}</div>
        </div>
        @endforeach
    </div>
</section>

{{-- FILTRES --}}
<section class="py-6 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-6">
        <form method="GET" action="{{ route('membres.index') }}" class="flex flex-wrap gap-3 items-center">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un membre…"
                   class="flex-1 min-w-48 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none">
            @if(isset($departements) && $departements->count())
            <select name="departement" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none">
                <option value="">Tous les départements</option>
                @foreach($departements as $d)
                <option value="{{ $d->id }}" {{ request('departement') == $d->id ? 'selected' : '' }}>{{ $d->nom }}</option>
                @endforeach
            </select>
            @endif
            <button type="submit" class="px-5 py-2.5 rounded-xl text-white text-sm font-bold" style="background:linear-gradient(135deg,#4A8C3F,#2D6A27);">
                <i class="fas fa-search mr-1"></i> Filtrer
            </button>
        </form>
    </div>
</section>

{{-- MEMBRES --}}
<section class="py-14" style="background:#F8F6F2;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($membres as $membre)
            <div class="bg-white rounded-2xl overflow-hidden border border-slate-100 card-hover text-center p-6">
                <div class="relative w-20 h-20 mx-auto mb-4">
                    <div class="absolute inset-0 rounded-full rotate-6 scale-110 opacity-20" style="background:linear-gradient(135deg,#4A8C3F,#2D6A27);"></div>
                    <img src="{{ $membre->photo ? asset('storage/'.$membre->photo) : asset('images/default-membre.jpg') }}"
                         alt="{{ $membre->prenom }} {{ $membre->nom }}"
                         class="relative z-10 w-full h-full object-cover rounded-full shadow-lg">
                </div>
                <h3 class="font-bold text-slate-900 text-sm">{{ $membre->prenom }} {{ $membre->nom }}</h3>
                @if($membre->role_eglise)
                <p class="text-xs font-bold mt-1" style="color:#C47D0A;">{{ $membre->role_eglise }}</p>
                @endif
                @if($membre->departement)
                <p class="text-[10px] text-slate-400 mt-1">{{ $membre->departement->nom }}</p>
                @endif
            </div>
            @empty
            <div class="col-span-full text-center py-16 text-slate-400 bg-white rounded-2xl">
                <i class="fas fa-users text-5xl mb-4 block text-slate-200"></i>
                <p>Aucun membre affiché pour le moment.</p>
            </div>
            @endforelse
        </div>

        @if(isset($membres) && $membres->hasPages())
        <div class="mt-10 flex justify-center">{{ $membres->links() }}</div>
        @endif
    </div>
</section>

{{-- CTA Rejoindre --}}
<section class="py-20 bg-white text-center">
    <div class="max-w-2xl mx-auto px-6">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6" style="background:rgba(74,140,63,.1);">
            <i class="fas fa-hands-holding-heart text-2xl" style="color:#2D6A27;"></i>
        </div>
        <h2 class="font-serif font-black text-slate-900 text-3xl mb-4">Rejoignez la famille</h2>
        <p class="text-slate-500 leading-relaxed mb-8">Venez vivre l'expérience de la communauté chrétienne. Nos portes sont ouvertes à tous.</p>
        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl text-white font-bold shadow-lg"
           style="background:linear-gradient(135deg,#4A8C3F,#2D6A27);box-shadow:0 8px 24px rgba(74,140,63,.3);">
            <i class="fas fa-church"></i> Nous rejoindre
        </a>
    </div>
</section>

@endsection
