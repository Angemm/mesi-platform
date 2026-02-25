@extends('layouts.app')
@section('title', 'Sermons — M.E.SI')

@section('content')

{{-- HERO --}}
<section class="py-20 text-center relative overflow-hidden" style="background:linear-gradient(135deg,#2D6A27 0%,#1C3A18 100%);">
    <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(232,160,32,.07) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="relative z-10 max-w-3xl mx-auto px-6">
        <span class="inline-block px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest mb-5" style="background:rgba(232,160,32,.15);color:#E8A020;">Médiathèque</span>
        <h1 class="font-serif font-black text-white mb-4" style="font-size:clamp(2rem,4vw,3rem);">Nos <span style="color:#E8A020;">Sermons</span></h1>
        <p class="text-white/65 leading-relaxed">Nourrissez votre foi avec les enseignements de la Parole de Dieu.</p>
    </div>
</section>

{{-- FILTRES --}}
<section class="py-8 bg-white border-b border-slate-100 sticky top-[72px] z-30">
    <div class="max-w-7xl mx-auto px-6">
        <form method="GET" action="{{ route('sermons.index') }}" class="flex flex-wrap gap-3 items-center">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un sermon…"
                   class="flex-1 min-w-48 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:border-transparent"
                   style="--tw-ring-color:rgba(74,140,63,.4);">
            @if(isset($series) && $series->count())
            <select name="serie" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none bg-white">
                <option value="">Toutes les séries</option>
                @foreach($series as $s)
                <option value="{{ $s->id }}" {{ request('serie') == $s->id ? 'selected' : '' }}>{{ $s->nom }}</option>
                @endforeach
            </select>
            @endif
            @if(isset($predicateurs))
            <select name="predicateur" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none bg-white">
                <option value="">Tous les prédicateurs</option>
                @foreach($predicateurs as $p)
                <option value="{{ $p }}" {{ request('predicateur') == $p ? 'selected' : '' }}>{{ $p }}</option>
                @endforeach
            </select>
            @endif
            <button type="submit" class="px-5 py-2.5 rounded-xl text-white text-sm font-bold" style="background:linear-gradient(135deg,#4A8C3F,#2D6A27);">
                <i class="fas fa-search mr-1"></i> Filtrer
            </button>
            @if(request()->anyFilled(['q','serie','predicateur']))
            <a href="{{ route('sermons.index') }}" class="px-5 py-2.5 rounded-xl text-sm font-bold border border-slate-200 text-slate-500 hover:border-slate-300 transition-colors">Réinitialiser</a>
            @endif
        </form>
    </div>
</section>

