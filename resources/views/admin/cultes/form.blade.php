@extends('layouts.admin')
@section('title', isset($culte) ? 'Modifier le Culte' : 'Nouveau Culte')
@section('page-title', isset($culte) ? 'Modifier le Culte' : 'Créer un Culte')

@section('content')

<form method="POST" action="{{ isset($culte) ? route('admin.cultes.update', $culte->id) : route('admin.cultes.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($culte)) @method('PUT') @endif

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- Colonne principale --}}
        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h3 class="font-serif font-bold text-navy mb-5 flex items-center gap-2"><i class="fas fa-info-circle text-gold text-sm"></i> Informations</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">Titre *</label>
                        <input type="text" name="titre" value="{{ old('titre', $culte->titre ?? '') }}" required
                               placeholder="Ex: Culte du Dimanche — La Grâce de Dieu"
                               class="w-full border @error('titre') border-red-300 bg-red-50 @else border-slate-200 bg-slate-50 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/10 transition-all font-bold text-base">
                        @error('titre')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">Date *</label>
                            <input type="date" name="date_culte" value="{{ old('date_culte', isset($culte) ? $culte->date_culte->format('Y-m-d') : '') }}" required
                                   class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/10 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">Heure</label>
                            <input type="text" name="heure" value="{{ old('heure', $culte->heure ?? '09:00') }}" placeholder="09:00"
                                   class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/10 transition-all">
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">Prédicateur</label>
                            <input type="text" name="predicateur" value="{{ old('predicateur', $culte->predicateur ?? '') }}" placeholder="Pasteur Jean Martin"
                                   class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/10 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">Passage Biblique</label>
                            <input type="text" name="passage_biblique" value="{{ old('passage_biblique', $culte->passage_biblique ?? '') }}" placeholder="Jean 3:16"
                                   class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/10 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">Type de culte *</label>
                        <select name="type" class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white transition-all appearance-none">
                            @foreach(['culte-principal'=>'Culte Principal','etude-biblique'=>'Étude Biblique','jeunesse'=>'Jeunesse','priere'=>'Nuit de Prière','famille'=>'Culte Famille','autre'=>'Autre'] as $v=>$l)
                            <option value="{{ $v }}" {{ old('type', $culte->type ?? 'culte-principal') == $v ? 'selected' : '' }}>{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">Description</label>
                        <textarea name="description" rows="4" placeholder="Résumé du culte, thème abordé…"
                                  class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/10 transition-all resize-none">{{ old('description', $culte->description ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Diffusion --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h3 class="font-serif font-bold text-navy mb-5 flex items-center gap-2"><i class="fas fa-broadcast-tower text-red-500 text-sm"></i> Diffusion & Vidéo</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">Lien YouTube Live / Replay</label>
                        <input type="url" name="lien_video" value="{{ old('lien_video', $culte->lien_video ?? '') }}" placeholder="https://www.youtube.com/watch?v=..."
                               class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white transition-all">
                        <p class="text-xs text-slate-400 mt-1.5">Collez l'URL YouTube pour la retransmission live ou le replay.</p>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        @foreach([['est_live','LIVE Maintenant','text-red-600 border-red-200 bg-red-50'],['est_a_venir','À Venir','text-gold-dark border-gold/30 bg-gold/5'],['publie','Publier','text-navy border-navy/20 bg-navy/5']] as [$name,$label,$style])
                        <label class="flex items-center gap-2.5 p-3.5 rounded-xl border {{ $style }} cursor-pointer hover:brightness-95 transition-all">
                            <input type="checkbox" name="{{ $name }}" value="1" {{ old($name, $culte->{$name} ?? false) ? 'checked' : '' }} class="w-4 h-4 rounded accent-current">
                            <span class="text-xs font-black">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Colonne latérale --}}
        <div class="space-y-5">

            {{-- Image --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h3 class="font-serif font-bold text-navy mb-4 text-sm flex items-center gap-2"><i class="fas fa-image text-gold text-sm"></i> Image</h3>

                @if(isset($culte) && $culte->image)
                <img src="{{ asset('storage/'.$culte->image) }}" class="w-full aspect-video object-cover rounded-xl mb-4 border border-slate-100" alt="Image actuelle">
                @endif

                <div id="imgDropzone" class="border-2 border-dashed border-slate-200 rounded-xl p-6 text-center cursor-pointer hover:border-gold/50 transition-colors">
                    <img id="imgPreviewThumb" class="hidden w-full aspect-video object-cover rounded-xl mb-3" alt="">
                    <i class="fas fa-cloud-upload-alt text-3xl text-slate-300 mb-2 block"></i>
                    <p class="text-xs text-slate-400 mb-3">Glisser-déposer ou cliquer</p>
                    <input type="file" name="image" accept="image/*" data-preview="imgPreviewThumb" class="hidden" id="imgInput">
                    <label for="imgInput" class="gold-gradient text-white text-xs font-bold px-4 py-2 rounded-lg cursor-pointer inline-block">Choisir une image</label>
                </div>
                <p class="text-[10px] text-slate-300 mt-2 text-center">JPG, PNG — max 2MB — 800×450px recommandé</p>
            </div>

            {{-- Actions --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-3">
                <button type="submit" class="w-full gold-gradient text-white py-3.5 rounded-xl font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-gold/25 hover:shadow-gold/40 hover:-translate-y-0.5 transition-all">
                    <i class="fas fa-save text-xs"></i> {{ isset($culte) ? 'Mettre à jour' : 'Créer le Culte' }}
                </button>
                <a href="{{ route('admin.cultes.index') }}" class="w-full border border-slate-200 text-slate-600 py-3 rounded-xl font-bold text-sm flex items-center justify-center gap-2 hover:bg-slate-50 transition-all">
                    <i class="fas fa-arrow-left text-xs"></i> Annuler
                </a>
            </div>
        </div>
    </div>
</form>

@endsection
