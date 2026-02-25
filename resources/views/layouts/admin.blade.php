<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration — M.E.SI')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: { DEFAULT:'#e8b04b', light:'#f5d07a', dark:'#c0892e' },
                        navy: { DEFAULT:'#0d1b3e', mid:'#1a2d5a' },
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"','Georgia','serif'],
                        sans: ['Lato','system-ui','sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .gold-gradient { background: linear-gradient(135deg, #e8b04b, #c0892e); }
        .nav-active { background: rgba(232,176,75,.15); color: #e8b04b; border-right: 3px solid #e8b04b; }
        .sidebar-link { display:flex; align-items:center; gap:10px; padding:9px 20px; font-size:.875rem; color:rgba(255,255,255,.65); transition:all .25s; border-right:3px solid transparent; }
        .sidebar-link:hover { background:rgba(232,176,75,.1); color:#e8b04b; padding-left:26px; }
        .sidebar-link i { width:18px; text-align:center; }
    </style>
    @stack('styles')
</head>
<body class="font-sans bg-slate-50 overflow-x-hidden">

<div class="flex min-h-screen">

    {{-- ══ SIDEBAR ══ --}}
    <aside id="adminSidebar" class="fixed top-0 left-0 h-full w-64 bg-navy z-50 flex flex-col transition-transform duration-300 lg:translate-x-0 -translate-x-full shadow-2xl">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10">
            <div class="w-9 h-9 gold-gradient rounded-xl flex items-center justify-center text-white font-bold text-base">✝</div>
            <div>
                <div class="font-serif font-bold text-white text-base leading-tight">M.E.SI</div>
                <div class="text-[9px] text-white/35 uppercase tracking-widest">Administration</div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto py-4">
            <div class="px-5 py-2 text-[10px] font-black text-white/30 uppercase tracking-widest mt-2">Tableau de bord</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'nav-active' : '' }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>

            <div class="px-5 py-2 text-[10px] font-black text-white/30 uppercase tracking-widest mt-3">Contenu</div>
            <a href="{{ route('admin.cultes.index') }}" class="sidebar-link {{ request()->routeIs('admin.cultes.*') ? 'nav-active' : '' }}">
                <i class="fas fa-broadcast-tower"></i> Cultes & Live
            </a>
            <a href="{{ route('admin.actualites.index') }}" class="sidebar-link {{ request()->routeIs('admin.actualites.*') ? 'nav-active' : '' }}">
                <i class="fas fa-newspaper"></i> Actualités
            </a>
            <a href="{{ route('admin.missions.index') }}" class="sidebar-link {{ request()->routeIs('admin.missions.*') ? 'nav-active' : '' }}">
                <i class="fas fa-globe"></i> Missions
            </a>
            <a href="{{ route('admin.evenements.index') }}" class="sidebar-link {{ request()->routeIs('admin.evenements.*') ? 'nav-active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Événements
            </a>
            <a href="{{ route('admin.sermons.index') }}" class="sidebar-link {{ request()->routeIs('admin.sermons.*') ? 'nav-active' : '' }}">
                <i class="fas fa-bible"></i> Sermons
            </a>

            <div class="px-5 py-2 text-[10px] font-black text-white/30 uppercase tracking-widest mt-3">Communauté</div>
            <a href="{{ route('admin.membres.index') }}" class="sidebar-link {{ request()->routeIs('admin.membres.*') ? 'nav-active' : '' }}">
                <i class="fas fa-users"></i> Membres
            </a>
            <a href="{{ route('admin.departements.index') }}" class="sidebar-link {{ request()->routeIs('admin.departements.*') ? 'nav-active' : '' }}">
                <i class="fas fa-layer-group"></i> Départements
            </a>
            <a href="{{ route('admin.dons.index') }}" class="sidebar-link {{ request()->routeIs('admin.dons.*') ? 'nav-active' : '' }}">
                <i class="fas fa-heart"></i> Dons
            </a>
            <a href="{{ route('admin.contacts.index') }}" class="sidebar-link {{ request()->routeIs('admin.contacts.*') ? 'nav-active' : '' }}">
                <i class="fas fa-envelope"></i> Messages
                @php $unread = \App\Models\Contact::where('lu',false)->count(); @endphp
                @if($unread)<span class="ml-auto bg-red-500 text-white text-[10px] font-black px-1.5 py-0.5 rounded-full">{{ $unread }}</span>@endif
            </a>
            <a href="{{ route('admin.newsletter.index') }}" class="sidebar-link {{ request()->routeIs('admin.newsletter.*') ? 'nav-active' : '' }}">
                <i class="fas fa-paper-plane"></i> Newsletter
            </a>

            <div class="px-5 py-2 text-[10px] font-black text-white/30 uppercase tracking-widest mt-3">Paramètres</div>
            <a href="{{ route('admin.horaires.index') }}" class="sidebar-link {{ request()->routeIs('admin.horaires.*') ? 'nav-active' : '' }}">
                <i class="fas fa-clock"></i> Horaires
            </a>
            <a href="{{ route('admin.verset.edit') }}" class="sidebar-link {{ request()->routeIs('admin.verset.*') ? 'nav-active' : '' }}">
                <i class="fas fa-quote-right"></i> Verset du jour
            </a>
            <a href="{{ route('admin.parametres') }}" class="sidebar-link {{ request()->routeIs('admin.parametres') ? 'nav-active' : '' }}">
                <i class="fas fa-cog"></i> Paramètres
            </a>
        </nav>

        {{-- User + logout --}}
        <div class="border-t border-white/10 p-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 gold-gradient rounded-full flex items-center justify-center text-white font-black text-sm">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-white font-bold text-sm truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="text-white/40 text-[10px] capitalize">{{ auth()->user()->role ?? 'admin' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left flex items-center gap-2 text-white/50 hover:text-red-400 text-xs py-2 transition-colors">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </div>
    </aside>

    {{-- Overlay mobile --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="closeSidebar()"></div>

    {{-- ══ MAIN ══ --}}
    <div class="flex-1 flex flex-col min-h-screen lg:ml-64">

        {{-- Header --}}
        <header class="sticky top-0 z-30 bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4">
                <button id="adminSidebarToggle" onclick="toggleSidebar()" class="lg:hidden p-2 text-slate-500 hover:text-navy transition-colors">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <h1 class="font-serif font-bold text-navy text-xl">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="text-xs text-slate-400 hover:text-navy transition-colors flex items-center gap-1.5 px-3 py-2 rounded-lg hover:bg-slate-50">
                    <i class="fas fa-external-link-alt text-[10px]"></i> Voir le site
                </a>
                @if($unread = \App\Models\Contact::where('lu',false)->count())
                <a href="{{ route('admin.contacts.index') }}" class="relative p-2 text-slate-500 hover:text-navy transition-colors">
                    <i class="fas fa-bell"></i>
                    <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 text-white text-[9px] font-black rounded-full flex items-center justify-center">{{ $unread }}</span>
                </a>
                @endif
            </div>
        </header>

        {{-- Alerts --}}
        @if(session('success'))
        <div id="adminAlert" class="mx-6 mt-5 bg-green-50 border border-green-200 text-green-800 rounded-2xl px-5 py-3.5 flex items-center gap-3 text-sm font-medium animate-fade-in">
            <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
            <button onclick="this.closest('#adminAlert').remove()" class="ml-auto text-green-400 hover:text-green-600"><i class="fas fa-times"></i></button>
        </div>
        @endif
        @if(session('error'))
        <div id="adminAlertErr" class="mx-6 mt-5 bg-red-50 border border-red-200 text-red-800 rounded-2xl px-5 py-3.5 flex items-center gap-3 text-sm font-medium animate-fade-in">
            <i class="fas fa-exclamation-circle text-red-500"></i> {{ session('error') }}
            <button onclick="this.closest('#adminAlertErr').remove()" class="ml-auto text-red-400 hover:text-red-600"><i class="fas fa-times"></i></button>
        </div>
        @endif

        {{-- Content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script>
function toggleSidebar() {
    const s = document.getElementById('adminSidebar');
    const o = document.getElementById('sidebarOverlay');
    s.classList.toggle('-translate-x-full');
    o.classList.toggle('hidden');
}
function closeSidebar() {
    document.getElementById('adminSidebar').classList.add('-translate-x-full');
    document.getElementById('sidebarOverlay').classList.add('hidden');
}
// Auto dismiss alert
setTimeout(() => {
    ['adminAlert','adminAlertErr'].forEach(id => {
        const el = document.getElementById(id);
        if(el) { el.style.opacity='0'; el.style.transition='opacity .4s'; setTimeout(()=>el.remove(),400); }
    });
}, 4500);
</script>
@stack('scripts')
</body>
</html>
