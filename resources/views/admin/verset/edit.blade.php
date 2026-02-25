@extends('layouts.admin')
@section('title', 'Verset du Jour — Admin')
@section('page-title', 'Verset du Jour')

@section('content')

<div class="max-w-2xl">

    {{-- Preview --}}
    <div class="relative mb-6 py-10 px-8 rounded-2xl text-center overflow-hidden" style="background:linear-gradient(135deg,#2D6A27,#1C3A18);">
        <div class="absolute top-2 left-1/2 -translate-x-1/2 font-serif leading-none select-none pointer-events-none text-8xl" style="color:rgba(232,160,32,.08);">"</div>
        <p class="font-serif italic text-white text-lg leading-relaxed mb-3 relative z-10" id="versetPreview">
            {{ $verset->texte ?? "pour le perfectionnement des saints en vue de l'œuvre du ministère et de l'édification du corps de Christ," }}
        </p>
        <span class="font-black text-sm uppercase tracking-widest relative z-10" style="color:#E8A020;" id="refPreview">— {{ $verset->reference ?? 'Ephésiens 4:12' }}</span>
    </div>

    {{-- Formulaire --}}
    <form method="POST" action="{{ route('admin.verset.update') }}" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        @csrf @method('PUT')

        <div class="space-y-5">
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Texte du verset *</label>
                <textarea name="texte" id="texteInput" rows="4" required
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none resize-none"
                          oninput="document.getElementById('versetPreview').textContent = this.value"
                          placeholder="Tapez le texte du verset biblique…">{{ old('texte', $verset->texte ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Référence *</label>
                <input type="text" name="reference" id="refInput" value="{{ old('reference', $verset->reference ?? '') }}" required
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none"
                       oninput="document.getElementById('refPreview').textContent = '— ' + this.value"
                       placeholder="Ex: Ephésiens 4:12">
            </div>
            <div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="actif" value="1" {{ old('actif', $verset->actif ?? true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded" style="accent-color:#2D6A27;">
                    <span class="text-sm font-bold text-slate-700">Afficher ce verset sur le site</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl text-white font-bold" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
                <i class="fas fa-save mr-2"></i> Enregistrer le verset
            </button>
        </div>
    </form>

    {{-- Suggestions --}}
    <div class="mt-6 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-900 mb-4 text-sm">Suggestions de versets</h3>
        <div class="space-y-3">
            @foreach([
                ['Jean 3:16','Car Dieu a tant aimé le monde qu\'il a donné son Fils unique, afin que quiconque croit en lui ne périsse point, mais qu\'il ait la vie éternelle.'],
                ['Philippiens 4:13','Je puis tout par celui qui me fortifie.'],
                ['Josué 1:9','Sois fort et courageux. N\'aie pas peur et ne t\'effraie pas, car l\'Éternel, ton Dieu, est avec toi dans tout ce que tu entreprendras.'],
                ['Romains 8:28','Nous savons, du reste, que toutes choses concourent au bien de ceux qui aiment Dieu.'],
            ] as [$ref,$texte])
            <button type="button" onclick="setVerset('{{ addslashes($texte) }}', '{{ $ref }}')"
                    class="w-full text-left p-4 rounded-xl border border-slate-100 hover:border-green-200 hover:bg-green-50 transition-all group">
                <p class="font-serif italic text-slate-600 text-xs leading-relaxed">"{{ Str::limit($texte, 100) }}"</p>
                <span class="text-[10px] font-black uppercase tracking-widest mt-1 block" style="color:#C47D0A;">{{ $ref }}</span>
            </button>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
function setVerset(texte, ref) {
    document.getElementById('texteInput').value = texte;
    document.getElementById('refInput').value = ref;
    document.getElementById('versetPreview').textContent = texte;
    document.getElementById('refPreview').textContent = '— ' + ref;
}
</script>
@endpush

@endsection
