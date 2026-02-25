@extends('layouts.app')
@section('title', ($sermon->titre ?? 'Sermon') . ' — M.E.SI')

@section('content')

{{-- BREADCRUMB --}}
<div class="bg-white border-b border-slate-100 py-3">
    <div class="max-w-7xl mx-auto px-6 text-xs text-slate-400 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-green-700 transition-colors">Accueil</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <a href="{{ route('sermons.index') }}" class="hover:text-green-700 transition-colors">Sermons</a>
        <i class="fas fa-chevron-right text-[8px]"></i>
        <span class="text-slate-600 font-medium">{{ Str::limit($sermon->titre, 40) }}</span>
    </div>
</div>

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-3 gap-10">

            {{-- CONTENU PRINCIPAL --}}
            <div class="lg:col-span-2">
                {{-- Média --}}
                @if($sermon->lien_video)
                <div class="relative rounded-3xl overflow-hidden shadow-2xl bg-black mb-8" style="aspect-ratio:16/9;">
                    @php
                        preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $sermon->lien_video, $m);
                        $videoId = $m[1] ?? '';
                    @endphp
                    @if($videoId)
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}?rel=0"
                                frameborder="0" allow="fullscreen" allowfullscreen></iframe>
                    @else
                        <video class="w-full h-full" controls>
                            <source src="{{ $sermon->lien_video }}" type="video/mp4">
                        </video>
                    @endif
                </div>
                @elseif($sermon->image)
                <div class="relative rounded-3xl overflow-hidden shadow-2xl mb-8 aspect-video">
                    <img src="{{ asset('storage/'.$sermon->image) }}" alt="{{ $sermon->titre }}" class="w-full h-full object-cover">
                </div>
                @endif

                {{-- Audio --}}
                @if($sermon->fichier_audio)
                <div class="p-5 rounded-2xl mb-6 flex items-center gap-4" style="background:rgba(74,140,63,.08);border:1px solid rgba(74,140,63,.2);">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#2D6A27;">
                        <i class="fas fa-headphones text-white"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-black uppercase tracking-widest mb-1" style="color:#2D6A27;">Version Audio</p>
                        <audio controls class="w-full" style="height:36px;">
                            <source src="{{ asset('storage/'.$sermon->fichier_audio) }}" type="audio/mpeg">
                        </audio>
                    </div>
                    <a href="{{ asset('storage/'.$sermon->fichier_audio) }}" download class="text-xs font-bold px-3 py-2 rounded-lg border" style="color:#C47D0A;border-color:#C47D0A;">
                        <i class="fas fa-download"></i>
                    </a>
                </div>
                @endif

                {{-- Titre & méta --}}
                <div class="mb-6">
                    @if($sermon->serie)
                    <span class="text-xs font-black uppercase tracking-widest" style="color:#C47D0A;">{{ $sermon->serie->nom }}</span>
                    @endif
                    <h1 class="font-serif font-black text-slate-900 mt-2 mb-4 leading-tight" style="font-size:clamp(1.6rem,3vw,2.2rem);">{{ $sermon->titre }}</h1>
                    <div class="flex flex-wrap gap-4 text-sm text-slate-500">
                        @if($sermon->predicateur)<span class="flex items-center gap-1.5"><i class="fas fa-user" style="color:#E8A020;"></i> {{ $sermon->predicateur }}</span>@endif
                        @if($sermon->date_sermon)<span class="flex items-center gap-1.5"><i class="fas fa-calendar" style="color:#E8A020;"></i> {{ \Carbon\Carbon::parse($sermon->date_sermon)->isoFormat('D MMMM YYYY') }}</span>@endif
                        @if($sermon->duree)<span class="flex items-center gap-1.5"><i class="fas fa-clock" style="color:#E8A020;"></i> {{ $sermon->duree }}</span>@endif
                        @if($sermon->reference_biblique)<span class="flex items-center gap-1.5"><i class="fas fa-bible" style="color:#E8A020;"></i> {{ $sermon->reference_biblique }}</span>@endif
                    </div>
                </div>

                {{-- Description --}}
                @if($sermon->description)
                <div class="prose prose-slate max-w-none leading-relaxed text-slate-700">
                    {!! nl2br(e($sermon->description)) !!}
                </div>
                @endif

                {{-- Partager --}}
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <p class="text-sm font-black text-slate-700 mb-3">Partager ce sermon</p>
                    <div class="flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank"
                           class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-bold" style="background:#1877F2;">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($sermon->titre.' — '.request()->url()) }}" target="_blank"
                           class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-bold" style="background:#25D366;">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-6">
                {{-- Verset --}}
                @if($sermon->reference_biblique)
                <div class="p-6 rounded-2xl" style="background:linear-gradient(135deg,#2D6A27,#1C3A18);">
                    <i class="fas fa-quote-left text-2xl mb-3 block" style="color:rgba(232,160,32,.4);"></i>
                    <p class="font-serif italic text-white/90 leading-relaxed text-sm">{{ $sermon->verset_cle ?? '' }}</p>
                    <span class="block mt-3 text-xs font-black uppercase tracking-widest" style="color:#E8A020;">— {{ $sermon->reference_biblique }}</span>
                </div>
                @endif

                {{-- Sermons de la même série --}}
                @if(isset($sermonsSerie) && $sermonsSerie->count())
                <div class="p-5 rounded-2xl border border-slate-100 bg-white">
                    <h3 class="font-serif font-black text-slate-900 mb-4 text-base">Série : {{ $sermon->serie->nom }}</h3>
                    <div class="space-y-3">
                        @foreach($sermonsSerie as $s)
                        <a href="{{ route('sermons.show', $s->slug) }}" class="flex gap-3 items-center group p-2 rounded-xl hover:bg-slate-50 transition-colors {{ $s->id === $sermon->id ? 'bg-green-50' : '' }}">
                            <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="{{ $s->image ? asset('storage/'.$s->image) : asset('images/default-sermon.jpg') }}" alt="" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-slate-800 truncate {{ $s->id === $sermon->id ? 'text-green-700' : '' }}">{{ $s->titre }}</p>
                                <p class="text-[10px] text-slate-400">{{ \Carbon\Carbon::parse($s->date_sermon)->isoFormat('D MMM YY') }}</p>
                            </div>
                            @if($s->id === $sermon->id)
                            <i class="fas fa-play text-[10px] flex-shrink-0" style="color:#2D6A27;"></i>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Sermons récents --}}
                @if(isset($sermonsRecents) && $sermonsRecents->count())
                <div class="p-5 rounded-2xl border border-slate-100 bg-white">
                    <h3 class="font-serif font-black text-slate-900 mb-4 text-base">Sermons récents</h3>
                    <div class="space-y-3">
                        @foreach($sermonsRecents as $s)
                        <a href="{{ route('sermons.show', $s->slug) }}" class="flex gap-3 items-center group p-2 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="{{ $s->image ? asset('storage/'.$s->image) : asset('images/default-sermon.jpg') }}" alt="" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-slate-800 truncate">{{ $s->titre }}</p>
                                <p class="text-[10px] text-slate-400">{{ $s->predicateur ?? '' }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- CTA Don --}}
                <div class="p-5 rounded-2xl border" style="background:rgba(74,140,63,.05);border-color:rgba(74,140,63,.2);">
                    <h3 class="font-serif font-black text-slate-900 mb-2">Touché par ce message ?</h3>
                    <p class="text-xs text-slate-500 mb-4 leading-relaxed">Soutenez notre ministère pour continuer à partager la Parole.</p>
                    <a href="{{ route('don') }}" class="block text-center py-3 rounded-xl font-bold text-white text-sm"
                       style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
                        <i class="fas fa-heart mr-2"></i> Faire un Don
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
