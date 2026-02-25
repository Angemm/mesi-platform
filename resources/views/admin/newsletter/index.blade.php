@extends('layouts.admin')
@section('title', 'Newsletter — Admin')
@section('page-title', 'Newsletter')

@section('content')

<div class="grid lg:grid-cols-3 gap-6">

    {{-- LISTE ABONNÉS --}}
    <div class="lg:col-span-2">

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4 mb-6">
            @foreach([
                ['fas fa-users','#2D6A27','rgba(74,140,63,.1)',$stats['total'] ?? 0,'Abonnés'],
                ['fas fa-check-circle','#C47D0A','rgba(232,160,32,.1)',$stats['actifs'] ?? 0,'Actifs'],
                ['fas fa-paper-plane','#7B4A1E','rgba(123,74,30,.1)',$stats['envois'] ?? 0,'Envois'],
            ] as [$icon,$color,$bg,$val,$label])
            <div class="bg-white rounded-2xl border border-slate-100 p-4 flex items-center gap-3 shadow-sm">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $bg }};"><i class="{{ $icon }}" style="color:{{ $color }};"></i></div>
                <div><div class="font-black text-slate-900 text-xl">{{ $val }}</div><div class="text-xs text-slate-400">{{ $label }}</div></div>
            </div>
            @endforeach
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
            <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-sm">Liste des abonnés</h3>
                <a href="{{ route('admin.newsletter.export') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border border-slate-200 text-slate-600 hover:bg-slate-50 transition-colors">
                    <i class="fas fa-download text-xs"></i> Exporter CSV
                </a>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr style="background:#F8F6F2;">
                        <th class="text-left px-5 py-3 text-xs font-black uppercase tracking-wider text-slate-500">Email</th>
                        <th class="text-left px-5 py-3 text-xs font-black uppercase tracking-wider text-slate-500 hidden md:table-cell">Nom</th>
                        <th class="text-left px-5 py-3 text-xs font-black uppercase tracking-wider text-slate-500 hidden lg:table-cell">Date</th>
                        <th class="text-left px-5 py-3 text-xs font-black uppercase tracking-wider text-slate-500">Statut</th>
                        <th class="text-right px-5 py-3 text-xs font-black uppercase tracking-wider text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($abonnes as $ab)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-5 py-3 font-medium text-slate-900">{{ $ab->email }}</td>
                        <td class="px-5 py-3 text-slate-500 hidden md:table-cell">{{ $ab->nom ?? '—' }}</td>
                        <td class="px-5 py-3 text-slate-400 text-xs hidden lg:table-cell">{{ $ab->created_at->isoFormat('D MMM YYYY') }}</td>
                        <td class="px-5 py-3">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black {{ $ab->actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                                {{ $ab->actif ? 'Actif' : 'Désabonné' }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <form method="POST" action="{{ route('admin.newsletter.destroy', $ab) }}" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button class="p-1.5 rounded-lg text-slate-300 hover:text-red-500 hover:bg-red-50 transition-colors"><i class="fas fa-trash text-xs"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-10 text-slate-400">
                        <i class="fas fa-users text-3xl mb-2 block text-slate-200"></i> Aucun abonné.
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
            @if(isset($abonnes) && $abonnes->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $abonnes->links() }}</div>
            @endif
        </div>
    </div>

    {{-- ENVOYER UNE NEWSLETTER --}}
    <div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden sticky top-[100px]">
            <div class="p-5 border-b border-slate-100" style="background:#F8F6F2;">
                <h3 class="font-bold text-slate-900">Envoyer une newsletter</h3>
                <p class="text-xs text-slate-400 mt-0.5">Tous les abonnés actifs recevront ce message.</p>
            </div>
            <form method="POST" action="{{ route('admin.newsletter.send') }}" class="p-5 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Sujet *</label>
                    <input type="text" name="sujet" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none" placeholder="Ex: Invitation au culte de Noël">
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500 mb-2">Message *</label>
                    <textarea name="message" rows="6" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm focus:outline-none resize-none"
                              placeholder="Votre message aux abonnés…"></textarea>
                </div>
                <div class="flex items-center gap-2 p-3 rounded-xl text-xs" style="background:rgba(74,140,63,.08);color:#2D6A27;">
                    <i class="fas fa-info-circle"></i>
                    <span>{{ $stats['actifs'] ?? 0 }} abonné(s) actif(s) recevront cet email.</span>
                </div>
                <button type="submit" class="w-full py-3 rounded-xl text-white font-bold text-sm" style="background:linear-gradient(135deg,#4A8C3F,#2D6A27);"
                        onclick="return confirm('Envoyer la newsletter à tous les abonnés ?')">
                    <i class="fas fa-paper-plane mr-2"></i> Envoyer la newsletter
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
