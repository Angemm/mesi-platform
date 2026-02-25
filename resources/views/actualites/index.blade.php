@extends('layouts.app')
@section('title','Actualités — M.E.SI')

@section('content')

<div class="navy-gradient py-20 text-center relative overflow-hidden">
    <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(232,176,75,.07) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="relative z-10">
        <span class="text-gold font-black text-xs uppercase tracking-widest">Publications</span>
        <h1 class="font-serif font-black text-white mt-3" style="font-size:clamp(2rem,4vw,3rem)">Actualités de l'Église</h1>
    </div>
</div>

<section class="py-16 bg-slate-50">
<div class="max-w-7xl mx-auto px-6">

    {{-- Article en vedette --}}
    @if($enVedette)
    <div class="mb-14 reveal">
        <a href="{{ route('actualites.show', $enVedette->slug) }}" class="group grid lg:grid-cols-2 bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm card-hover">
            <div class="aspect-video lg:aspect-auto img-zoom">
                <img src="{{ $enVedette->image ? asset('storage/'.$enVedette->image) : asset('images/default-news.jpg') }}" alt="{{ $enVedette->titre }}" class="w-full h-full object-cover">
            </div>
            <div class="p-10 flex flex-col justify-center">
                <div class="flex items-center gap-2 mb-4">
                    <span class="gold-gradient text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider">★ En Vedette</span>
                    @if($enVedette->categorie)<span class="text-gold-dark text-xs font-black uppercase tracking-wider">{{ $enVedette->categorie->nom }}</span>@endif
                </div>
                <h2 class="font-serif font-black text-slate-900 text-2xl md:text-3xl leading-tight mb-4 group-hover:text-gold-dark transition-colors">{{ $enVedette->titre }}</h2>
                <p class="text-slate-500 leading-relaxed mb-6">{{ Str::limit(strip_tags($enVedette->extrait ?? $enVedette->contenu), 180) }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-400"><i class="fas fa-calendar mr-1.5 text-gold/60"></i>{{ $enVedette->created_at->isoFormat('D MMMM YYYY') }}</span>
                    <span class="inline-flex items-center gap-1.5 text-sm font-black text-gold-dark group-hover:gap-3 transition-all">
                        Lire <i class="fas fa-arrow-right text-xs"></i>
                    </span>
                </div>
            </div>
        </a>
    </div>
    @endif

    {{-- Filtres catégories --}}
    <div class="flex gap-2.5 flex-wrap mb-10">
        <a href="{{ route('actualites.index') }}" class="px-4 py-2 rounded-full text-sm font-bold transition-all {{ !request('categorie') ? 'gold-gradient text-white shadow-md shadow-gold/25' : 'bg-white text-slate-600 border border-slate-200 hover:border-gold/40 hover:text-gold-dark' }}">
            Toutes
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('actualites.index', ['categorie' => $cat->slug]) }}"
           class="px-4 py-2 rounded-full text-sm font-bold transition-all {{ request('categorie') === $cat->slug ? 'gold-gradient text-white shadow-md shadow-gold/25' : 'bg-white text-slate-600 border border-slate-200 hover:border-gold/40 hover:text-gold-dark' }}">
            {{ $cat->nom }} <span class="text-[10px] opacity-60">({{ $cat->actualites_count }})</span>
        </a>
        @endforeach
    </div>

    {{-- Grille --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-7">
        @forelse($actualites as $actu)
        <article class="group flex flex-col bg-white rounded-3xl overflow-hidden border border-slate-100 card-hover shadow-sm">
            <div class="aspect-[4/3] img-zoom">
                <img src="{{ $actu->image ? asset('storage/'.$actu->image) : asset('images/default-news.jpg') }}" alt="{{ $actu->titre }}" class="w-full h-full object-cover">
            </div>
            <div class="p-7 flex flex-col flex-1">
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs font-black text-gold-dark uppercase tracking-wider">{{ $actu->categorie?->nom ?? 'Général' }}</span>
                    <span class="w-1 h-1 rounded-full bg-slate-200"></span>
                    <span class="text-xs text-slate-400">{{ $actu->created_at->isoFormat('D MMM YYYY') }}</span>
                </div>
                <h3 class="font-serif font-bold text-slate-900 text-xl leading-snug mb-3 group-hover:text-gold-dark transition-colors flex-1">
                    <a href="{{ route('actualites.show', $actu->slug) }}">{{ $actu->titre }}</a>
                </h3>
                <p class="text-sm text-slate-500 leading-relaxed mb-5 line-clamp-3">{{ Str::limit(strip_tags($actu->extrait ?? $actu->contenu), 120) }}</p>
                <a href="{{ route('actualites.show', $actu->slug) }}" class="mt-auto inline-flex items-center gap-1.5 text-sm font-black text-slate-900 group-hover:text-gold-dark group-hover:gap-3 transition-all pt-4 border-t border-slate-100">
                    Lire la suite <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </article>
        @empty
        <div class="col-span-full text-center py-20 text-slate-400">
            <i class="fas fa-newspaper text-5xl mb-4 block text-slate-200"></i>
            <p>Aucune actualité publiée pour le moment.</p>
        </div>
        @endforelse
    </div>

    <div class="flex justify-center gap-2 mt-12">
        {{ $actualites->links('vendor.pagination.custom') }}
    </div>
</div>
</section>
@endsection
