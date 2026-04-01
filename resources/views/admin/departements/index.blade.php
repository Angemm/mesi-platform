@extends('layouts.admin')
@section('title','Départements — M.E.SI Admin')
@section('page-title','Départements')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-slate-500 text-sm">{{ $departements->count() }} département(s)</p>
    <a href="{{ route('admin.departements.create') }}" class="gold-gradient text-white text-sm font-bold px-5 py-2.5 rounded-xl flex items-center gap-2 hover:shadow-md transition-all">
        <i class="fas fa-plus text-xs"></i> Nouveau département
    </a>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($departements as $dept)
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow p-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background:{{ $dept->couleur ?? '#e8b04b' }}22;">
                    <i class="{{ $dept->icone ?? 'fas fa-layer-group' }} text-lg" style="color:{{ $dept->couleur ?? '#e8b04b' }};"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">{{ $dept->nom }}</h3>
                    <span class="text-xs text-slate-400">{{ $dept->membres_count }} membre(s)</span>
                </div>
            </div>
            <div class="flex gap-1.5">
                <a href="{{ route('admin.departements.edit', $dept->id) }}" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center hover:bg-navy hover:text-white transition-all text-xs">
                    <i class="fas fa-pen"></i>
                </a>
                <form method="POST" action="{{ route('admin.departements.destroy', $dept->id) }}" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Supprimer ce département ?')" class="w-8 h-8 rounded-lg bg-red-50 text-red-400 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all text-xs">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @if($dept->description)
        <p class="text-xs text-slate-500 leading-relaxed">{{ Str::limit($dept->description, 100) }}</p>
        @endif
    </div>
    @empty
    <div class="col-span-full text-center py-16 text-slate-400">
        <i class="fas fa-layer-group text-5xl mb-4 block text-slate-200"></i>
        <p class="text-sm">Aucun département créé.</p>
        <a href="{{ route('admin.departements.create') }}" class="inline-flex items-center gap-2 mt-4 gold-gradient text-white px-5 py-2.5 rounded-xl text-sm font-bold">
            <i class="fas fa-plus text-xs"></i> Créer le premier
        </a>
    </div>
    @endforelse
</div>

@endsection
