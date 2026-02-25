@extends('layouts.admin')
@section('title', 'Événements — Admin')
@section('page-title', 'Événements')

@section('content')

<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <form method="GET" action="{{ route('admin.evenements.index') }}" class="flex gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher…"
               class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none w-64">
        <button type="submit" class="px-4 py-2.5 rounded-xl text-white text-sm" style="background:#2D6A27;"><i class="fas fa-search"></i></button>
    </form>
    <a href="{{ route('admin.evenements.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-bold" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
        <i class="fas fa-plus"></i> Nouvel Événement
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
    <table class="w-full text-sm">
        <thead>
            <tr style="background:#F8F6F2;">
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500">Événement</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden md:table-cell">Date</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden lg:table-cell">Lieu</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden md:table-cell">Type</th>
                <th class="text-right px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($evenements as $evt)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-5 py-4">
                    <p class="font-bold text-slate-900">{{ Str::limit($evt->titre, 40) }}</p>
                    @if($evt->heure)<p class="text-xs text-slate-400"><i class="fas fa-clock mr-1"></i>{{ $evt->heure }}</p>@endif
                </td>
                <td class="px-5 py-4 hidden md:table-cell">
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-lg flex flex-col items-center justify-center text-center flex-shrink-0" style="background:#1C3A18;">
                            <span class="font-bold text-base leading-none" style="color:#E8A020;">{{ \Carbon\Carbon::parse($evt->date_debut)->format('d') }}</span>
                            <span class="text-[9px] uppercase" style="color:rgba(255,255,255,.5);">{{ \Carbon\Carbon::parse($evt->date_debut)->isoFormat('MMM') }}</span>
                        </div>
                        <span class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($evt->date_debut)->format('Y') }}</span>
                    </div>
                </td>
                <td class="px-5 py-4 text-slate-500 text-xs hidden lg:table-cell">{{ $evt->lieu ?? 'Église principale' }}</td>
                <td class="px-5 py-4 hidden md:table-cell">
                    @if($evt->type)
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black" style="background:rgba(74,140,63,.1);color:#2D6A27;">{{ $evt->type }}</span>
                    @endif
                </td>
                <td class="px-5 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.evenements.edit', $evt) }}" class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                            <i class="fas fa-pen text-xs"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.evenements.destroy', $evt) }}" onsubmit="return confirm('Supprimer ?')">
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
                <i class="fas fa-calendar-times text-3xl mb-2 block text-slate-200"></i> Aucun événement planifié.
            </td></tr>
            @endforelse
        </tbody>
    </table>
    @if(isset($evenements) && $evenements->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $evenements->links() }}</div>
    @endif
</div>

@endsection
