@extends('layouts.app')
@section('title','Contact — M.E.SI')

@section('content')

<div class="navy-gradient py-20 text-center relative overflow-hidden">
    <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(232,176,75,.07) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="relative z-10">
        <span class="text-gold font-black text-xs uppercase tracking-widest">Nous Rejoindre</span>
        <h1 class="font-serif font-black text-white mt-3 mb-3" style="font-size:clamp(2rem,4vw,3rem)">Contactez-nous</h1>
        <p class="text-white/65 max-w-lg mx-auto text-sm leading-relaxed">Nous serions heureux de vous accueillir. N'hésitez pas à nous écrire ou à nous rendre visite.</p>
    </div>
</div>

<section class="py-20 bg-slate-50">
<div class="max-w-7xl mx-auto px-6">
    <div class="grid lg:grid-cols-2 gap-14 items-start">

        {{-- Infos --}}
        <div class="reveal">
            <h2 class="font-serif font-black text-slate-900 text-3xl mb-4">Venez nous rendre visite</h2>
            <p class="text-slate-500 leading-relaxed mb-10">Nos portes sont ouvertes à tous, que vous cherchiez Dieu pour la première fois ou souhaitiez vous impliquer davantage.</p>

            <div class="space-y-5 mb-10">
                @foreach([
                    ['fas fa-map-marker-alt', 'Adresse', config('mesi.adresse','Votre adresse complète, Ville, Pays')],
                    ['fas fa-phone',           'Téléphone', config('mesi.telephone','+000 00 00 00 00')],
                    ['fas fa-envelope',        'Email', config('mesi.email','contact@mesi.org')],
                    ['fab fa-whatsapp',        'WhatsApp', config('mesi.whatsapp_numero','+000 00 00 00 00')],
                ] as [$icon,$label,$val])
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 bg-gold/10 rounded-xl flex items-center justify-center flex-shrink-0 text-gold-dark">
                        <i class="{{ $icon }}"></i>
                    </div>
                    <div>
                        <div class="text-xs font-black text-slate-400 uppercase tracking-wider mb-0.5">{{ $label }}</div>
                        <div class="text-slate-800 font-medium text-sm">{{ $val }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Horaires --}}
            <div class="bg-gold/5 border border-gold/15 rounded-2xl p-7 mb-8">
                <h3 class="font-serif font-bold text-slate-900 text-lg mb-5">
                    <i class="fas fa-clock text-gold mr-2"></i>Horaires des Cultes
                </h3>
                @foreach(\App\Models\HoraireCulte::actif()->orderBy('ordre')->get() as $h)
                <div class="flex justify-between items-center py-3 border-b border-gold/10 last:border-b-0">
                    <div>
                        <span class="font-bold text-slate-900 text-sm">{{ $h->jour }}</span>
                        @if($h->type_culte)<span class="text-xs text-slate-400 ml-2">{{ $h->type_culte }}</span>@endif
                    </div>
                    <span class="text-gold-dark font-black text-sm">{{ $h->heure }}</span>
                </div>
                @endforeach
            </div>

            {{-- Réseaux --}}
            <div>
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Suivez-nous</h4>
                <div class="flex gap-3">
                    @foreach([['mesi.facebook','fab fa-facebook','bg-blue-600'],['mesi.youtube','fab fa-youtube','bg-red-600'],['mesi.instagram','fab fa-instagram','bg-gradient-to-br from-pink-500 to-purple-600'],['mesi.whatsapp','fab fa-whatsapp','bg-green-500']] as [$key,$icon,$bg])
                    @if(config($key) && config($key) !== '#')
                    <a href="{{ config($key) }}" target="_blank" class="{{ $bg }} text-white w-10 h-10 rounded-xl flex items-center justify-center hover:scale-110 transition-transform shadow-sm">
                        <i class="{{ $icon }} text-sm"></i>
                    </a>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Formulaire --}}
        <div class="reveal" style="animation-delay:.15s">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-100 p-8 md:p-10">
                <h3 class="font-serif font-black text-slate-900 text-2xl mb-7">
                    <i class="fas fa-paper-plane text-gold mr-2.5"></i>Envoyer un message
                </h3>
                <form method="POST" action="{{ route('contact.store') }}" class="space-y-5">
                    @csrf

                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Nom complet *</label>
                            <input type="text" name="nom" value="{{ old('nom') }}" required placeholder="Votre nom"
                                   class="w-full border @error('nom') border-red-300 bg-red-50 @else border-slate-200 bg-slate-50 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/15 transition-all">
                            @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Téléphone</label>
                            <input type="tel" name="telephone" value="{{ old('telephone') }}" placeholder="+225 XX XX XX XX"
                                   class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/15 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="votre@email.com"
                               class="w-full border @error('email') border-red-300 bg-red-50 @else border-slate-200 bg-slate-50 @enderror rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/15 transition-all">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Sujet *</label>
                        <select name="sujet" required class="w-full border @error('sujet') border-red-300 @else border-slate-200 @enderror bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/15 transition-all appearance-none">
                            <option value="">— Sélectionnez un sujet —</option>
                            @foreach(["Demande d'information","Demande de prière","Counseling pastoral","Intégration à l'église","Partenariat / Mission","Autre"] as $s)
                            <option value="{{ $s }}" {{ old('sujet') == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                        @error('sujet')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Message *</label>
                        <textarea name="message" rows="5" required placeholder="Votre message..."
                                  class="w-full border @error('message') border-red-300 bg-red-50 @else border-slate-200 bg-slate-50 @enderror rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/15 transition-all">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="w-full gold-gradient text-white py-4 rounded-xl font-bold text-sm flex items-center justify-center gap-2.5 shadow-lg shadow-gold/30 hover:shadow-gold/50 hover:-translate-y-0.5 transition-all">
                        <i class="fas fa-paper-plane"></i> Envoyer le Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
