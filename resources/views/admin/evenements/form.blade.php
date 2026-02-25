@extends('layouts.admin')
@section('title', isset($evenement) ? 'Modifier l\'Événement' : 'Nouvel Événement')
@section('page-title', isset($evenement) ? 'Modifier l\'Événement' : 'Nouvel Événement')

@section('content')

<form method="POST" action="{{ isset($evenement) ? route('admin.evenements.update', $evenement) : route('admin.evenements.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($evenement)) @method('PUT') @endif

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-5 pb-4 border-b border-slate-100">Détails de l'événement</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Titre *</label>
                        <input type="text" name="titre" value="{{ old('titre', $evenement->titre ?? '') }}" required
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="Ex: Conférence annuelle de l'église">
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Date de début *</label>
                            <input type="date" name="date_debut" value="{{ old('date_debut', isset($evenement->date_debut) ? \Carbon\Carbon::parse($evenement->date_debut)->format('Y-m-d') : '') }}" required
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Date de fin</label>
                            <input type="date" name="date_fin" value="{{ old('date_fin', isset($evenement->date_fin) ? \Carbon\Carbon::parse($evenement->date_fin)->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Heure</label>
                            <input type="time" name="heure" value="{{ old('heure', $evenement->heure ?? '') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Type</label>
                            <select name="type" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none">
                                <option value="">Général</option>
                                @foreach(['Culte spécial','Conférence','Séminaire','Retraite','Évangélisation','Formation','Jeunesse','Famille'] as $type)
                                <option value="{{ $type }}" {{ old('type', $evenement->type ?? '') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Lieu</label>
                        <input type="text" name="lieu" value="{{ old('lieu', $evenement->lieu ?? '') }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="Ex: Salle principale de l'église">
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none resize-none"
                                  placeholder="Décrivez cet événement…">{{ old('description', $evenement->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-5">
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-4 text-sm">Image (optionnelle)</h3>
                @if(isset($evenement) && $evenement->image)
                <div class="mb-3 rounded-xl overflow-hidden aspect-video"><img src="{{ asset('storage/'.$evenement->image) }}" class="w-full h-full object-cover"></div>
                @endif
                <label>
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-5 text-center cursor-pointer hover:border-green-400 transition-colors">
                        <i class="fas fa-image text-xl mb-1 block" style="color:#4A8C3F;"></i>
                        <p class="text-xs text-slate-400">Choisir une image</p>
                    </div>
                    <input type="file" name="image" accept="image/*" class="hidden">
                </label>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm space-y-3">
                <button type="submit" class="w-full py-3 rounded-xl text-white font-bold text-sm" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
                    <i class="fas fa-save mr-2"></i> {{ isset($evenement) ? 'Enregistrer' : 'Créer l\'événement' }}
                </button>
                <a href="{{ route('admin.evenements.index') }}" class="block w-full py-3 rounded-xl font-bold text-sm text-center border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">Annuler</a>
                @if(isset($evenement))
                <form method="POST" action="{{ route('admin.evenements.destroy', $evenement) }}" onsubmit="return confirm('Supprimer ?')">
                    @csrf @method('DELETE')
                    <button class="w-full py-3 rounded-xl font-bold text-sm text-red-500 border border-red-200 hover:bg-red-50 transition-colors"><i class="fas fa-trash mr-2"></i> Supprimer</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</form>

@endsection
