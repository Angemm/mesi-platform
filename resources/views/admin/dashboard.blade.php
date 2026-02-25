@extends('layouts.admin')
@section('title','Dashboard — M.E.SI')
@section('page-title','Tableau de bord')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-5 mb-7">
    @foreach([
        ['Membres actifs',   $stats['membres'],    'fas fa-users',          'bg-gold/10 text-gold-dark'],
        ['Cultes publiés',   $stats['cultes'],     'fas fa-broadcast-tower','bg-navy/10 text-navy'],
        ['Actualités',       $stats['actualites'], 'fas fa-newspaper',      'bg-emerald-50 text-emerald-600'],
        ['Missions actives', $stats['missions'],   'fas fa-globe',          'bg-red-50 text-red-500'],
    ] as [$label,$val,$icon,$bg])
    <div class="bg-white rounded-2xl p-5 flex items-center gap-4 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 rounded-xl {{ $bg }} flex items-center justify-center flex-shrink-0">
            <i class="{{ $icon }} text-lg"></i>
        </div>
        <div>
            <div class="font-serif font-bold text-navy text-2xl leading-none">{{ number_format($val) }}</div>
            <div class="text-slate-400 text-xs mt-1 font-medium">{{ $label }}</div>
        </div>
    </div>
    @endforeach
</div>

