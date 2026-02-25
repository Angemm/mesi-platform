@extends('layouts.admin')
@section('title', isset($actualite) ? 'Modifier l\'article' : 'Nouvel Article')
@section('page-title', isset($actualite) ? 'Modifier l\'article' : 'Écrire un Article')

@section('content')

<form method="POST" action="{{ isset($actualite) ? route('admin.actualites.update', $actualite->id) : route('admin.actualites.store') }}" enctype="multipart/form-data">
    @csrf @if(isset($actualite)) @method('PUT') @endif

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- Rédaction --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <div class="space-y-4">
                    <div>
                        <input type="text" name="titre" value="{{ old('titre', $actualite->titre ?? '') }}" required
                               placeholder="Titre de l'article…"
                               class="w-full border-0 border-b-2 @error('titre') border-red-300 @else border-slate-200 @enderror bg-transparent py-3 text-2xl font-black text-slate-900 focus:outline-none focus:border-gold transition-colors placeholder-slate-300">
                        @error('titre')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <textarea name="extrait" rows="2" placeholder="Court résumé (visible dans les listes)…"
                                  class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/10 transition-all resize-none text-slate-500">{{ old('extrait', $actualite->extrait ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Contenu *</label>
                        <textarea name="contenu" id="contenuEditor" rows="16" required
                                  placeholder="Rédigez le contenu complet…"
                                  class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white transition-all resize-y min-h-[320px]">{{ old('contenu', $actualite->contenu ?? '') }}</textarea>
                        <p class="text-[10px] text-slate-300 mt-1.5">HTML basique accepté. Conseil : intégrez un éditeur WYSIWYG comme TinyMCE ou Quill pour une meilleure expérience.</p>
                        @error('contenu')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Panneau latéral --}}
        <div class="space-y-5">

            {{-- Publication --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h3 class="font-serif font-bold text-navy text-sm mb-4 flex items-center gap-2"><i class="fas fa-paper-plane text-gold text-xs"></i> Publication</h3>
                <div class="space-y-2.5 mb-5">
                    <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="publie" value="1" {{ old('publie', $actualite->publie ?? false) ? 'checked' : '' }} class="w-4 h-4 rounded accent-navy">
                        <span class="text-sm font-bold text-navy">Publier maintenant</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors">
                        <input type="checkbox" name="en_vedette" value="1" {{ old('en_vedette', $actualite->en_vedette ?? false) ? 'checked' : '' }} class="w-4 h-4 rounded accent-amber-500">
                        <span class="text-sm font-bold text-amber-600">★ Mettre en Vedette</span>
                    </label>
                </div>
                <button type="submit" class="w-full gold-gradient text-white py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-gold/25 hover:-translate-y-0.5 transition-all">
                    <i class="fas fa-save text-xs"></i> {{ isset($actualite) ? 'Mettre à jour' : 'Publier' }}
                </button>
                <a href="{{ route('admin.actualites.index') }}" class="w-full mt-2.5 border border-slate-200 text-slate-500 py-2.5 rounded-xl text-sm font-bold flex items-center justify-center hover:bg-slate-50 transition-all">
                    Annuler
                </a>
            </div>

            {{-- Catégorie --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h3 class="font-serif font-bold text-navy text-sm mb-4 flex items-center gap-2"><i class="fas fa-tag text-gold text-xs"></i> Catégorie</h3>
                <select name="categorie_id" class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 transition-all appearance-none">
                    <option value="">— Sans catégorie —</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('categorie_id', $actualite->categorie_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Image à la une --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h3 class="font-serif font-bold text-navy text-sm mb-4 flex items-center gap-2"><i class="fas fa-image text-gold text-xs"></i> Image à la Une</h3>

                @if(isset($actualite) && $actualite->image)
                <img src="{{ asset('storage/'.$actualite->image) }}" class="w-full aspect-[16/9] object-cover rounded-xl mb-3 border border-slate-100" alt="">
                @endif

                <div class="border-2 border-dashed border-slate-200 rounded-xl p-5 text-center hover:border-gold/40 transition-colors">
                    <img id="imgPreviewActu" class="hidden w-full aspect-[16/9] object-cover rounded-xl mb-3" alt="">
                    <i class="fas fa-image text-2xl text-slate-300 mb-2 block"></i>
                    <input type="file" name="image" accept="image/*" data-preview="imgPreviewActu" id="actuImg" class="hidden">
                    <label for="actuImg" class="gold-gradient text-white text-xs font-bold px-4 py-2 rounded-lg cursor-pointer inline-block hover:shadow-md transition-all">
                        Choisir une image
                    </label>
                    <p class="text-[10px] text-slate-300 mt-2">Format 1200×628px — Max 2MB</p>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
