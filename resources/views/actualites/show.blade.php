@extends('layouts.app')
@section('title', $actualite->titre . ' — M.E.SI')

@section('content')
<section class="py-14 bg-slate-50">
<div class="max-w-5xl mx-auto px-6">

    {{-- Breadcrumb --}}
    <nav class="text-xs text-slate-400 mb-8 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-gold-dark transition-colors">Accueil</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <a href="{{ route('actualites.index') }}" class="hover:text-gold-dark transition-colors">Actualités</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <span class="text-slate-600 truncate max-w-xs">{{ $actualite->titre }}</span>
    </nav>

    <div class="grid lg:grid-cols-3 gap-10">
        {{-- Article --}}
        <article class="lg:col-span-2">
            <div class="flex items-center gap-2 mb-5">
                @if($actualite->en_vedette)<span class="gold-gradient text-white text-[10px] font-black px-3 py-1 rounded-full uppercase">★ Vedette</span>@endif
                @if($actualite->categorie)<span class="text-gold-dark text-xs font-black uppercase tracking-wider">{{ $actualite->categorie->nom }}</span>@endif
            </div>
            <h1 class="font-serif font-black text-slate-900 leading-tight mb-6" style="font-size:clamp(1.7rem,3vw,2.4rem)">{{ $actualite->titre }}</h1>
            <div class="flex items-center gap-5 mb-8 text-sm text-slate-400 pb-6 border-b border-slate-200">
                <span class="flex items-center gap-1.5"><i class="fas fa-calendar text-gold/60"></i>{{ $actualite->created_at->isoFormat('D MMMM YYYY') }}</span>
                @if($actualite->auteur)<span class="flex items-center gap-1.5"><i class="fas fa-user text-gold/60"></i>{{ $actualite->auteur->name }}</span>@endif
                <span class="flex items-center gap-1.5"><i class="fas fa-eye text-gold/60"></i>{{ number_format($actualite->vues) }} vues</span>
            </div>

            @if($actualite->image)
            <div class="rounded-2xl overflow-hidden mb-8 shadow-xl shadow-slate-200">
                <img src="{{ asset('storage/'.$actualite->image) }}" alt="{{ $actualite->titre }}" class="w-full object-cover" style="max-height:480px;">
            </div>
            @endif

            <div class="prose prose-slate prose-lg max-w-none prose-headings:font-serif prose-a:text-gold-dark prose-strong:text-slate-900">
                {!! $actualite->contenu !!}
            </div>

            {{-- Partage --}}
            <div class="mt-10 pt-8 border-t border-slate-200 flex items-center gap-3">
                <span class="text-sm font-bold text-slate-600 mr-2">Partager :</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank"
                   class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center hover:scale-110 transition-transform text-sm">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://wa.me/?text={{ urlencode($actualite->titre . ' — ' . request()->url()) }}" target="_blank"
                   class="w-9 h-9 bg-green-500 text-white rounded-xl flex items-center justify-center hover:scale-110 transition-transform text-sm">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </article>

        {{-- Sidebar --}}
        <aside class="space-y-6">
            @if($similaires->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h3 class="font-serif font-bold text-slate-900 mb-5">Articles similaires</h3>
                <div class="space-y-4">
                    @foreach($similaires as $s)
                    <a href="{{ route('actualites.show', $s->slug) }}" class="group flex gap-3 items-start">
                        <div class="w-16 h-12 rounded-xl overflow-hidden flex-shrink-0 img-zoom">
                            <img src="{{ $s->image ? asset('storage/'.$s->image) : asset('images/default-news.jpg') }}" alt="{{ $s->titre }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-800 group-hover:text-gold-dark transition-colors line-clamp-2 leading-snug">{{ $s->titre }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $s->created_at->isoFormat('D MMM YYYY') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="bg-navy rounded-2xl p-6 text-center">
                <i class="fas fa-bell text-gold text-2xl mb-3"></i>
                <h4 class="font-serif font-bold text-white mb-2">Newsletter</h4>
                <p class="text-white/60 text-xs mb-4 leading-relaxed">Recevez nos dernières actualités directement par email.</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-2">
                    @csrf
                    <input type="email" name="email" placeholder="votre@email.com" required class="w-full bg-white/10 border border-white/15 text-white text-sm px-3 py-2.5 rounded-xl placeholder-white/35 focus:outline-none focus:border-gold/50 transition-all">
                    <button type="submit" class="w-full gold-gradient text-white py-2.5 rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-gold/25 transition-all">S'abonner</button>
                </form>
            </div>
        </aside>
    </div>
</div>
</section>
@endsection
