@extends('layouts.admin')
@section('title', isset($mission) ? 'Modifier la Mission' : 'Nouvelle Mission')
@section('page-title', isset($mission) ? 'Modifier la Mission' : 'Nouvelle Mission')

@section('content')

<form method="POST" action="{{ isset($mission) ? route('admin.missions.update', $mission) : route('admin.missions.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($mission)) @method('PUT') @endif

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- COLONNE PRINCIPALE --}}
        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-5 pb-4 border-b border-slate-100">Informations générales</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Nom de la mission *</label>
                        <input type="text" name="nom" value="{{ old('nom', $mission->nom ?? '') }}" required
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 @error('nom') border-red-300 @enderror"
                               style="--tw-ring-color:rgba(74,140,63,.4);" placeholder="Ex: Mission Évangélique Nord">
                        @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Pays</label>
                            <input type="text" name="pays" value="{{ old('pays', $mission->pays ?? '') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="Ex: Côte d'Ivoire">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Région</label>
                            <input type="text" name="region" value="{{ old('region', $mission->region ?? '') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="Ex: Nord">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Description</label>
                        <textarea name="description" rows="5" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none resize-none"
                                  placeholder="Décrivez les objectifs et activités de cette mission…">{{ old('description', $mission->description ?? '') }}</textarea>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Objectif de don (FCFA)</label>
                            <input type="number" name="objectif_don" value="{{ old('objectif_don', $mission->objectif_don ?? '') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="0">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Statut</label>
                            <select name="statut" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none bg-white">
                                <option value="active" {{ old('statut', $mission->statut ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="terminee" {{ old('statut', $mission->statut ?? '') === 'terminee' ? 'selected' : '' }}>Terminée</option>
                                <option value="planifiee" {{ old('statut', $mission->statut ?? '') === 'planifiee' ? 'selected' : '' }}>Planifiée</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Missionnaire(s) / Responsable</label>
                        <input type="text" name="missionnaire" value="{{ old('missionnaire', $mission->missionnaire ?? '') }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="Nom(s) des missionnaires">
                    </div>
                </div>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="space-y-5">

            {{-- Image --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-4 text-sm">Image de couverture</h3>
                @if(isset($mission) && $mission->image)
                <div class="mb-4 rounded-xl overflow-hidden aspect-video">
                    <img src="{{ asset('storage/'.$mission->image) }}" alt="" class="w-full h-full object-cover">
                </div>
                @endif
                <label class="block w-full">
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center cursor-pointer hover:border-green-400 transition-colors" id="imageDropZone">
                        <i class="fas fa-image text-2xl mb-2 block" style="color:#4A8C3F;"></i>
                        <p class="text-xs text-slate-400">Cliquez ou glissez une image</p>
                        <p class="text-[10px] text-slate-300 mt-1">JPG, PNG, WebP — max 2MB</p>
                    </div>
                    <input type="file" name="image" accept="image/*" class="hidden" onchange="previewImage(this,'imageDropZone')">
                </label>
            </div>

            {{-- Actions --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm space-y-3">
                <button type="submit" class="w-full py-3 rounded-xl text-white font-bold text-sm" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
                    <i class="fas fa-save mr-2"></i> {{ isset($mission) ? 'Enregistrer les modifications' : 'Créer la mission' }}
                </button>
                <a href="{{ route('admin.missions.index') }}" class="block w-full py-3 rounded-xl font-bold text-sm text-center border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
                    Annuler
                </a>
                @if(isset($mission))
                <form method="POST" action="{{ route('admin.missions.destroy', $mission) }}" onsubmit="return confirm('Supprimer cette mission ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-3 rounded-xl font-bold text-sm text-red-500 border border-red-200 hover:bg-red-50 transition-colors">
                        <i class="fas fa-trash mr-2"></i> Supprimer
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
function previewImage(input, zoneId) {
    const zone = document.getElementById(zoneId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            zone.innerHTML = `<img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection
