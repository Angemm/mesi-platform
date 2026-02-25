@extends('layouts.admin')
@section('title', 'Sermons — Admin')
@section('page-title', 'Sermons')

@section('content')

<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <form method="GET" action="{{ route('admin.sermons.index') }}" class="flex gap-3 flex-1 max-w-md">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un sermon…"
               class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none">
        <button type="submit" class="px-4 py-2.5 rounded-xl text-white text-sm" style="background:#2D6A27;"><i class="fas fa-search"></i></button>
    </form>
    <a href="{{ route('admin.sermons.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-bold" style="background:linear-gradient(135deg,#F4BC55,#E8A020,#C47D0A);">
        <i class="fas fa-plus"></i> Nouveau Sermon
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
    <table class="w-full text-sm">
        <thead>
            <tr style="background:#F8F6F2;">
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500">Sermon</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden md:table-cell">Prédicateur</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden lg:table-cell">Série</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden md:table-cell">Date</th>
                <th class="text-right px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($sermons as $sermon)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0" style="background:#F8F6F2;">
                            <img src="{{ $sermon->image ? asset('storage/'.$sermon->image) : asset('images/default-sermon.jpg') }}" alt="" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="font-bold text-slate-900">{{ Str::limit($sermon->titre, 35) }}</p>
                            @if($sermon->reference_biblique)<p class="text-xs text-slate-400">{{ $sermon->reference_biblique }}</p>@endif
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 text-slate-600 hidden md:table-cell">{{ $sermon->predicateur ?? '—' }}</td>
                <td class="px-5 py-4 hidden lg:table-cell">
                    @if($sermon->serie)
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black" style="background:rgba(232,160,32,.1);color:#C47D0A;">{{ $sermon->serie->nom }}</span>
                    @else <span class="text-slate-400">—</span> @endif
                </td>
                <td class="px-5 py-4 text-slate-400 text-xs hidden md:table-cell">
                    {{ $sermon->date_sermon ? \Carbon\Carbon::parse($sermon->date_sermon)->isoFormat('D MMM YYYY') : '—' }}
                </td>
                <td class="px-5 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('sermons.show', $sermon->slug) }}" target="_blank" class="p-2 rounded-lg text-slate-400 hover:text-green-600 hover:bg-green-50 transition-colors">
                            <i class="fas fa-external-link-alt text-xs"></i>
                        </a>
                        <a href="{{ route('admin.sermons.edit', $sermon) }}" class="p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                            <i class="fas fa-pen text-xs"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.sermons.destroy', $sermon) }}" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors"><i class="fas fa-trash text-xs"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-12 text-slate-400">
                <i class="fas fa-bible text-3xl mb-2 block text-slate-200"></i> Aucun sermon enregistré.
            </td></tr>
            @endforelse
        </tbody>
    </table>
    @if(isset($sermons) && $sermons->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $sermons->links() }}</div>
    @endif
</div>

@endsection
