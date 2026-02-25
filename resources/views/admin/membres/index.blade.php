@extends('layouts.admin')
@section('title', 'Membres — Admin')
@section('page-title', 'Membres')

@section('content')

<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <form method="GET" action="{{ route('admin.membres.index') }}" class="flex gap-3 flex-1 max-w-lg">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Nom, prénom, email…"
               class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none">
        <select name="departement" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm bg-white focus:outline-none">
            <option value="">Tous les départements</option>
            @foreach(\App\Models\Departement::all() as $d)
            <option value="{{ $d->id }}" {{ request('departement') == $d->id ? 'selected' : '' }}>{{ $d->nom }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2.5 rounded-xl text-white text-sm" style="background:#2D6A27;"><i class="fas fa-search"></i></button>
    </form>
    <a href="{{ route('admin.membres.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-bold" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
        <i class="fas fa-plus"></i> Nouveau Membre
    </a>
</div>

{{-- Stats rapides --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['fas fa-users','#2D6A27','rgba(74,140,63,.1)',$membres->total() ?? 0,'Total membres'],
        ['fas fa-user-check','#C47D0A','rgba(232,160,32,.1)',$actifs ?? 0,'Actifs'],
        ['fas fa-layer-group','#7B4A1E','rgba(123,74,30,.1)',$departements ?? 0,'Départements'],
        ['fas fa-user-tie','#2D6A27','rgba(74,140,63,.1)',$dirigeants ?? 0,'Dirigeants'],
    ] as [$icon,$color,$bg,$val,$label])
    <div class="bg-white rounded-2xl border border-slate-100 p-4 flex items-center gap-3 shadow-sm">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $bg }};">
            <i class="{{ $icon }}" style="color:{{ $color }};"></i>
        </div>
        <div>
            <div class="font-black text-slate-900 text-xl">{{ $val }}</div>
            <div class="text-xs text-slate-400">{{ $label }}</div>
        </div>
    </div>
    @endforeach
</div>

<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
    <table class="w-full text-sm">
        <thead>
            <tr style="background:#F8F6F2;">
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500">Membre</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden md:table-cell">Rôle</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden lg:table-cell">Département</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden xl:table-cell">Téléphone</th>
                <th class="text-right px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($membres as $membre)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full overflow-hidden flex-shrink-0" style="background:rgba(74,140,63,.15);">
                            @if($membre->photo)
                                <img src="{{ asset('storage/'.$membre->photo) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center font-black text-sm" style="color:#2D6A27;">{{ strtoupper(substr($membre->prenom ?? 'M', 0, 1)) }}</div>
                            @endif
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">{{ $membre->prenom }} {{ $membre->nom }}</p>
                            <p class="text-xs text-slate-400">{{ $membre->email ?? '' }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 text-slate-600 hidden md:table-cell">{{ $membre->role_eglise ?? '—' }}</td>
                <td class="px-5 py-4 hidden lg:table-cell">
                    @if($membre->departement)
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black" style="background:rgba(74,140,63,.1);color:#2D6A27;">{{ $membre->departement->nom }}</span>
                    @else
                    <span class="text-slate-400">—</span>
                    @endif
                </td>
                <td class="px-5 py-4 text-slate-600 text-xs hidden xl:table-cell">{{ $membre->telephone ?? '—' }}</td>
                <td class="px-5 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.membres.edit', $membre) }}" class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                            <i class="fas fa-pen text-xs"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.membres.destroy', $membre) }}" onsubmit="return confirm('Supprimer ce membre ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-12 text-slate-400">
                <i class="fas fa-users text-3xl mb-2 block text-slate-200"></i> Aucun membre enregistré.
            </td></tr>
            @endforelse
        </tbody>
    </table>
    @if(isset($membres) && $membres->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $membres->links() }}</div>
    @endif
</div>

@endsection