<div class="grid xl:grid-cols-3 gap-6">

    {{-- Cultes récents --}}
    <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-50">
            <h3 class="font-serif font-bold text-navy">Cultes récents</h3>
            <a href="{{ route('admin.cultes.create') }}" class="gold-gradient text-white text-xs font-bold px-4 py-2 rounded-xl flex items-center gap-1.5 hover:shadow-md transition-all">
                <i class="fas fa-plus text-[10px]"></i> Nouveau
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-5 py-3 text-xs font-black text-slate-400 uppercase tracking-wider">Titre</th>
                        <th class="text-left px-5 py-3 text-xs font-black text-slate-400 uppercase tracking-wider hidden md:table-cell">Date</th>
                        <th class="text-left px-5 py-3 text-xs font-black text-slate-400 uppercase tracking-wider">Statut</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentsCultes as $culte)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="font-bold text-slate-800 truncate max-w-[200px]">{{ $culte->titre }}</div>
                            @if($culte->predicateur)<div class="text-xs text-slate-400 mt-0.5">{{ $culte->predicateur }}</div>@endif
                        </td>
                        <td class="px-5 py-3.5 text-slate-400 text-xs hidden md:table-cell whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($culte->date_culte)->format('d/m/Y') }}
                        </td>
                        <td class="px-5 py-3.5">
                            @if($culte->est_live)
                                <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 text-[10px] font-black px-2.5 py-1 rounded-full uppercase"><span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>Live</span>
                            @elseif($culte->publie)
                                <span class="inline-block bg-emerald-50 text-emerald-700 text-[10px] font-black px-2.5 py-1 rounded-full uppercase">Publié</span>
                            @else
                                <span class="inline-block bg-amber-50 text-amber-700 text-[10px] font-black px-2.5 py-1 rounded-full uppercase">Brouillon</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex gap-1.5 justify-end">
                                <a href="{{ route('cultes.show', $culte->slug) }}" target="_blank" class="w-8 h-8 rounded-lg bg-gold/10 text-gold-dark flex items-center justify-center hover:bg-gold hover:text-white transition-all text-xs"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.cultes.edit', $culte->id) }}" class="w-8 h-8 rounded-lg bg-navy/8 text-navy flex items-center justify-center hover:bg-navy hover:text-white transition-all text-xs"><i class="fas fa-pen"></i></a>
                                <form method="POST" action="{{ route('admin.cultes.destroy', $culte->id) }}" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" data-confirm="Supprimer ce culte ?" class="w-8 h-8 rounded-lg bg-red-50 text-red-400 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all text-xs"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-10 text-center text-slate-400 text-sm">Aucun culte enregistré</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Panneau droit --}}
    <div class="space-y-5">

        {{-- Live status --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-50">
                <h3 class="font-serif font-bold text-navy text-sm">Diffusion Live</h3>
            </div>
            <div class="p-5">
                @if($culteLive)
                <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                        <span class="text-red-600 font-black text-xs uppercase tracking-wider">En Direct</span>
                    </div>
                    <p class="font-bold text-slate-800 text-sm">{{ $culteLive->titre }}</p>
                    <a href="{{ route('admin.cultes.edit', $culteLive->id) }}" class="text-xs text-gold-dark font-bold hover:underline mt-1 block">Modifier →</a>
                </div>
                @else
                <p class="text-slate-400 text-sm mb-4">Aucun culte en direct actuellement.</p>
                @endif
                <a href="{{ route('admin.cultes.create') }}" class="w-full gold-gradient text-white flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-bold hover:shadow-md transition-all">
                    <i class="fas fa-satellite-dish text-xs"></i> Créer un Live
                </a>
            </div>
        </div>

        {{-- Messages récents --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-50">
                <h3 class="font-serif font-bold text-navy text-sm">Messages récents</h3>
                <a href="{{ route('admin.contacts.index') }}" class="text-xs text-gold-dark font-bold hover:underline">Tous →</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($recentContacts as $contact)
                <a href="{{ route('admin.contacts.show', $contact->id) }}" class="flex items-start gap-3 px-5 py-3.5 hover:bg-slate-50/50 transition-colors {{ !$contact->lu ? 'bg-gold/3' : '' }}">
                    <div class="w-8 h-8 rounded-full bg-navy/10 flex items-center justify-center flex-shrink-0 font-bold text-navy text-xs">
                        {{ substr($contact->nom,0,1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-slate-800 text-xs truncate flex items-center gap-1.5">
                            {{ $contact->nom }}
                            @if(!$contact->lu)<span class="w-1.5 h-1.5 bg-gold rounded-full"></span>@endif
                        </div>
                        <div class="text-slate-400 text-[11px] truncate">{{ $contact->sujet }}</div>
                    </div>
                    <div class="text-[10px] text-slate-300 whitespace-nowrap">{{ $contact->created_at->diffForHumans(null, true) }}</div>
                </a>
                @empty
                <p class="px-5 py-6 text-slate-400 text-sm text-center">Aucun message</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Actualités récentes --}}
<div class="mt-6 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-50">
        <h3 class="font-serif font-bold text-navy">Dernières Actualités</h3>
        <a href="{{ route('admin.actualites.create') }}" class="gold-gradient text-white text-xs font-bold px-4 py-2 rounded-xl flex items-center gap-1.5 hover:shadow-md transition-all">
            <i class="fas fa-plus text-[10px]"></i> Écrire
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="text-left px-5 py-3 text-xs font-black text-slate-400 uppercase tracking-wider">Titre</th>
                    <th class="text-left px-5 py-3 text-xs font-black text-slate-400 uppercase tracking-wider hidden md:table-cell">Catégorie</th>
                    <th class="text-left px-5 py-3 text-xs font-black text-slate-400 uppercase tracking-wider">Statut</th>
                    <th class="text-left px-5 py-3 text-xs font-black text-slate-400 uppercase tracking-wider hidden lg:table-cell">Date</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($dernieresActualites as $actu)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-5 py-3.5">
                        <div class="font-bold text-slate-800 truncate max-w-[220px]">{{ $actu->titre }}</div>
                    </td>
                    <td class="px-5 py-3.5 hidden md:table-cell">
                        <span class="inline-block bg-blue-50 text-blue-700 text-[10px] font-black px-2.5 py-1 rounded-full uppercase">{{ $actu->categorie?->nom ?? 'Général' }}</span>
                    </td>
                    <td class="px-5 py-3.5">
                        @if($actu->en_vedette)
                            <span class="inline-block bg-gold/15 text-gold-dark text-[10px] font-black px-2.5 py-1 rounded-full uppercase">★ Vedette</span>
                        @elseif($actu->publie)
                            <span class="inline-block bg-emerald-50 text-emerald-700 text-[10px] font-black px-2.5 py-1 rounded-full uppercase">Publié</span>
                        @else
                            <span class="inline-block bg-amber-50 text-amber-700 text-[10px] font-black px-2.5 py-1 rounded-full uppercase">Brouillon</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-slate-400 text-xs hidden lg:table-cell">{{ $actu->created_at->format('d/m/Y') }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex gap-1.5 justify-end">
                            <a href="{{ route('admin.actualites.edit', $actu->id) }}" class="w-8 h-8 rounded-lg bg-navy/8 text-navy flex items-center justify-center hover:bg-navy hover:text-white transition-all text-xs"><i class="fas fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.actualites.destroy', $actu->id) }}" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" data-confirm="Supprimer cet article ?" class="w-8 h-8 rounded-lg bg-red-50 text-red-400 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all text-xs"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400 text-sm">Aucune actualité</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