{{-- SERMON VEDETTE --}}
@if(isset($sermonsVedette) && $sermonsVedette)
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="rounded-3xl overflow-hidden grid lg:grid-cols-2 shadow-xl border border-slate-100">
            <div class="relative aspect-video lg:aspect-auto img-zoom">
                <img src="{{ $sermonsVedette->image ? asset('storage/'.$sermonsVedette->image) : asset('images/default-sermon.jpg') }}"
                     alt="{{ $sermonsVedette->titre }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 flex items-center justify-center" style="background:rgba(28,58,24,.5);">
                    <a href="{{ route('sermons.show', $sermonsVedette->slug) }}" class="w-16 h-16 rounded-full flex items-center justify-center shadow-xl hover:scale-110 transition-transform" style="background:rgba(232,160,32,.95);">
                        <i class="fas fa-play text-white text-xl ml-1"></i>
                    </a>
                </div>
                <span class="absolute top-4 left-4 px-3 py-1 rounded-full text-white text-xs font-black uppercase" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">À la Une</span>
            </div>
            <div class="p-8 lg:p-12 flex flex-col justify-center" style="background:#F8F6F2;">
                <span class="text-xs font-black uppercase tracking-widest mb-3" style="color:#C47D0A;">{{ $sermonsVedette->serie?->nom ?? 'Sermon' }}</span>
                <h2 class="font-serif font-black text-slate-900 text-2xl lg:text-3xl leading-tight mb-4">{{ $sermonsVedette->titre }}</h2>
                <p class="text-slate-600 leading-relaxed mb-6 text-sm">{{ Str::limit(strip_tags($sermonsVedette->description ?? ''), 180) }}</p>
                <div class="flex flex-wrap gap-4 text-xs text-slate-400 mb-6">
                    @if($sermonsVedette->predicateur)<span><i class="fas fa-user mr-1" style="color:#E8A020;"></i> {{ $sermonsVedette->predicateur }}</span>@endif
                    @if($sermonsVedette->date_sermon)<span><i class="fas fa-calendar mr-1" style="color:#E8A020;"></i> {{ \Carbon\Carbon::parse($sermonsVedette->date_sermon)->isoFormat('D MMMM YYYY') }}</span>@endif
                    @if($sermonsVedette->duree)<span><i class="fas fa-clock mr-1" style="color:#E8A020;"></i> {{ $sermonsVedette->duree }}</span>@endif
                </div>
                <a href="{{ route('sermons.show', $sermonsVedette->slug) }}" class="inline-flex items-center gap-2 px-7 py-3 rounded-xl text-white font-bold text-sm w-fit"
                   style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
                    <i class="fas fa-play text-xs"></i> Écouter / Voir
                </a>
            </div>
        </div>
    </div>
</section>
@endif

{{-- LISTE DES SERMONS --}}
<section class="py-12" style="background:#F8F6F2;">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-serif font-black text-slate-900 text-xl">Tous les sermons</h2>
            <span class="text-xs text-slate-400">{{ $sermons->total() ?? 0 }} sermon(s)</span>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($sermons as $sermon)
            <article class="bg-white rounded-2xl overflow-hidden border border-slate-100 card-hover group">
                <div class="relative aspect-video img-zoom">
                    <img src="{{ $sermon->image ? asset('storage/'.$sermon->image) : asset('images/default-sermon.jpg') }}"
                         alt="{{ $sermon->titre }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" style="background:rgba(28,58,24,.5);">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background:rgba(232,160,32,.9);">
                            <i class="fas fa-play text-white text-sm ml-0.5"></i>
                        </div>
                    </div>
                    @if($sermon->type)
                    <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full text-white text-[10px] font-black uppercase" style="background:#2D6A27;">{{ $sermon->type }}</span>
                    @endif
                    @if($sermon->duree)
                    <span class="absolute bottom-3 right-3 px-2 py-0.5 rounded bg-black/70 text-white text-[10px] font-bold">{{ $sermon->duree }}</span>
                    @endif
                </div>
                <div class="p-5">
                    @if($sermon->serie)<span class="text-[10px] font-black uppercase tracking-widest" style="color:#C47D0A;">{{ $sermon->serie->nom }}</span>@endif
                    <h3 class="font-serif font-bold text-slate-900 mt-1 mb-2 leading-snug text-base group-hover:transition-colors"
                        onmouseover="this.style.color='#C47D0A'" onmouseout="this.style.color=''">
                        <a href="{{ route('sermons.show', $sermon->slug) }}">{{ $sermon->titre }}</a>
                    </h3>
                    <div class="flex flex-wrap gap-3 text-xs text-slate-400">
                        @if($sermon->predicateur)<span><i class="fas fa-user mr-1"></i>{{ $sermon->predicateur }}</span>@endif
                        @if($sermon->date_sermon)<span><i class="fas fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($sermon->date_sermon)->isoFormat('D MMM YYYY') }}</span>@endif
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-16 text-slate-400 bg-white rounded-2xl">
                <i class="fas fa-bible text-5xl mb-4 block text-slate-200"></i>
                <p>Aucun sermon disponible pour le moment.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if(isset($sermons) && $sermons->hasPages())
        <div class="mt-10 flex justify-center">{{ $sermons->links() }}</div>
        @endif
    </div>
</section>

@endsection
