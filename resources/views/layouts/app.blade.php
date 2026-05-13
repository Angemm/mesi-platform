<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'M.E.SI — Mission Évangélique Sion')</title>
    <meta name="description" content="@yield('description', 'Mission Évangélique Sion — Partager la Parole, Bâtir le Royaume')">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: { DEFAULT: '#e8b04b', light: '#f5d07a', dark: '#c0892e', pale: '#fdf8f0' },
                        navy: { DEFAULT: '#2d6a4f', mid: '#40916c', light: '#52b788' },
                        dark: '#1b4332',
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        sans: ['Lato', 'system-ui', 'sans-serif'],
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.7s ease both',
                        'fade-in': 'fadeIn 0.5s ease both',
                        'pulse-gold': 'pulseGold 2s ease infinite',
                        'pulse-red': 'pulseRed 1.5s ease infinite',
                        'drift': 'drift 20s linear infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeUp: { '0%': { opacity: 0, transform: 'translateY(20px)' }, '100%': { opacity: 1, transform: 'translateY(0)' } },
                        fadeIn: { '0%': { opacity: 0 }, '100%': { opacity: 1 } },
                        pulseGold: { '0%,100%': { boxShadow: '0 0 0 0 rgba(232,176,75,0.4)' }, '50%': { boxShadow: '0 0 0 12px rgba(232,176,75,0)' } },
                        pulseRed: { '0%,100%': { boxShadow: '0 0 0 0 rgba(229,62,62,0.6)' }, '50%': { boxShadow: '0 0 0 8px rgba(229,62,62,0)' } },
                        drift: { '0%': { transform: 'translate(0,0)' }, '100%': { transform: 'translate(40px,40px)' } },
                        float: { '0%,100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-12px)' } },
                    },
                }
            }
        }
    </script>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400;1,700&family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* ── Custom utilities non couverts par Tailwind ── */
        [x-cloak] { display: none !important; }

        .gold-gradient { background: linear-gradient(135deg, #e8b04b, #c0892e); }
        .navy-gradient { background: linear-gradient(135deg, #2d6a4f, #52b788); }
        .hero-gradient { background: linear-gradient(135deg, rgba(45,106,79,.96) 0%, rgba(45,106,79,.75) 50%, rgba(45,106,79,.45) 100%); }
        .glass { background: rgba(255,255,255,0.04); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); }
        .card-hover { transition: transform .35s cubic-bezier(.4,0,.2,1), box-shadow .35s cubic-bezier(.4,0,.2,1); }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(0,0,0,.12); }
        .card-hover-gold:hover { box-shadow: 0 16px 48px rgba(232,176,75,.25); }

        /* Barre de progression animée */
        .progress-bar { transition: width 1.2s cubic-bezier(.4,0,.2,1); }

        /* Dots live */
        .live-dot { width: 10px; height: 10px; border-radius: 50%; background: #e53e3e; animation: pulseRed 1.5s ease infinite; }

        /* Scroll reveal */
        .reveal { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* Dropdown */
        .dropdown-menu { display: none; }
        .has-dropdown:hover .dropdown-menu { display: block; }

        /* Scrollbar custom */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #c0892e; border-radius: 3px; }

        /* Highlight biblique */
        .bible-highlight { font-family: 'Playfair Display', serif; font-style: italic; color: #c0892e; }

        /* Image zoom */
        .img-zoom { overflow: hidden; }
        .img-zoom img { transition: transform .5s ease; }
        .img-zoom:hover img { transform: scale(1.06); }
    </style>
    @stack('styles')
</head>
<body class="font-sans text-slate-800 bg-white overflow-x-hidden">

{{-- ══════════ TOPBAR ══════════ --}}
<div class="text-xs py-2 hidden md:block border-b border-slate-200" id="topbar" style="background:#fff; color:#1a4731;">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
        <div class="flex gap-6">
            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode(config('mesi.adresse','Eglise MESI Faya Abidjan')) }}" target="_blank" class="flex items-center gap-1.5 hover:text-gold-dark transition-colors">
                <i class="fas fa-map-marker-alt text-gold"></i> {{ config('mesi.adresse','Abidjan, Côte d\'Ivoire') }}
            </a>
            <a href="tel:{{ config('mesi.telephone','+225 XX XX XX XX') }}" class="flex items-center gap-1.5 hover:text-gold-dark transition-colors">
                <i class="fas fa-phone text-gold"></i> {{ config('mesi.telephone','+225 XX XX XX XX') }}
            </a>
            <a href="mailto:{{ config('mesi.email','contact@mesi.org') }}" class="flex items-center gap-1.5 hover:text-gold-dark transition-colors">
                <i class="fas fa-envelope text-gold"></i> {{ config('mesi.email','contact@mesi.org') }}
            </a>
        </div>
        <div class="flex gap-3">
            <a href="{{ config('mesi.facebook','#') }}" target="_blank" class="hover:text-gold transition-colors"><i class="fab fa-facebook"></i></a>
            <a href="{{ config('mesi.youtube','#') }}" target="_blank" class="hover:text-gold transition-colors"><i class="fab fa-youtube"></i></a>
            <a href="{{ config('mesi.whatsapp','#') }}" target="_blank" class="hover:text-gold transition-colors"><i class="fab fa-whatsapp"></i></a>
            <a href="{{ config('mesi.instagram','#') }}" target="_blank" class="hover:text-gold transition-colors"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
</div>

{{-- ══════════ NAVBAR ══════════ --}}
<nav id="navbar" class="sticky top-0 z-50 transition-all duration-300" style="background:linear-gradient(135deg,#2d6a4f,#52b788);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center h-18 gap-8" style="height:72px">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0">
                <div class="w-10 h-10 gold-gradient rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-gold/30">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo M.E.S.I"></div>
                <div class="leading-tight">
                    <div class="font-serif font-bold text-xl nav-logo-text">M.E.SI</div>
                    <div class="text-[10px] text-white/70 nav-logo-sub uppercase tracking-widest hidden sm:block">Mission Évangélique Sion</div>
                </div>
            </a>

            {{-- Menu desktop --}}
            <ul class="hidden lg:flex items-center gap-1 flex-1 justify-center list-none">
                <li><a href="{{ route('home') }}" class="nav-link px-3 py-2 text-sm font-bold rounded-lg transition-all {{ request()->routeIs('home') ? 'text-gold bg-white/15 border-b-2 border-gold' : 'text-white/90 hover:text-white hover:bg-white/10' }}">Accueil</a></li>

                <li class="has-dropdown relative">
                    <a href="{{ route('eglise.index') }}" class="nav-link px-3 py-2 text-sm font-bold rounded-lg transition-all flex items-center gap-1 {{ request()->routeIs('eglise.*') ? 'text-gold bg-white/15' : 'text-white/90 hover:text-white hover:bg-white/10' }}">
                        L'Église <i class="fas fa-chevron-down text-[10px] transition-transform"></i>
                    </a>
                    <div class="dropdown-menu absolute top-full left-0 mt-2 w-52 bg-white rounded-2xl shadow-2xl border border-gold/15 overflow-hidden py-2 z-50">
                        <a href="{{ route('eglise.histoire') }}" class="block px-5 py-2.5 text-sm text-slate-700 hover:bg-gold/8 hover:text-gold-dark hover:pl-7 transition-all">Notre Histoire</a>
                        <a href="{{ route('eglise.vision') }}" class="block px-5 py-2.5 text-sm text-slate-700 hover:bg-gold/8 hover:text-gold-dark hover:pl-7 transition-all">Vision & Mission</a>
                        <a href="{{ route('eglise.pasteurs') }}" class="block px-5 py-2.5 text-sm text-slate-700 hover:bg-gold/8 hover:text-gold-dark hover:pl-7 transition-all">Nos Pasteurs</a>
                        <a href="{{ route('eglise.departements') }}" class="block px-5 py-2.5 text-sm text-slate-700 hover:bg-gold/8 hover:text-gold-dark hover:pl-7 transition-all">Départements</a>
                    </div>
                </li>

                <li><a href="{{ route('cultes.index') }}" class="nav-link px-3 py-2 text-sm font-bold rounded-lg transition-all {{ request()->routeIs('cultes.*') ? 'text-gold bg-white/15 border-b-2 border-gold' : 'text-white/90 hover:text-white hover:bg-white/10' }}">Cultes & Live</a></li>
                <li><a href="{{ route('actualites.index') }}" class="nav-link px-3 py-2 text-sm font-bold rounded-lg transition-all {{ request()->routeIs('actualites.*') ? 'text-gold bg-white/15 border-b-2 border-gold' : 'text-white/90 hover:text-white hover:bg-white/10' }}">Actualités</a></li>
                <li><a href="{{ route('missions.index') }}" class="nav-link px-3 py-2 text-sm font-bold rounded-lg transition-all {{ request()->routeIs('missions.*') ? 'text-gold bg-white/15 border-b-2 border-gold' : 'text-white/90 hover:text-white hover:bg-white/10' }}">Missions</a></li>
                <li><a href="{{ route('sermons.index') }}" class="nav-link px-3 py-2 text-sm font-bold rounded-lg transition-all {{ request()->routeIs('sermons.*') ? 'text-gold bg-white/15 border-b-2 border-gold' : 'text-white/90 hover:text-white hover:bg-white/10' }}">Sermons</a></li>
                <li><a href="{{ route('contact') }}" class="nav-link px-3 py-2 text-sm font-bold rounded-lg transition-all {{ request()->routeIs('contact') ? 'text-gold bg-white/15 border-b-2 border-gold' : 'text-white/90 hover:text-white hover:bg-white/10' }}">Contact</a></li>
            </ul>

            {{-- Actions --}}
            <div class="flex items-center gap-2 ml-auto lg:ml-0">
                {{-- Bouton connexion/admin masqué sur le site public --}}
                {{-- @auth
                    <a href="{{ route('admin.dashboard') }}" class="nav-admin-btn hidden sm:flex items-center gap-1.5 text-xs font-bold px-3 py-2 rounded-lg border border-white/60 text-white hover:bg-white/10 transition-all">
                        <i class="fas fa-user-shield"></i> Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:block text-sm font-bold text-navy hover:text-gold-dark transition-colors px-3 py-2">Connexion</a>
                @endauth --}}
                <a href="{{ route('don') }}" class="gold-gradient text-white px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-gold/30 hover:shadow-gold/50 hover:-translate-y-0.5 transition-all">
                    <i class="fas fa-heart text-xs"></i> Donner
                </a>
                {{-- Burger --}}
                <button id="navToggle" class="nav-burger lg:hidden flex flex-col gap-1.5 p-2 ml-1">
                    <span class="block w-6 h-0.5 bg-white rounded transition-all"></span>
                    <span class="block w-6 h-0.5 bg-white rounded transition-all"></span>
                    <span class="block w-6 h-0.5 bg-white rounded transition-all"></span>
                </button>
            </div>
        </div>
    </div>
</nav>

{{-- ══════════ MENU MOBILE ══════════ --}}
<div id="mobileMenu" class="fixed inset-0 z-[999] pointer-events-none">
    {{-- Overlay --}}
    <div id="mobileOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
    {{-- Drawer --}}
    <div id="mobileDrawer" class="absolute top-0 right-0 h-full w-80 bg-navy translate-x-full transition-transform duration-350 ease-out flex flex-col">
        <div class="flex items-center justify-between p-6 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 gold-gradient rounded-xl flex items-center justify-center text-white font-bold">✝</div>
                <span class="font-serif font-bold text-white text-lg">M.E.SI</span>
            </div>
            <button id="mobileClose" class="text-white/60 hover:text-white transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto p-6">
            <ul class="space-y-1">
                @foreach([['home','Accueil'],['eglise.index',"L'Église"],['cultes.index','Cultes & Live'],['actualites.index','Actualités'],['missions.index','Missions'],['sermons.index','Sermons'],['membres.index','Membres'],['contact','Contact']] as [$r,$l])
                <li><a href="{{ route($r) }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-white/75 font-semibold hover:bg-white/10 hover:text-gold transition-all">
                    {{ $l }}
                </a></li>
                @endforeach
            </ul>
        </nav>
        <div class="p-6 border-t border-white/10 space-y-3">
            {{-- Connexion masquée sur le site public --}}
            {{-- @auth
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border border-white/20 text-white font-bold text-sm hover:bg-white/10 transition-all">
                    <i class="fas fa-user-shield"></i> Administration
                </a>
            @else
                <a href="{{ route('login') }}" class="flex items-center justify-center py-3 px-4 rounded-xl border border-white/20 text-white font-bold text-sm hover:bg-white/10 transition-all">Connexion</a>
            @endauth --}}
            <a href="{{ route('don') }}" class="gold-gradient text-white flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-bold text-sm">
                <i class="fas fa-heart"></i> Faire un Don
            </a>
        </div>
    </div>
</div>

{{-- ══════════ LOADER GLOBAL ══════════ --}}
<div id="pageLoader" class="fixed inset-0 z-[99999] flex flex-col items-center justify-center pointer-events-none opacity-0 transition-opacity duration-300" style="background:rgba(255,255,255,0.92);backdrop-filter:blur(6px);">
    <div class="flex flex-col items-center gap-4">
        <div class="w-14 h-14 rounded-full border-4 border-slate-200 border-t-green-600 animate-spin"></div>
        <span class="text-green-800 font-bold text-sm uppercase tracking-widest">Chargement…</span>
    </div>
</div>

{{-- ══════════ ALERTS ══════════ --}}
@if(session('success'))
<div id="alertSuccess" class="fixed top-6 right-6 z-[9999] max-w-sm bg-white rounded-2xl shadow-2xl border border-green-100 p-4 flex items-start gap-3 animate-fade-in">
    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
        <i class="fas fa-check text-green-600 text-sm"></i>
    </div>
    <div class="flex-1">
        <p class="text-sm font-bold text-slate-800">Succès</p>
        <p class="text-sm text-slate-500">{{ session('success') }}</p>
    </div>
    <button onclick="this.closest('#alertSuccess').remove()" class="text-slate-300 hover:text-slate-500 transition-colors"><i class="fas fa-times text-sm"></i></button>
</div>
@endif
@if(session('error'))
<div id="alertError" class="fixed top-6 right-6 z-[9999] max-w-sm bg-white rounded-2xl shadow-2xl border border-red-100 p-4 flex items-start gap-3 animate-fade-in">
    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
        <i class="fas fa-exclamation text-red-500 text-sm"></i>
    </div>
    <div class="flex-1">
        <p class="text-sm font-bold text-slate-800">Erreur</p>
        <p class="text-sm text-slate-500">{{ session('error') }}</p>
    </div>
    <button onclick="this.closest('#alertError').remove()" class="text-slate-300 hover:text-slate-500 transition-colors"><i class="fas fa-times text-sm"></i></button>
</div>
@endif

{{-- ══════════ CONTENU ══════════ --}}
<main>@yield('content')</main>

{{-- ══════════ FOOTER ══════════ --}}
<footer class="text-white" style="background: linear-gradient(135deg, #2d6a4f, #52b788)">
    {{-- Vague --}}
    <div class="leading-none">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" class="w-full h-14 fill-slate-50">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z"/>
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-6 pt-16 pb-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

            {{-- Brand --}}
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 gold-gradient rounded-xl flex items-center justify-center text-white font-bold text-lg">✝</div>
                    <div>
                        <div class="font-serif font-bold text-white text-lg leading-tight">M.E.SI</div>
                        <div class="text-[10px] text-white/40 uppercase tracking-widest">Mission Évangélique Sion</div>
                    </div>
                </div>
                <p class="text-sm text-white/55 leading-relaxed mb-5">Une église vivante, enracinée dans la Parole de Dieu, engagée pour le Royaume.</p>
                <div class="flex gap-2">
                    @foreach([['facebook','fab fa-facebook'],['youtube','fab fa-youtube'],['whatsapp','fab fa-whatsapp'],['instagram','fab fa-instagram']] as [$key,$icon])
                    <a href="{{ config('mesi.'.$key,'#') }}" target="_blank" class="w-9 h-9 rounded-xl bg-white/8 flex items-center justify-center text-white/60 hover:bg-gold hover:text-dark transition-all text-sm">
                        <i class="{{ $icon }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Navigation --}}
            <div>
                <h4 class="font-serif font-bold text-white mb-5 text-base">Navigation</h4>
                <ul class="space-y-2.5">
                    @foreach([['home','Accueil'],['eglise.index',"L'Église"],['cultes.index','Cultes & Live'],['actualites.index','Actualités'],['missions.index','Missions'],['sermons.index','Sermons'],['contact','Contact']] as [$r,$l])
                    <li><a href="{{ route($r) }}" class="text-sm text-white/55 hover:text-gold hover:pl-1 transition-all inline-block">{{ $l }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Horaires --}}
            <div>
                <h4 class="font-serif font-bold text-white mb-5 text-base">Horaires</h4>
                <ul class="space-y-2.5">
                    @foreach(\App\Models\HoraireCulte::actif()->orderBy('ordre')->get() as $h)
                    <li class="flex justify-between items-center text-sm">
                        <span class="text-white/60">{{ $h->jour }}</span>
                        <span class="text-gold font-bold">{{ $h->heure }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Newsletter --}}
            <div>
                <h4 class="font-serif font-bold text-white mb-5 text-base">Newsletter</h4>
                <p class="text-sm text-white/55 mb-4 leading-relaxed">Recevez nos annonces et actualités directement dans votre boîte mail.</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <div class="flex">
                        <input type="email" name="email" placeholder="votre@email.com" required
                               class="flex-1 bg-white/8 border border-white/12 text-white text-sm px-4 py-3 rounded-l-xl placeholder-white/30 focus:outline-none focus:border-gold/50 focus:bg-white/12 transition-all">
                        <button type="submit" class="gold-gradient px-4 py-3 rounded-r-xl text-white hover:shadow-lg hover:shadow-gold/30 transition-all">
                            <i class="fas fa-paper-plane text-sm"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="border-t border-white/8 pt-8 flex flex-col sm:flex-row justify-between items-center gap-3">
            <p class="text-xs text-white/35">&copy; {{ date('Y') }} Mission Évangélique Sion. Tous droits réservés.</p>
            <p class="text-xs text-white/35">Développé avec <i class="fas fa-heart text-gold/70 mx-1"></i> pour la gloire de Dieu</p>
        </div>
    </div>
</footer>

<script src="{{ asset('js/app.js') }}"></script>
<script>
/* ── LOADER ── */
const loader = document.getElementById('pageLoader');
function showLoader(){ loader.style.opacity='1'; loader.style.pointerEvents='all'; }
function hideLoader(){ loader.style.opacity='0'; loader.style.pointerEvents='none'; }

document.addEventListener('click', function(e){
    const a = e.target.closest('a[href]');
    if (!a) return;
    const href = a.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript') || a.target==='_blank') return;
    try { const u=new URL(href,location.origin); if(u.origin!==location.origin) return; } catch(e){ return; }
    showLoader();
});
document.addEventListener('submit', showLoader);
window.addEventListener('pageshow', hideLoader);
window.addEventListener('load', hideLoader);

/* ── NAVBAR SCROLL ── */
(function(){
    const nav=document.getElementById('navbar');
    const topbar=document.getElementById('topbar');
    const green='linear-gradient(135deg,#2d6a4f,#52b788)';

    function set(scrolled){
        nav.style.transition='background .3s ease,box-shadow .3s ease';
        if(scrolled){
            nav.style.background='rgba(255,255,255,0.97)';
            nav.style.backdropFilter='blur(20px)';
            nav.style.borderBottom='1px solid rgba(232,176,75,0.2)';
            nav.style.boxShadow='0 2px 16px rgba(0,0,0,0.07)';
            nav.querySelectorAll('.nav-link').forEach(el=>{ el.classList.remove('text-white/90','hover:text-white','hover:bg-white/10'); el.classList.add('text-slate-700','hover:text-gold-dark','hover:bg-gold/10'); });
            nav.querySelectorAll('.nav-logo-text').forEach(el=>el.style.color='#14532d');
            nav.querySelectorAll('.nav-logo-sub').forEach(el=>el.style.color='#6b7280');
            nav.querySelectorAll('.nav-burger span').forEach(el=>el.style.background='#1e3a2f');
            nav.querySelectorAll('.nav-admin-btn').forEach(el=>{ el.style.borderColor='#166534'; el.style.color='#166534'; });
        } else {
            nav.style.background=green;
            nav.style.backdropFilter='';
            nav.style.borderBottom='none';
            nav.style.boxShadow='none';
            nav.querySelectorAll('.nav-link').forEach(el=>{ el.classList.remove('text-slate-700','hover:text-gold-dark','hover:bg-gold/10'); el.classList.add('text-white/90','hover:text-white','hover:bg-white/10'); });
            nav.querySelectorAll('.nav-logo-text').forEach(el=>el.style.color='#fff');
            nav.querySelectorAll('.nav-logo-sub').forEach(el=>el.style.color='rgba(255,255,255,0.7)');
            nav.querySelectorAll('.nav-burger span').forEach(el=>el.style.background='#fff');
            nav.querySelectorAll('.nav-admin-btn').forEach(el=>{ el.style.borderColor='rgba(255,255,255,0.6)'; el.style.color='#fff'; });
        }
        topbar.style.background='#fff'; topbar.style.borderColor='#e2e8f0'; topbar.style.color='#1a4731';
    }
    set(scrollY>10);
    window.addEventListener('scroll',()=>set(scrollY>10),{passive:true});
})();

/* ── SCROLL REVEAL ── */
(function(){
    const io=new IntersectionObserver(entries=>entries.forEach(e=>{ if(e.isIntersecting){ e.target.classList.add('visible'); io.unobserve(e.target); } }),{threshold:0.1,rootMargin:'0px 0px -30px 0px'});
    document.querySelectorAll('.reveal').forEach(el=>io.observe(el));
})();

/* ── SMOOTH SCROLL ANCRES ── */
document.querySelectorAll('a[href^="#"]').forEach(a=>{
    a.addEventListener('click',function(e){
        const t=document.querySelector(this.getAttribute('href'));
        if(t){ e.preventDefault(); t.scrollIntoView({behavior:'smooth',block:'start'}); }
    });
});

/* ── COMPTEURS ── */
(function(){
    const io=new IntersectionObserver(entries=>entries.forEach(e=>{
        if(!e.isIntersecting) return;
        const el=e.target, target=parseInt(el.dataset.count), suffix=el.dataset.suffix||'';
        let v=0; const step=Math.ceil(target/90);
        const t=setInterval(()=>{ v=Math.min(v+step,target); el.textContent=v+suffix; if(v>=target) clearInterval(t); },16);
        io.unobserve(el);
    }),{threshold:0.5});
    document.querySelectorAll('[data-count]').forEach(el=>io.observe(el));
})();

/* ── MENU MOBILE ── */
(function(){
    const toggle=document.getElementById('navToggle');
    const close=document.getElementById('mobileClose');
    const overlay=document.getElementById('mobileOverlay');
    const drawer=document.getElementById('mobileDrawer');
    const menu=document.getElementById('mobileMenu');
    function open(){ menu.style.pointerEvents='all'; overlay.style.opacity='1'; drawer.style.transform='translateX(0)'; }
    function shut(){ overlay.style.opacity='0'; drawer.style.transform='translateX(100%)'; setTimeout(()=>menu.style.pointerEvents='none',350); }
    if(toggle) toggle.addEventListener('click',open);
    if(close)  close.addEventListener('click',shut);
    if(overlay) overlay.addEventListener('click',shut);
})();

/* ── PROGRESS BARS ── */
(function(){
    const io=new IntersectionObserver(entries=>entries.forEach(e=>{ if(e.isIntersecting){ e.target.style.width=e.target.dataset.width+'%'; io.unobserve(e.target); } }),{threshold:0.3});
    document.querySelectorAll('.progress-bar[data-width]').forEach(b=>io.observe(b));
})();
</script>
@stack('scripts')
</body>
</html>
