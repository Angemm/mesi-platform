@extends('layouts.admin')
@section('title', isset($sermon) ? 'Modifier le Sermon' : 'Nouveau Sermon')
@section('page-title', isset($sermon) ? 'Modifier le Sermon' : 'Nouveau Sermon')

@section('content')

<form method="POST" action="{{ isset($sermon) ? route('admin.sermons.update', $sermon) : route('admin.sermons.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($sermon)) @method('PUT') @endif

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">

            {{-- Infos principales --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-5 pb-4 border-b border-slate-100">Informations du sermon</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Titre *</label>
                        <input type="text" name="titre" value="{{ old('titre', $sermon->titre ?? '') }}" required
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="Ex: La puissance de la foi">
                        @error('titre')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Prédicateur</label>
                            <input type="text" name="predicateur" value="{{ old('predicateur', $sermon->predicateur ?? '') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Date</label>
                            <input type="date" name="date_sermon" value="{{ old('date_sermon', isset($sermon->date_sermon) ? \Carbon\Carbon::parse($sermon->date_sermon)->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Référence biblique</label>
                            <input type="text" name="reference_biblique" value="{{ old('reference_biblique', $sermon->reference_biblique ?? '') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="Ex: Jean 3:16">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Durée</label>
                            <input type="text" name="duree" value="{{ old('duree', $sermon->duree ?? '') }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="Ex: 45:00">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Verset clé</label>
                        <input type="text" name="verset_cle" value="{{ old('verset_cle', $sermon->verset_cle ?? '') }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="Texte du verset biblique principal">
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Description / Résumé</label>
                        <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none resize-none"
                                  placeholder="Résumé du message…">{{ old('description', $sermon->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Médias --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-5 pb-4 border-b border-slate-100">Médias</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Lien vidéo (YouTube, Facebook…)</label>
                        <input type="url" name="lien_video" value="{{ old('lien_video', $sermon->lien_video ?? '') }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="https://youtube.com/watch?v=...">
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Fichier audio (MP3)</label>
                        @if(isset($sermon) && $sermon->fichier_audio)
                        <div class="flex items-center gap-3 mb-2 p-3 rounded-xl" style="background:#F8F6F2;">
                            <i class="fas fa-file-audio text-sm" style="color:#4A8C3F;"></i>
                            <span class="text-xs text-slate-600 flex-1">Fichier existant</span>
                            <audio controls class="w-48" style="height:28px;">
                                <source src="{{ asset('storage/'.$sermon->fichier_audio) }}" type="audio/mpeg">
                            </audio>
                        </div>
                        @endif
                        <input type="file" name="fichier_audio" accept="audio/*"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Type</label>
                        <select name="type" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none">
                            <option value="video" {{ old('type', $sermon->type ?? 'video') === 'video' ? 'selected' : '' }}>Vidéo</option>
                            <option value="audio" {{ old('type', $sermon->type ?? '') === 'audio' ? 'selected' : '' }}>Audio</option>
                            <option value="texte" {{ old('type', $sermon->type ?? '') === 'texte' ? 'selected' : '' }}>Texte</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="space-y-5">

            {{-- Série --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-4 text-sm">Série</h3>
                <select name="serie_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none">
                    <option value="">Aucune série</option>
                    @foreach(\App\Models\SerieSermon::orderBy('nom')->get() as $serie)
                    <option value="{{ $serie->id }}" {{ old('serie_id', $sermon->serie_id ?? '') == $serie->id ? 'selected' : '' }}>{{ $serie->nom }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Image --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-4 text-sm">Miniature</h3>
                @if(isset($sermon) && $sermon->image)
                <div class="mb-3 rounded-xl overflow-hidden aspect-video"><img src="{{ asset('storage/'.$sermon->image) }}" class="w-full h-full object-cover"></div>
                @endif
                <label>
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-5 text-center cursor-pointer hover:border-green-400 transition-colors">
                        <i class="fas fa-image text-xl mb-1 block" style="color:#4A8C3F;"></i>
                        <p class="text-xs text-slate-400">Choisir une image</p>
                    </div>
                    <input type="file" name="image" accept="image/*" class="hidden">
                </label>
            </div>

            {{-- Vedette --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-4 shadow-sm">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="est_vedette" value="1" {{ old('est_vedette', $sermon->est_vedette ?? false) ? 'checked' : '' }}
                           class="w-4 h-4 rounded" style="accent-color:#2D6A27;">
                    <span class="text-sm font-bold text-slate-700">Sermon à la une</span>
                </label>
            </div>

            {{-- Actions --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm space-y-3">
                <button type="submit" class="w-full py-3 rounded-xl text-white font-bold text-sm" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
                    <i class="fas fa-save mr-2"></i> {{ isset($sermon) ? 'Enregistrer' : 'Créer le sermon' }}
                </button>
                <a href="{{ route('admin.sermons.index') }}" class="block w-full py-3 rounded-xl font-bold text-sm text-center border border-slate-200 text-slate-500 hover:bg-slate-50 transition-colors">Annuler</a>
                @if(isset($sermon))
                <form method="POST" action="{{ route('admin.sermons.destroy', $sermon) }}" onsubmit="return confirm('Supprimer ?')">
                    @csrf @method('DELETE')
                    <button class="w-full py-3 rounded-xl font-bold text-sm text-red-500 border border-red-200 hover:bg-red-50 transition-colors"><i class="fas fa-trash mr-2"></i> Supprimer</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</form>

@endsection
