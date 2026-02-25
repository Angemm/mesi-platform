@extends('layouts.admin')
@section('title', 'Dons — Admin')
@section('page-title', 'Gestion des Dons')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['fas fa-heart','#C47D0A','rgba(232,160,32,.1)',number_format($stats['total_dons'] ?? 0).' FCFA','Total collecté'],
        ['fas fa-calendar-check','#2D6A27','rgba(74,140,63,.1)',$stats['dons_mois'] ?? 0,'Dons ce mois'],
        ['fas fa-users','#7B4A1E','rgba(123,74,30,.1)',$stats['donateurs'] ?? 0,'Donateurs'],
        ['fas fa-globe','#2D6A27','rgba(74,140,63,.1)',$stats['missions_financees'] ?? 0,'Missions financées'],
    ] as [$icon,$color,$bg,$val,$label])
    <div class="bg-white rounded-2xl border border-slate-100 p-4 flex items-center gap-3 shadow-sm">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $bg }};">
            <i class="{{ $icon }}" style="color:{{ $color }};"></i>
        </div>
        <div>
            <div class="font-black text-slate-900 text-lg leading-tight">{{ $val }}</div>
            <div class="text-xs text-slate-400">{{ $label }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- Filtres --}}
<div class="bg-white rounded-2xl border border-slate-100 p-4 mb-6">
    <form method="GET" action="{{ route('admin.dons.index') }}" class="flex flex-wrap gap-3 items-center">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Chercher donateur…"
               class="flex-1 min-w-40 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none">
        <select name="mission" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none">
            <option value="">Toutes les missions</option>
            @foreach(\App\Models\Mission::orderBy('nom')->get() as $m)
            <option value="{{ $m->id }}" {{ request('mission') == $m->id ? 'selected' : '' }}>{{ $m->nom }}</option>
            @endforeach
        </select>
        <input type="month" name="mois" value="{{ request('mois') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none">
        <button type="submit" class="px-5 py-2.5 rounded-xl text-white text-sm font-bold" style="background:#2D6A27;">
            <i class="fas fa-search mr-1"></i> Filtrer
        </button>
    </form>
</div>

<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
    <table class="w-full text-sm">
        <thead>
            <tr style="background:#F8F6F2;">
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500">Donateur</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden md:table-cell">Mission</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500">Montant</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden lg:table-cell">Méthode</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden xl:table-cell">Date</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500">Statut</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($dons as $don)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-5 py-4">
                    <p class="font-bold text-slate-900">{{ $don->nom_donateur ?? 'Anonyme' }}</p>
                    <p class="text-xs text-slate-400">{{ $don->email_donateur ?? '' }}</p>
                </td>
                <td class="px-5 py-4 text-slate-600 hidden md:table-cell text-xs">{{ $don->mission?->nom ?? 'Don général' }}</td>
                <td class="px-5 py-4">
                    <span class="font-black" style="color:#C47D0A;">{{ number_format($don->montant) }}</span>
                    <span class="text-xs text-slate-400"> FCFA</span>
                </td>
                <td class="px-5 py-4 text-slate-500 text-xs hidden lg:table-cell">{{ $don->methode_paiement ?? '—' }}</td>
                <td class="px-5 py-4 text-slate-400 text-xs hidden xl:table-cell">{{ $don->created_at->isoFormat('D MMM YYYY') }}</td>
                <td class="px-5 py-4">
                    @php $statut = $don->statut ?? 'confirme'; @endphp
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black
                        {{ $statut === 'confirme' ? 'bg-green-100 text-green-700' : ($statut === 'en_attente' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-600') }}">
                        {{ ucfirst($statut) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-12 text-slate-400">
                <i class="fas fa-heart text-3xl mb-2 block text-slate-200"></i> Aucun don enregistré.
            </td></tr>
            @endforelse
        </tbody>
    </table>
    @if(isset($dons) && $dons->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $dons->links() }}</div>
    @endif
</div>

@endsection
