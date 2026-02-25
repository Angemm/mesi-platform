@extends('layouts.admin')
@section('title', isset($membre) ? 'Modifier le Membre' : 'Nouveau Membre')
@section('page-title', isset($membre) ? 'Modifier le Membre' : 'Nouveau Membre')

@section('content')

<form method="POST" action="{{ isset($membre) ? route('admin.membres.update', $membre) : route('admin.membres.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($membre)) @method('PUT') @endif

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- INFOS PRINCIPALES --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-5 pb-4 border-b border-slate-100">Informations personnelles</h3>
                <div class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Prénom *</label>
                            <input type="text" name="prenom" value="{{ old('prenom', $membre->prenom ?? '') }}" required
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Nom *</label>
                            <input type="text" name="nom" value="{{ old('nom', $membre->nom ?? '') }}" required
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $membre->email ?? '') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Téléphone</label>
                            <input type="text" name="telephone" value="{{ old('telephone', $membre->telephone ?? '') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Date de naissance</label>
                            <input type="date" name="date_naissance" value="{{ old('date_naissance', isset($membre->date_naissance) ? \Carbon\Carbon::parse($membre->date_naissance)->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Sexe</label>
                            <select name="sexe" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none">
                                <option value="">—</option>
                                <option value="M" {{ old('sexe', $membre->sexe ?? '') === 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('sexe', $membre->sexe ?? '') === 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Adresse</label>
                        <input type="text" name="adresse" value="{{ old('adresse', $membre->adresse ?? '') }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="Quartier, ville…">
                    </div>
                </div>
            </div>

            {{-- Infos église --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-5 pb-4 border-b border-slate-100">Rôle dans l'église</h3>
                <div class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Rôle / Fonction</label>
                            <input type="text" name="role_eglise" value="{{ old('role_eglise', $membre->role_eglise ?? '') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="Ex: Diacre, Ancienne…">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Département</label>
                            <select name="departement_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none">
                                <option value="">Aucun</option>
                                @foreach(\App\Models\Departement::orderBy('nom')->get() as $d)
                                <option value="{{ $d->id }}" {{ old('departement_id', $membre->departement_id ?? '') == $d->id ? 'selected' : '' }}>{{ $d->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Date d'intégration</label>
                            <input type="date" name="date_integration" value="{{ old('date_integration', isset($membre->date_integration) ? \Carbon\Carbon::parse($membre->date_integration)->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Statut</label>
                            <select name="statut" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none">
                                <option value="actif" {{ old('statut', $membre->statut ?? 'actif') === 'actif' ? 'selected' : '' }}>Actif</option>
                                <option value="inactif" {{ old('statut', $membre->statut ?? '') === 'inactif' ? 'selected' : '' }}>Inactif</option>
                                <option value="visiteur" {{ old('statut', $membre->statut ?? '') === 'visiteur' ? 'selected' : '' }}>Visiteur</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="est_dirigeant" value="1" {{ old('est_dirigeant', $membre->est_dirigeant ?? false) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded" style="accent-color:#2D6A27;">
                            <span class="text-sm font-bold text-slate-700">Ce membre est un dirigeant (affiché dans le carousel)</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Citation</label>
                        <textarea name="citation" rows="2" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none resize-none"
                                  placeholder="Citation de ce membre…">{{ old('citation', $membre->citation ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="space-y-5">
            {{-- Photo --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-4 text-sm">Photo de profil</h3>
                <div class="text-center mb-4">
                    <div class="w-24 h-24 mx-auto rounded-full overflow-hidden shadow-md" id="photoPreviewContainer" style="background:rgba(74,140,63,.1);">
                        @if(isset($membre) && $membre->photo)
                            <img src="{{ asset('storage/'.$membre->photo) }}" alt="" class="w-full h-full object-cover" id="photoPreview">
                        @else
                            <div class="w-full h-full flex items-center justify-center" id="photoPlaceholder">
                                <i class="fas fa-user text-2xl" style="color:#4A8C3F;"></i>
                            </div>
                        @endif
                    </div>
                </div>
                <label class="block">
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center cursor-pointer hover:border-green-400 transition-colors">
                        <p class="text-xs text-slate-400">Cliquez pour changer la photo</p>
                    </div>
                    <input type="file" name="photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                </label>
            </div>

            {{-- Actions --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm space-y-3">
                <button type="submit" class="w-full py-3 rounded-xl text-white font-bold text-sm" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
                    <i class="fas fa-save mr-2"></i> {{ isset($membre) ? 'Enregistrer' : 'Créer le membre' }}
                </button>
                <a href="{{ route('admin.membres.index') }}" class="block w-full py-3 rounded-xl font-bold text-sm text-center border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">
                    Annuler
                </a>
                @if(isset($membre))
                <form method="POST" action="{{ route('admin.membres.destroy', $membre) }}" onsubmit="return confirm('Supprimer ce membre ?')">
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
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const container = document.getElementById('photoPreviewContainer');
            container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection
