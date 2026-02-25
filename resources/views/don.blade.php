@extends('layouts.app')
@section('title', 'Faire un Don — M.E.SI')

@section('content')

<div class="navy-gradient py-20 text-center relative overflow-hidden">
    <div class="absolute inset-0" style="background-image:radial-gradient(circle,rgba(232,176,75,.07) 1px,transparent 1px);background-size:40px 40px;"></div>
    <div class="relative z-10">
        <div class="w-16 h-16 gold-gradient rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-gold/30">
            <i class="fas fa-heart text-white text-xl"></i>
        </div>
        <span class="text-gold font-black text-xs uppercase tracking-widest">Soutien financier</span>
        <h1 class="font-serif font-black text-white mt-3 mb-3" style="font-size:clamp(2rem,4vw,3rem)">Soutenez l'Œuvre de Dieu</h1>
        <p class="text-white/65 max-w-lg mx-auto text-sm leading-relaxed">Vos dons permettent de financer les missions, soutenir les familles et faire avancer l'Évangile.</p>
    </div>
</div>

<section class="py-20 bg-slate-50">
<div class="max-w-3xl mx-auto px-6">

    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-100 p-8 md:p-10">
        <h2 class="font-serif font-black text-slate-900 text-2xl mb-8">Faire un Don</h2>

        <form method="POST" action="{{ route('don.store') }}" class="space-y-6">
            @csrf

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">Nom complet *</label>
                    <input type="text" name="donateur_nom" value="{{ old('donateur_nom') }}" required placeholder="Votre nom"
                           class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/10 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">Téléphone</label>
                    <input type="tel" name="donateur_telephone" value="{{ old('donateur_telephone') }}" placeholder="+225 XX XX XX XX"
                           class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white transition-all">
                </div>
            </div>

            <div>
                <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">Email</label>
                <input type="email" name="donateur_email" value="{{ old('donateur_email') }}" placeholder="votre@email.com"
                       class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white transition-all">
            </div>

            {{-- Montant --}}
            <div>
                <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-3">Montant (FCFA) *</label>
                <div class="grid grid-cols-4 gap-3 mb-3">
                    @foreach([5000, 10000, 25000, 50000] as $m)
                    <button type="button" onclick="setMontant({{ $m }})"
                            class="montant-btn py-3 rounded-xl border-2 border-slate-200 text-sm font-black text-slate-600 hover:border-gold hover:text-gold-dark transition-all">
                        {{ number_format($m) }}
                    </button>
                    @endforeach
                </div>
                <input type="number" name="montant" id="montantInput" value="{{ old('montant', request('montant') ?? '') }}" required min="500" placeholder="Autre montant…"
                       class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/10 transition-all font-bold text-lg">
                <p class="text-xs text-slate-400 mt-1.5">Montant minimum : 500 FCFA</p>
            </div>

            @if($missions->count() > 0)
            <div>
                <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">Affecter à une mission (optionnel)</label>
                <select name="mission_id" class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 transition-all appearance-none">
                    <option value="">— Don général à l'église —</option>
                    @foreach($missions as $mission)
                    <option value="{{ $mission->id }}" {{ (old('mission_id') == $mission->id || request('mission') == $mission->id) ? 'selected' : '' }}>
                        {{ $mission->nom }} ({{ $mission->pays ?? $mission->region }})
                    </option>
                    @endforeach
                </select>
            </div>
            @endif

            <div>
                <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-2">Motif</label>
                <input type="text" name="motif" value="{{ old('motif') }}" placeholder="Dîme, Offrande, Soutien mission…"
                       class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-gold/60 focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-xs font-black text-slate-500 uppercase tracking-wider mb-3">Méthode de paiement *</label>
                <div class="grid sm:grid-cols-3 gap-3">
                    @foreach(['mobile-money' => ['fas fa-mobile-alt','Mobile Money'], 'orange-money' => ['fab fa-orange','Orange Money'], 'virement' => ['fas fa-university','Virement Bancaire']] as $val => [$icon, $label])
                    <label class="flex flex-col items-center gap-2 p-4 rounded-xl border-2 border-slate-200 cursor-pointer hover:border-gold/50 transition-all has-[:checked]:border-gold has-[:checked]:bg-gold/5">
                        <input type="radio" name="methode_paiement" value="{{ $val }}" class="sr-only" {{ old('methode_paiement') == $val ? 'checked' : '' }}>
                        <i class="{{ $icon }} text-xl text-slate-400 has-checked:text-gold-dark"></i>
                        <span class="text-xs font-bold text-slate-600 text-center">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full gold-gradient text-white py-4 rounded-xl font-bold text-base flex items-center justify-center gap-3 shadow-xl shadow-gold/30 hover:shadow-gold/50 hover:-translate-y-0.5 transition-all">
                <i class="fas fa-heart"></i> Confirmer mon Don
            </button>
        </form>
    </div>

    {{-- Verset encouragement --}}
    <div class="mt-10 text-center">
        <p class="font-serif italic text-slate-500 text-lg">"Chacun donnera selon ce qu'il a résolu en son cœur, sans tristesse ni contrainte ; car Dieu aime celui qui donne avec joie."</p>
        <span class="text-gold-dark font-black text-sm uppercase tracking-wider mt-2 block">— 2 Corinthiens 9:7</span>
    </div>
</div>
</section>

@endsection

@push('scripts')
<script>
function setMontant(m) {
    document.getElementById('montantInput').value = m;
    document.querySelectorAll('.montant-btn').forEach(btn => {
        const active = btn.textContent.trim().replace(/\s/g,'') === m.toLocaleString('fr-FR').replace(/\s/g,'');
        btn.classList.toggle('border-gold', active);
        btn.classList.toggle('text-gold-dark', active);
        btn.classList.toggle('bg-gold/5', active);
        btn.classList.toggle('border-slate-200', !active);
        btn.classList.toggle('text-slate-600', !active);
    });
}
</script>
@endpush
