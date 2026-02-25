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
                        navy: { DEFAULT: '#0d1b3e', mid: '#1a2d5a', light: '#243d6e' },
                        dark: '#0a0a1a',
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
        .navy-gradient { background: linear-gradient(135deg, #0d1b3e, #1a3a6e); }
        .hero-gradient { background: linear-gradient(135deg, rgba(13,27,62,.96) 0%, rgba(13,27,62,.75) 50%, rgba(13,27,62,.45) 100%); }
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
<div class="bg-navy text-white/70 text-xs py-2 hidden md:block">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
        <div class="flex gap-6">
            <span class="flex items-center gap-1.5"><i class="fas fa-map-marker-alt text-gold"></i> {{ config('mesi.adresse','Abidjan, Côte d\'Ivoire') }}</span>
            <span class="flex items-center gap-1.5"><i class="fas fa-phone text-gold"></i> {{ config('mesi.telephone','+225 XX XX XX XX') }}</span>
            <span class="flex items-center gap-1.5"><i class="fas fa-envelope text-gold"></i> {{ config('mesi.email','contact@mesi.org') }}</span>
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
<nav id="navbar" class="sticky top-0 z-50 bg-white/95 backdrop-blur-xl border-b border-gold/20 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center h-18 gap-8" style="height:72px">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0">
                <div class="w-10 h-10 gold-gradient rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-gold/30">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo M.E.S.I"></div>
                <div class="leading-tight">
                    <div class="font-serif font-bold text-xl text-navy">M.E.SI</div>
                    <div class="text-[10px] text-slate-400 uppercase tracking-widest hidden sm:block">Mission Évangélique Sion</div>
                </div>
            </a>

            {{-- Menu desktop --}}
            <ul class="hidden lg:flex items-center gap-1 flex-1 justify-center list-none">
                <li><a href="{{ route('home') }}" class="px-3 py-2 text-sm font-bold rounded-lg transition-all {{ request()->routeIs('home') ? 'text-gold-dark bg-gold/10 border-b-2 border-gold' : 'text-slate-700 hover:text-gold-dark hover:bg-gold/10' }}">Accueil</a></li>

                <li class="has-dropdown relative">
                    <a href="{{ route('eglise.index') }}" class="px-3 py-2 text-sm font-bold rounded-lg transition-all flex items-center gap-1 {{ request()->routeIs('eglise.*') ? 'text-gold-dark bg-gold/10' : 'text-slate-700 hover:text-gold-dark hover:bg-gold/10' }}">
                        L'Église <i class="fas fa-chevron-down text-[10px] transition-transform"></i>
                    </a>
                    <div class="dropdown-menu absolute top-full left-0 mt-2 w-52 bg-white rounded-2xl shadow-2xl border border-gold/15 overflow-hidden py-2 z-50">
                        <a href="{{ route('eglise.histoire') }}" class="block px-5 py-2.5 text-sm text-slate-700 hover:bg-gold/8 hover:text-gold-dark hover:pl-7 transition-all">Notre Histoire</a>
                        <a href="{{ route('eglise.vision') }}" class="block px-5 py-2.5 text-sm text-slate-700 hover:bg-gold/8 hover:text-gold-dark hover:pl-7 transition-all">Vision & Mission</a>
                        <a href="{{ route('eglise.pasteurs') }}" class="block px-5 py-2.5 text-sm text-slate-700 hover:bg-gold/8 hover:text-gold-dark hover:pl-7 transition-all">Nos Pasteurs</a>
                        <a href="{{ route('eglise.departements') }}" class="block px-5 py-2.5 text-sm text-slate-700 hover:bg-gold/8 hover:text-gold-dark hover:pl-7 transition-all">Départements</a>
                    </div>
                </li>

                <li><a href="{{ route('cultes.index') }}" class="px-3 py-2 text-sm font-bold rounded-lg transition-all {{ request()->routeIs('cultes.*') ? 'text-gold-dark bg-gold/10 border-b-2 border-gold' : 'text-slate-700 hover:text-gold-dark hover:bg-gold/10' }}">Cultes & Live</a></li>
                <li><a href="{{ route('actualites.index') }}" class="px-3 py-2 text-sm font-bold rounded-lg transition-all {{ request()->routeIs('actualites.*') ? 'text-gold-dark bg-gold/10 border-b-2 border-gold' : 'text-slate-700 hover:text-gold-dark hover:bg-gold/10' }}">Actualités</a></li>
                <li><a href="{{ route('missions.index') }}" class="px-3 py-2 text-sm font-bold rounded-lg transition-all {{ request()->routeIs('missions.*') ? 'text-gold-dark bg-gold/10 border-b-2 border-gold' : 'text-slate-700 hover:text-gold-dark hover:bg-gold/10' }}">Missions</a></li>
                <li><a href="{{ route('sermons.index') }}" class="px-3 py-2 text-sm font-bold rounded-lg transition-all {{ request()->routeIs('sermons.*') ? 'text-gold-dark bg-gold/10 border-b-2 border-gold' : 'text-slate-700 hover:text-gold-dark hover:bg-gold/10' }}">Sermons</a></li>
                <li><a href="{{ route('contact') }}" class="px-3 py-2 text-sm font-bold rounded-lg transition-all {{ request()->routeIs('contact') ? 'text-gold-dark bg-gold/10 border-b-2 border-gold' : 'text-slate-700 hover:text-gold-dark hover:bg-gold/10' }}">Contact</a></li>
            </ul>

            {{-- Actions --}}
            <div class="flex items-center gap-2 ml-auto lg:ml-0">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="hidden sm:flex items-center gap-1.5 text-xs font-bold px-3 py-2 rounded-lg border border-navy text-navy hover:bg-navy hover:text-white transition-all">
                        <i class="fas fa-user-shield"></i> Admin
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:block text-sm font-bold text-navy hover:text-gold-dark transition-colors px-3 py-2">Connexion</a>
                @endauth
                <a href="{{ route('don') }}" class="gold-gradient text-white px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 shadow-lg shadow-gold/30 hover:shadow-gold/50 hover:-translate-y-0.5 transition-all">
                    <i class="fas fa-heart text-xs"></i> Donner
                </a>
                {{-- Burger --}}
                <button id="navToggle" class="lg:hidden flex flex-col gap-1.5 p-2 ml-1">
                    <span class="block w-6 h-0.5 bg-navy rounded transition-all"></span>
                    <span class="block w-6 h-0.5 bg-navy rounded transition-all"></span>
                    <span class="block w-6 h-0.5 bg-navy rounded transition-all"></span>
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
            @auth
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center gap-2 py-3 px-4 rounded-xl border border-white/20 text-white font-bold text-sm hover:bg-white/10 transition-all">
                    <i class="fas fa-user-shield"></i> Administration
                </a>
            @else
                <a href="{{ route('login') }}" class="flex items-center justify-center py-3 px-4 rounded-xl border border-white/20 text-white font-bold text-sm hover:bg-white/10 transition-all">Connexion</a>
            @endauth
            <a href="{{ route('don') }}" class="gold-gradient text-white flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-bold text-sm">
                <i class="fas fa-heart"></i> Faire un Don
            </a>
        </div>
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
<footer class="bg-dark text-white">
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
@stack('scripts')
</body>
</html>
