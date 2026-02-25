@extends('layouts.admin')
@section('title', 'Messages — Admin')
@section('page-title', 'Messages & Contacts')

@section('content')

<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div class="flex gap-2">
        @foreach([['','Tous'],['non_lu','Non lus'],['lu','Lus']] as [$val,$label])
        <a href="{{ request()->fullUrlWithQuery(['statut'=>$val]) }}"
           class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ request('statut','') === $val ? 'text-white' : 'text-slate-500 bg-white border border-slate-200' }}"
           style="{{ request('statut','') === $val ? 'background:linear-gradient(135deg,#4A8C3F,#2D6A27);' : '' }}">
            {{ $label }}
            @if($val === 'non_lu' && ($unread ?? 0) > 0)
            <span class="ml-1 bg-red-500 text-white text-[9px] font-black px-1.5 py-0.5 rounded-full">{{ $unread }}</span>
            @endif
        </a>
        @endforeach
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
    <table class="w-full text-sm">
        <thead>
            <tr style="background:#F8F6F2;">
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 w-4"></th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500">Expéditeur</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden md:table-cell">Sujet</th>
                <th class="text-left px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500 hidden lg:table-cell">Date</th>
                <th class="text-right px-5 py-4 text-xs font-black uppercase tracking-wider text-slate-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($contacts as $contact)
            <tr class="hover:bg-slate-50 transition-colors {{ !$contact->lu ? 'font-semibold' : '' }}">
                <td class="px-5 py-4">
                    @if(!$contact->lu)
                    <span class="block w-2 h-2 rounded-full" style="background:#E8A020;"></span>
                    @endif
                </td>
                <td class="px-5 py-4">
                    <p class="font-bold text-slate-900">{{ $contact->nom }}</p>
                    <p class="text-xs text-slate-400">{{ $contact->email }}</p>
                </td>
                <td class="px-5 py-4 text-slate-600 hidden md:table-cell">{{ Str::limit($contact->sujet ?? $contact->message, 45) }}</td>
                <td class="px-5 py-4 text-slate-400 text-xs hidden lg:table-cell">{{ $contact->created_at->isoFormat('D MMM YYYY, HH:mm') }}</td>
                <td class="px-5 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.contacts.show', $contact) }}" class="p-2 rounded-lg text-slate-400 hover:text-green-600 hover:bg-green-50 transition-colors">
                            <i class="fas fa-eye text-xs"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" onsubmit="return confirm('Supprimer ce message ?')">
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
                <i class="fas fa-inbox text-3xl mb-2 block text-slate-200"></i> Aucun message reçu.
            </td></tr>
            @endforelse
        </tbody>
    </table>
    @if(isset($contacts) && $contacts->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $contacts->links() }}</div>
    @endif
</div>

@endsection
