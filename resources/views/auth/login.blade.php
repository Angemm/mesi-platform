<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — M.E.SI Administration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{colors:{gold:{DEFAULT:'#e8b04b',dark:'#c0892e'},navy:{DEFAULT:'#0d1b3e'}},fontFamily:{serif:['"Playfair Display"','serif'],sans:['Lato','sans-serif']}}}}</script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>.gold-gradient{background:linear-gradient(135deg,#e8b04b,#c0892e);} .navy-gradient{background:linear-gradient(135deg,#0d1b3e,#1a3a6e);}</style>
</head>
<body class="font-sans bg-slate-100 min-h-screen flex items-center justify-center p-4" style="background-image:radial-gradient(circle, rgba(13,27,62,.05) 1px,transparent 1px);background-size:32px 32px;">

<div class="w-full max-w-md">

    {{-- Logo --}}
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
            <div class="w-12 h-12 gold-gradient rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-xl shadow-gold/30">✝</div>
            <div class="text-left">
                <div class="font-serif font-bold text-navy text-xl leading-tight">M.E.SI</div>
                <div class="text-[10px] text-slate-400 uppercase tracking-widest">Mission Évangélique Sion</div>
            </div>
        </a>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-2xl shadow-slate-200 p-8 md:p-10">
        <h1 class="font-serif font-black text-slate-900 text-2xl mb-1">Connexion</h1>
        <p class="text-slate-400 text-sm mb-8">Espace réservé aux administrateurs et éditeurs.</p>

        @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-2xl px-4 py-3 mb-6 flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
            <p class="text-red-700 text-sm font-medium">Identifiants incorrects. Veuillez réessayer.</p>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Adresse email</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-sm"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="admin@mesi.org"
                           class="w-full border border-slate-200 bg-slate-50 rounded-xl pl-10 pr-4 py-3.5 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/15 transition-all @error('email') border-red-300 bg-red-50 @enderror">
                </div>
            </div>

            <div>
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">Mot de passe</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 text-sm"></i>
                    <input type="password" name="password" id="passwordField" required
                           placeholder="••••••••"
                           class="w-full border border-slate-200 bg-slate-50 rounded-xl pl-10 pr-12 py-3.5 text-sm focus:outline-none focus:border-gold/60 focus:bg-white focus:ring-2 focus:ring-gold/15 transition-all">
                    <button type="button" onclick="togglePwd()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 hover:text-slate-500 transition-colors">
                        <i class="fas fa-eye text-sm" id="pwdToggleIcon"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded accent-gold">
                    <span class="text-sm text-slate-500 font-medium">Se souvenir de moi</span>
                </label>
                @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-gold-dark font-bold hover:underline">Mot de passe oublié ?</a>
                @endif
            </div>

            <button type="submit" class="w-full gold-gradient text-white py-4 rounded-xl font-bold text-sm flex items-center justify-center gap-2.5 shadow-lg shadow-gold/30 hover:shadow-gold/50 hover:-translate-y-0.5 transition-all">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>
    </div>

    <p class="text-center mt-6 text-xs text-slate-400">
        <a href="{{ route('home') }}" class="hover:text-slate-600 transition-colors flex items-center gap-1 justify-center">
            <i class="fas fa-arrow-left text-[10px]"></i> Retour au site
        </a>
    </p>
</div>

<script>
function togglePwd() {
    const f = document.getElementById('passwordField');
    const i = document.getElementById('pwdToggleIcon');
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'password' ? 'fas fa-eye text-sm' : 'fas fa-eye-slash text-sm';
}
</script>
</body>
</html>
