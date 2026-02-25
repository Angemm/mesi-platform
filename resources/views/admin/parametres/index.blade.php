@extends('layouts.admin')
@section('title', 'Paramètres — Admin')
@section('page-title', 'Paramètres du site')

@section('content')

<form method="POST" action="{{ route('admin.parametres.update') }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- INFOS GÉNÉRALES --}}
        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-5 pb-4 border-b border-slate-100">Informations de l'église</h3>
                <div class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Nom de l'église</label>
                            <input type="text" name="nom_eglise" value="{{ old('nom_eglise', config('mesi.nom_eglise', 'Mission Évangélique Sion')) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Sigle</label>
                            <input type="text" name="sigle" value="{{ old('sigle', config('mesi.sigle', 'M.E.SI')) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Adresse</label>
                        <input type="text" name="adresse" value="{{ old('adresse', config('mesi.adresse', '')) }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="Adresse complète de l'église">
                    </div>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Téléphone</label>
                            <input type="text" name="telephone" value="{{ old('telephone', config('mesi.telephone', '')) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="+225 XX XX XX XX">
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', config('mesi.email', '')) }}"
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Description / Slogan</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none resize-none"
                                  placeholder="Courte description de l'église…">{{ old('description', config('mesi.description', '')) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Réseaux sociaux --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-5 pb-4 border-b border-slate-100">Réseaux sociaux</h3>
                <div class="space-y-4">
                    @foreach([
                        ['facebook','fab fa-facebook','#1877F2','Lien page Facebook'],
                        ['youtube','fab fa-youtube','#FF0000','Lien chaîne YouTube'],
                        ['instagram','fab fa-instagram','#E4405F','Lien profil Instagram'],
                        ['whatsapp','fab fa-whatsapp','#25D366','Numéro WhatsApp (format international)'],
                    ] as [$key,$icon,$color,$placeholder])
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $color }};">
                            <i class="{{ $icon }} text-white text-sm"></i>
                        </div>
                        <input type="text" name="{{ $key }}" value="{{ old($key, config('mesi.'.$key, '')) }}"
                               class="flex-1 px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="{{ $placeholder }}">
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- SEO --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-5 pb-4 border-b border-slate-100">SEO & Méta</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Titre SEO</label>
                        <input type="text" name="seo_titre" value="{{ old('seo_titre', config('mesi.seo_titre', '')) }}"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Description SEO</label>
                        <textarea name="seo_description" rows="2" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none resize-none">{{ old('seo_description', config('mesi.seo_description', '')) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div class="space-y-5">

            {{-- Logo --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-4 text-sm">Logo de l'église</h3>
                <div class="flex flex-col items-center mb-4">
                    <div class="w-24 h-24 rounded-2xl overflow-hidden shadow-md" style="background:#F8F6F2;">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-full h-full object-contain" id="logoPreview">
                    </div>
                </div>
                <label>
                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center cursor-pointer hover:border-green-400 transition-colors">
                        <i class="fas fa-image text-xl mb-1 block" style="color:#4A8C3F;"></i>
                        <p class="text-xs text-slate-400">Remplacer le logo</p>
                    </div>
                    <input type="file" name="logo" accept="image/*" class="hidden" onchange="document.getElementById('logoPreview').src=URL.createObjectURL(this.files[0])">
                </label>
            </div>

            {{-- Stats site --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-4 text-sm">Statistiques affichées</h3>
                <p class="text-xs text-slate-400 mb-4">Ces chiffres apparaissent dans la barre de stats de la page d'accueil.</p>
                <div class="space-y-3">
                    @foreach([['membres','Membres'],['cultes','Cultes diffusés'],['missions','Missions actives'],['annees','Années d\'histoire']] as [$k,$l])
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-1.5">{{ $l }}</label>
                        <input type="number" name="stats[{{ $k }}]" value="{{ old('stats.'.$k, $stats[$k] ?? 0) }}"
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none">
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Save --}}
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <button type="submit" class="w-full py-3.5 rounded-xl text-white font-bold text-sm" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
                    <i class="fas fa-save mr-2"></i> Enregistrer les paramètres
                </button>
            </div>
        </div>
    </div>
</form>

@endsection
