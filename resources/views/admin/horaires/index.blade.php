@extends('layouts.admin')
@section('title', 'Horaires — Admin')
@section('page-title', 'Horaires des Cultes')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900">Gérer les horaires</h3>
                <p class="text-xs text-slate-400 mt-0.5">Ces horaires s'affichent sur le site public.</p>
            </div>
            <button id="addHoraire" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-bold" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
                <i class="fas fa-plus"></i> Ajouter
            </button>
        </div>

        <form method="POST" action="{{ route('admin.horaires.update') }}">
            @csrf @method('PUT')

            <div id="horairesContainer" class="divide-y divide-slate-50">
                @foreach($horaires as $i => $h)
                <div class="horaire-row p-5 flex items-center gap-4" data-index="{{ $i }}">
                    <div class="flex items-center gap-1 text-slate-300 cursor-grab">
                        <i class="fas fa-grip-vertical text-sm"></i>
                    </div>
                    <div class="flex-1 grid grid-cols-3 gap-3">
                        <div>
                            <select name="horaires[{{ $i }}][jour]" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none">
                                @foreach(['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $j)
                                <option value="{{ $j }}" {{ $h->jour === $j ? 'selected' : '' }}>{{ $j }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <input type="time" name="horaires[{{ $i }}][heure]" value="{{ $h->heure }}"
                                   class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none">
                        </div>
                        <div>
                            <input type="text" name="horaires[{{ $i }}][type_culte]" value="{{ $h->type_culte }}"
                                   class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="Ex: Culte principal">
                        </div>
                    </div>
                    <input type="hidden" name="horaires[{{ $i }}][id]" value="{{ $h->id }}">
                    <label class="flex items-center gap-1.5 cursor-pointer flex-shrink-0">
                        <input type="checkbox" name="horaires[{{ $i }}][actif]" value="1" {{ $h->actif ? 'checked' : '' }}
                               class="w-4 h-4 rounded" style="accent-color:#2D6A27;">
                        <span class="text-xs text-slate-500">Actif</span>
                    </label>
                    <button type="button" class="remove-horaire p-2 rounded-lg text-slate-300 hover:text-red-500 hover:bg-red-50 transition-colors flex-shrink-0">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                @endforeach
            </div>

            <div class="p-5 border-t border-slate-100">
                <button type="submit" class="w-full py-3 rounded-xl text-white font-bold text-sm" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
                    <i class="fas fa-save mr-2"></i> Enregistrer les horaires
                </button>
            </div>
        </form>
    </div>

    {{-- Preview --}}
    <div class="mt-6 bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-900 mb-4 text-sm">Aperçu (site public)</h3>
        <div class="rounded-2xl p-5 border" style="background:rgba(74,140,63,.05);border-color:rgba(74,140,63,.2);">
            @foreach($horaires->where('actif', true) as $h)
            <div class="flex justify-between items-center py-3 border-b last:border-b-0" style="border-color:rgba(74,140,63,.15);">
                <div>
                    <span class="font-bold text-slate-900 text-sm">{{ $h->jour }}</span>
                    @if($h->type_culte)<span class="text-xs text-slate-400 ml-2">{{ $h->type_culte }}</span>@endif
                </div>
                <span class="font-black text-sm" style="color:#C47D0A;">{{ $h->heure }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
let rowCount = {{ $horaires->count() }};

document.getElementById('addHoraire').addEventListener('click', () => {
    const container = document.getElementById('horairesContainer');
    const jours = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
    const options = jours.map(j => `<option value="${j}">${j}</option>`).join('');
    const row = document.createElement('div');
    row.className = 'horaire-row p-5 flex items-center gap-4';
    row.innerHTML = `
        <div class="flex items-center gap-1 text-slate-300 cursor-grab"><i class="fas fa-grip-vertical text-sm"></i></div>
        <div class="flex-1 grid grid-cols-3 gap-3">
            <select name="horaires[${rowCount}][jour]" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm bg-white">${options}</select>
            <input type="time" name="horaires[${rowCount}][heure]" value="09:00" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm">
            <input type="text" name="horaires[${rowCount}][type_culte]" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm" placeholder="Type de culte">
        </div>
        <label class="flex items-center gap-1.5 cursor-pointer flex-shrink-0">
            <input type="checkbox" name="horaires[${rowCount}][actif]" value="1" checked class="w-4 h-4 rounded">
            <span class="text-xs text-slate-500">Actif</span>
        </label>
        <button type="button" class="remove-horaire p-2 rounded-lg text-slate-300 hover:text-red-500 hover:bg-red-50 transition-colors flex-shrink-0"><i class="fas fa-times text-xs"></i></button>
    `;
    container.appendChild(row);
    rowCount++;
    bindRemove(row.querySelector('.remove-horaire'));
});

function bindRemove(btn) {
    btn.addEventListener('click', () => btn.closest('.horaire-row').remove());
}
document.querySelectorAll('.remove-horaire').forEach(btn => bindRemove(btn));
</script>
@endpush

@endsection
