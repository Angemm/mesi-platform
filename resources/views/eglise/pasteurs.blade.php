@extends('layouts.app')
@section('title', "Nos Pasteurs — M.E.SI")

@section('content')

<section class="py-16 text-center relative overflow-hidden" style="background:linear-gradient(135deg,#2D6A27 0%,#1C3A18 100%);">
    <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(232,160,32,.07) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="relative z-10 max-w-2xl mx-auto px-6">
        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest mb-5" style="background:rgba(232,160,32,.15);color:#E8A020;">Leadership</span>
        <h1 class="font-serif font-black text-white mb-4" style="font-size:clamp(2rem,4vw,3rem);">Nos <span style="color:#E8A020;">Pasteurs</span></h1>
        <p class="text-white/65">Des bergers au cœur de serviteur, guidés par la Parole de Dieu.</p>
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

{{-- COUPLE PASTORAL PRINCIPAL --}}
@if(isset($pasteurPrincipal))
<section class="py-20 bg-white">
    <div class="max-w-5xl mx-auto px-6">
        <div class="bg-white rounded-3xl border border-slate-100 shadow-xl p-8 md:p-12 grid md:grid-cols-2 gap-10 items-center mb-16">
            <div class="relative">
                <div class="absolute inset-0 rounded-3xl rotate-3 scale-105 opacity-15" style="background:linear-gradient(135deg,#4A8C3F,#2D6A27);"></div>
                <img src="{{ $pasteurPrincipal->photo ? asset('storage/'.$pasteurPrincipal->photo) : asset('images/default-membre.jpg') }}"
                     alt="{{ $pasteurPrincipal->prenom }} {{ $pasteurPrincipal->nom }}"
                     class="relative z-10 w-full aspect-square object-cover rounded-3xl shadow-xl">
            </div>
            <div>
                <span class="text-xs font-black uppercase tracking-widest" style="color:#C47D0A;">Pasteur Principal</span>
                <h2 class="font-serif font-black text-slate-900 text-3xl mt-1 mb-1">{{ $pasteurPrincipal->prenom }} {{ $pasteurPrincipal->nom }}</h2>
                <p class="font-bold text-sm mb-4" style="color:#4A8C3F;">{{ $pasteurPrincipal->role }}</p>
                <div class="relative mb-6">
                    <svg class="absolute -top-3 -left-3 w-8 h-8 opacity-15" fill="#4A8C3F" viewBox="0 0 24 24"><path d="M14.017 21V18c0-1.1.9-2 2-2h3c.55 0 1-.45 1-1V9c0-.55-.45-1-1-1h-3c-1.1 0-2-.9-2-2V3h-3v18h3zm-11 0h3V18c0-1.1.9-2 2-2h3c.55 0 1-.45 1-1V9c0-.55-.45-1-1-1H8c-1.1 0-2-.9-2-2V3H3v18z"/></svg>
                    <p class="font-serif italic text-slate-600 leading-relaxed relative z-10 pl-4">
                        "{{ $pasteurPrincipal->citation ?? 'Ma passion est de voir chaque âme rencontrer Jésus-Christ et être transformée par Sa grâce.' }}"
                    </p>
                </div>
                @if($pasteurPrincipal->biographie)
                <p class="text-sm text-slate-500 leading-relaxed">{{ Str::limit($pasteurPrincipal->biographie, 250) }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

{{-- AUTRES PASTEURS --}}
<section class="py-16" style="background:#F8F6F2;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="font-serif font-black text-slate-900 text-2xl">L'équipe pastorale</h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($pasteurs ?? [] as $pasteur)
            <div class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm hover:shadow-lg transition-shadow">
                <div class="relative aspect-[4/3] img-zoom">
                    <img src="{{ $pasteur->photo ? asset('storage/'.$pasteur->photo) : asset('images/default-membre.jpg') }}"
                         alt="{{ $pasteur->prenom }} {{ $pasteur->nom }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0" style="background:linear-gradient(to top,rgba(28,58,24,.7),transparent 50%);"></div>
                    <div class="absolute bottom-4 left-4 right-4">
                        <h3 class="font-serif font-black text-white text-lg leading-tight">{{ $pasteur->prenom }} {{ $pasteur->nom }}</h3>
                        <p class="text-xs font-bold mt-0.5" style="color:#E8A020;">{{ $pasteur->role }}</p>
                    </div>
                </div>
                @if($pasteur->citation)
                <div class="p-5">
                    <p class="font-serif italic text-slate-600 text-sm leading-relaxed">"{{ Str::limit($pasteur->citation, 120) }}"</p>
                </div>
                @endif
            </div>
            @empty
            <div class="col-span-full text-center py-12 text-slate-400">
                <i class="fas fa-user-tie text-5xl mb-4 block text-slate-200"></i>
                <p>Informations sur l'équipe pastorale à venir.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
