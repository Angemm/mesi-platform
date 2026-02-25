@extends('layouts.admin')
@section('title', 'Cultes & Live — Admin')
@section('page-title', 'Cultes & Live')

@section('content')

{{-- HEADER ACTIONS --}}
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div class="flex gap-2">
        @foreach([['','Tous'],['live','En Direct'],['a_venir','À Venir'],['replay','Replays']] as [$val,$label])
        <a href="{{ request()->fullUrlWithQuery(['statut'=>$val]) }}"
           class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ request('statut',$val==='' ? '' : 'x') === $val ? 'text-white' : 'text-slate-500 bg-white border border-slate-200 hover:border-slate-300' }}"
           style="{{ request('statut',$val==='' ? '' : 'x') === $val ? 'background:linear-gradient(135deg,#4A8C3F,#2D6A27);' : '' }}">{{ $label }}</a>
        @endforeach
    </div>
    <a href="{{ route('admin.cultes.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-bold"
       style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
        <i class="fas fa-plus"></i> Nouveau Culte
    </a>
</div>

{{-- SEARCH --}}
<div class="bg-white rounded-2xl border border-slate-100 p-4 mb-6">
    <form method="GET" action="{{ route('admin.cultes.index') }}" class="flex gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un culte…"
               class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2" style="--tw-ring-color:rgba(74,140,63,.4);">
        <button type="submit" class="px-5 py-2.5 rounded-xl text-white text-sm font-bold" style="background:#2D6A27;">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

{{-- TABLE --}}
<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
    <table class="w-full text-sm">
        <thead>
            <tr style="background:#F8F6F2;">
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500">Culte</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden md:table-cell">Date</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden lg:table-cell">Prédicateur</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500">Statut</th>
                <th class="text-right px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($cultes as $culte)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0">
                            <img src="{{ $culte->image ? asset('storage/'.$culte->image) : asset('images/default-culte.jpg') }}" alt="" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">{{ Str::limit($culte->titre, 35) }}</p>
                            @if($culte->heure)<p class="text-xs text-slate-400">{{ $culte->heure }}</p>@endif
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 text-slate-600 hidden md:table-cell">{{ \Carbon\Carbon::parse($culte->date_culte)->isoFormat('D MMM YYYY') }}</td>
                <td class="px-5 py-4 text-slate-600 hidden lg:table-cell">{{ $culte->predicateur ?? '—' }}</td>
                <td class="px-5 py-4">
                    @if($culte->est_live)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black bg-red-100 text-red-600"><span class="live-dot w-1.5 h-1.5"></span> LIVE</span>
                    @elseif($culte->est_a_venir)
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black text-white" style="background:linear-gradient(135deg,#F4BC55,#E8A020);">À VENIR</span>
                    @else
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black text-white" style="background:#2D6A27;">REPLAY</span>
                    @endif
                </td>
                <td class="px-5 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.cultes.edit', $culte) }}" class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                            <i class="fas fa-pen text-xs"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.cultes.destroy', $culte) }}" onsubmit="return confirm('Supprimer ce culte ?')">
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
                <i class="fas fa-broadcast-tower text-3xl mb-2 block text-slate-200"></i> Aucun culte enregistré.
            </td></tr>
            @endforelse
        </tbody>
    </table>
    @if(isset($cultes) && $cultes->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $cultes->links() }}</div>
    @endif
</div>

@endsection
