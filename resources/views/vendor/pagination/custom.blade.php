@if($paginator->hasPages())
<div class="flex items-center justify-center gap-2 flex-wrap">
    {{-- Précédent --}}
    @if($paginator->onFirstPage())
        <span class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center text-slate-300 text-sm select-none cursor-not-allowed">
            <i class="fas fa-chevron-left text-xs"></i>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="w-10 h-10 rounded-xl border border-slate-200 bg-white flex items-center justify-center text-slate-500 text-sm hover:border-gold/50 hover:text-gold-dark transition-all">
            <i class="fas fa-chevron-left text-xs"></i>
        </a>
    @endif

    {{-- Pages --}}
    @foreach($elements as $element)
        @if(is_string($element))
            <span class="w-10 h-10 flex items-center justify-center text-slate-300 text-sm">…</span>
        @endif
        @if(is_array($element))
            @foreach($element as $page => $url)
                @if($page == $paginator->currentPage())
                    <span class="w-10 h-10 rounded-xl gold-gradient text-white flex items-center justify-center text-sm font-black shadow-md shadow-gold/25">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="w-10 h-10 rounded-xl border border-slate-200 bg-white text-slate-600 flex items-center justify-center text-sm font-bold hover:border-gold/50 hover:text-gold-dark transition-all">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Suivant --}}
    @if($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="w-10 h-10 rounded-xl border border-slate-200 bg-white flex items-center justify-center text-slate-500 text-sm hover:border-gold/50 hover:text-gold-dark transition-all">
            <i class="fas fa-chevron-right text-xs"></i>
        </a>
    @else
        <span class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center text-slate-300 text-sm select-none cursor-not-allowed">
            <i class="fas fa-chevron-right text-xs"></i>
        </span>
    @endif
</div>
@endif
