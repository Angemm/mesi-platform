@extends('layouts.app')
@section('title', 'Culte en Direct — M.E.SI')

@section('content')

{{-- HERO --}}
<section class="py-16 text-center relative overflow-hidden" style="background:linear-gradient(135deg,#2D6A27 0%,#1C3A18 100%);">
    <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(232,160,32,.07) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="relative z-10 max-w-3xl mx-auto px-6">
        <div class="inline-flex items-center gap-2 bg-red-500/20 border border-red-400/40 text-red-300 px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest mb-6 animate-pulse">
            <span class="live-dot w-2 h-2"></span> En Direct Maintenant
        </div>
        <h1 class="font-serif font-black text-white mb-4" style="font-size:clamp(2rem,4vw,3rem);">
            Culte en <span style="color:#E8A020;">Direct</span>
        </h1>
        <p class="text-white/65 leading-relaxed max-w-xl mx-auto">Participez à notre culte en ligne depuis chez vous. Adorez avec nous !</p>
    </div>
</section>

{{-- PLAYER --}}
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Vidéo --}}
            <div class="lg:col-span-2">
                @if($culte ?? false)
                <div class="relative bg-black rounded-3xl overflow-hidden shadow-2xl" style="aspect-ratio:16/9;">
                    @if(Str::contains($culte->lien_video ?? '', 'youtube'))
                        @php
                            preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $culte->lien_video, $m);
                            $videoId = $m[1] ?? '';
                        @endphp
                        <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&rel=0"
                                frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
                    @elseif(Str::contains($culte->lien_video ?? '', 'facebook'))
                        <iframe class="w-full h-full"
                                src="https://www.facebook.com/plugins/video.php?href={{ urlencode($culte->lien_video) }}&autoplay=true"
                                frameborder="0" allowfullscreen></iframe>
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-white/50" style="min-height:360px;">
                            <i class="fas fa-satellite-dish text-6xl mb-4" style="color:rgba(232,160,32,.4);"></i>
                            <p class="font-serif text-xl text-white/70">Le direct débutera bientôt</p>
                            <p class="text-sm text-white/40 mt-2">Restez connectés</p>
                        </div>
                    @endif
                </div>

                {{-- Infos culte --}}
                <div class="mt-6 p-6 rounded-2xl border" style="background:#F8F6F2;border-color:rgba(74,140,63,.15);">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div>
                            <h2 class="font-serif font-black text-slate-900 text-2xl mb-1">{{ $culte->titre }}</h2>
                            <div class="flex flex-wrap gap-4 text-sm text-slate-500 mt-2">
                                <span><i class="fas fa-calendar mr-1" style="color:#E8A020;"></i> {{ \Carbon\Carbon::parse($culte->date_culte)->isoFormat('D MMMM YYYY') }}</span>
                                @if($culte->heure)<span><i class="fas fa-clock mr-1" style="color:#E8A020;"></i> {{ $culte->heure }}</span>@endif
                                @if($culte->predicateur)<span><i class="fas fa-user mr-1" style="color:#E8A020;"></i> {{ $culte->predicateur }}</span>@endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2 bg-red-50 border border-red-200 text-red-600 px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest">
                            <span class="live-dot w-1.5 h-1.5"></span> LIVE
                        </div>
                    </div>
                    @if($culte->description)
                    <p class="text-slate-600 mt-4 leading-relaxed text-sm">{{ $culte->description }}</p>
                    @endif
                </div>
                @else
                <div class="relative bg-slate-900 rounded-3xl overflow-hidden shadow-2xl flex items-center justify-center" style="min-height:420px;">
                    <div class="text-center text-white/50 px-8">
                        <i class="fas fa-satellite-dish text-7xl mb-6 block" style="color:rgba(232,160,32,.35);"></i>
                        <h3 class="font-serif text-2xl text-white/80 mb-2">Aucun direct en ce moment</h3>
                        <p class="text-sm leading-relaxed">Consultez notre agenda pour connaître les prochains cultes en direct.</p>
                        <a href="{{ route('cultes.index') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 rounded-xl font-bold text-white text-sm"
                           style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
                            Voir les cultes <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Prochain culte --}}
                @if($prochainCulte ?? false)
                <div class="p-5 rounded-2xl border" style="background:#F8F6F2;border-color:rgba(74,140,63,.15);">
                    <h3 class="font-serif font-black text-slate-900 mb-4 text-base">Prochain Culte</h3>
                    <div class="flex gap-3 items-start">
                        <div class="w-12 h-12 rounded-xl flex flex-col items-center justify-center flex-shrink-0" style="background:#1C3A18;">
                            <span class="font-serif font-bold text-lg leading-none" style="color:#E8A020;">{{ \Carbon\Carbon::parse($prochainCulte->date_culte)->format('d') }}</span>
                            <span class="text-[9px] uppercase" style="color:rgba(255,255,255,.5);">{{ \Carbon\Carbon::parse($prochainCulte->date_culte)->isoFormat('MMM') }}</span>
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">{{ $prochainCulte->titre }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $prochainCulte->heure ?? '' }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Horaires --}}
                <div class="p-5 rounded-2xl border" style="background:rgba(74,140,63,.05);border-color:rgba(74,140,63,.2);">
                    <h3 class="font-serif font-black text-slate-900 mb-4 text-base">Nos Cultes</h3>
                    @foreach(\App\Models\HoraireCulte::actif()->orderBy('ordre')->get() as $h)
                    <div class="flex justify-between items-center py-2.5 border-b last:border-b-0" style="border-color:rgba(74,140,63,.15);">
                        <span class="text-sm font-medium text-slate-700">{{ $h->jour }}</span>
                        <span class="text-sm font-black" style="color:#C47D0A;">{{ $h->heure }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Partager --}}
                <div class="p-5 rounded-2xl border border-slate-100 bg-white">
                    <h3 class="font-serif font-black text-slate-900 mb-4 text-base">Partager</h3>
                    <div class="flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank"
                           class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-white text-sm font-bold" style="background:#1877F2;">
                            <i class="fab fa-facebook text-sm"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode('Je suis en train de regarder le culte en direct de M.E.SI : '.request()->url()) }}" target="_blank"
                           class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-white text-sm font-bold" style="background:#25D366;">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </a>
                        <button onclick="navigator.clipboard.writeText(window.location.href); this.innerHTML='<i class=\'fas fa-check\'></i>'; setTimeout(()=>this.innerHTML='<i class=\'fas fa-link\'></i>',2000)"
                                class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-bold border border-slate-200 text-slate-600">
                            <i class="fas fa-link text-sm"></i>
                        </button>
                    </div>
                </div>

                {{-- Don --}}
                <div class="p-5 rounded-2xl text-center" style="background:linear-gradient(135deg,#2D6A27,#1C3A18);">
                    <i class="fas fa-heart text-2xl mb-3 block" style="color:#E8A020;"></i>
                    <h3 class="font-serif font-black text-white mb-2">Soutenez l'Église</h3>
                    <p class="text-white/60 text-xs leading-relaxed mb-4">Vos offrandes soutiennent notre mission et nos programmes.</p>
                    <a href="{{ route('don') }}" class="block py-3 rounded-xl font-bold text-white text-sm"
                       style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
                        <i class="fas fa-heart mr-2"></i> Faire un Don
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Anciens directs --}}
@if(isset($autresCultes) && $autresCultes->count())
<section class="py-16" style="background:#F8F6F2;">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="font-serif font-black text-slate-900 text-2xl mb-8">Replays récents</h2>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($autresCultes as $c)
            <a href="{{ route('cultes.show', $c->slug) }}" class="group bg-white rounded-2xl overflow-hidden border border-slate-100 card-hover">
                <div class="aspect-video img-zoom relative">
                    <img src="{{ $c->image ? asset('storage/'.$c->image) : asset('images/default-culte.jpg') }}" alt="{{ $c->titre }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 flex items-center justify-center" style="background:rgba(28,58,24,.4);">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background:rgba(232,160,32,.9);">
                            <i class="fas fa-play text-white text-sm ml-0.5"></i>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    <p class="font-bold text-slate-900 text-sm leading-snug group-hover:transition-colors" onmouseover="this.style.color='#C47D0A'" onmouseout="this.style.color=''">{{ $c->titre }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ \Carbon\Carbon::parse($c->date_culte)->isoFormat('D MMM YYYY') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
