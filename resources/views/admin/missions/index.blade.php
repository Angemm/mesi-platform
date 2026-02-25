@extends('layouts.admin')
@section('title', 'Missions — Admin')
@section('page-title', 'Missions')

@section('content')

<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <form method="GET" action="{{ route('admin.missions.index') }}" class="flex gap-3 flex-1 max-w-md">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher une mission…"
               class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none">
        <button type="submit" class="px-4 py-2.5 rounded-xl text-white text-sm" style="background:#2D6A27;"><i class="fas fa-search"></i></button>
    </form>
    <a href="{{ route('admin.missions.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-bold" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
        <i class="fas fa-plus"></i> Nouvelle Mission
    </a>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
    @forelse($missions as $mission)
    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
        <div class="relative aspect-video img-zoom">
            <img src="{{ $mission->image ? asset('storage/'.$mission->image) : asset('images/default-mission.jpg') }}" alt="{{ $mission->nom }}" class="w-full h-full object-cover">
            <div class="absolute inset-0" style="background:linear-gradient(to top,rgba(28,58,24,.7),transparent 50%);"></div>
            <div class="absolute bottom-3 left-3 right-3">
                <p class="text-xs font-bold text-white/70"><i class="fas fa-map-marker-alt mr-1"></i> {{ $mission->pays ?? $mission->region ?? '—' }}</p>
            </div>
        </div>
        <div class="p-5">
            <h3 class="font-bold text-slate-900 mb-1">{{ $mission->nom }}</h3>
            @if($mission->objectif_don > 0)
            <div class="mb-3">
                <div class="flex justify-between text-xs text-slate-400 mb-1">
                    <span>{{ number_format($mission->dons_recus) }} FCFA</span>
                    <span>{{ round($mission->dons_recus / $mission->objectif_don * 100) }}%</span>
                </div>
                <div class="h-1.5 rounded-full bg-slate-100">
                    <div class="h-full rounded-full" style="width:{{ min(100, round($mission->dons_recus / $mission->objectif_don * 100)) }}%;background:linear-gradient(135deg,#4A8C3F,#2D6A27);"></div>
                </div>
            </div>
            @endif
            <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-black {{ $mission->statut === 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                {{ $mission->statut ?? 'active' }}
            </span>
            <div class="flex gap-2 mt-4">
                <a href="{{ route('admin.missions.edit', $mission) }}" class="flex-1 text-center px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 text-slate-600 hover:border-blue-300 hover:text-blue-600 transition-colors">
                    <i class="fas fa-pen mr-1"></i> Modifier
                </a>
                <form method="POST" action="{{ route('admin.missions.destroy', $mission) }}" onsubmit="return confirm('Supprimer ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 text-slate-400 hover:border-red-300 hover:text-red-500 transition-colors">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12 text-slate-400 bg-white rounded-2xl border border-slate-100">
        <i class="fas fa-globe text-3xl mb-2 block text-slate-200"></i> Aucune mission enregistrée.
    </div>
    @endforelse
</div>

@if(isset($missions) && $missions->hasPages())
<div class="flex justify-center">{{ $missions->links() }}</div>
@endif

@endsection
