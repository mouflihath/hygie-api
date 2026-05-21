<x-guest-layout>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
* { box-sizing: border-box; }
body, .login-wrap { font-family: 'DM Sans', sans-serif; }

.login-label {
    display: block;
    font-size: 0.65rem;
    font-weight: 700;
    color: #B0BAC9;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 7px;
}
.login-input {
    width: 100%;
    background: #F8FAFC;
    border: 1.5px solid #EEF1F7;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 0.82rem;
    font-family: 'DM Sans', sans-serif;
    color: #0A1628;
    outline: none;
    transition: all 0.15s;
}
.login-input:focus {
    border-color: #059669;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(5,150,105,0.08);
}
.login-input::placeholder { color: #C8D0DC; }

.login-btn {
    width: 100%;
    background: #064E3B;
    color: white;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding: 14px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s;
}
.login-btn:hover {
    background: #059669;
    box-shadow: 0 6px 20px rgba(5,150,105,0.25);
    transform: translateY(-1px);
}

.login-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #0A1628;
    letter-spacing: -0.5px;
    margin: 0 0 4px;
}
.login-sub {
    font-size: 0.8rem;
    color: #94A3B8;
    font-weight: 500;
    margin: 0 0 32px;
}
.login-check-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.78rem;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
}
.login-forgot {
    font-size: 0.75rem;
    font-weight: 600;
    color: #64748B;
    text-decoration: none;
    transition: color 0.15s;
}
.login-forgot:hover { color: #059669; }
.login-ssl {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: 14px;
    font-size: 0.65rem;
    font-weight: 600;
    color: #B0BAC9;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}
</style>

<div class="login-wrap flex h-screen w-screen overflow-hidden">

    {{-- Gauche : image de fond assombrie --}}
    <div class="hidden md:flex w-[48%] flex-shrink-0 flex-col justify-center px-12 py-12 relative overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/formulaire.jpeg') }}')"></div>
        <div class="absolute inset-0 bg-black/55"></div>

        <div class="relative z-10 flex flex-col">
            <h1 class="font-serif text-5xl font-bold text-white leading-none mb-2">
                Hygie<span class="text-green-400">+</span>
            </h1>
            <p class="text-xs uppercase tracking-widest text-white/60 mb-8">Plateforme de gestion médicale</p>

            <p class="text-[15px] leading-relaxed text-white/85 mb-8 max-w-sm">
                <span class="font-bold text-white">Hygie+</span> est la plateforme centralisée qui permet à votre équipe de gérer les commandes de médicaments, coordonner les livraisons et suivre les pharmacies partenaires — le tout en temps réel, depuis un seul tableau de bord.
            </p>

            <div class="flex flex-wrap gap-2">
                <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-medium text-white/90 border border-white/20" style="background:rgba(255,255,255,0.12)">
                    <svg class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10H3M16 2v4M8 2v4M3 6h18v16H3z"/></svg>
                    Gestion des commandes
                </span>
                <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-medium text-white/90 border border-white/20" style="background:rgba(255,255,255,0.12)">
                    <svg class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Suivi des livraisons
                </span>
                <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-medium text-white/90 border border-white/20" style="background:rgba(255,255,255,0.12)">
                    <svg class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                    Pharmacies partenaires
                </span>
                <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-medium text-white/90 border border-white/20" style="background:rgba(255,255,255,0.12)">
                    <svg class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Gestion du personnel
                </span>
                <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-medium text-white/90 border border-white/20" style="background:rgba(255,255,255,0.12)">
                    <svg class="w-3.5 h-3.5 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    Statistiques & rapports
                </span>
            </div>
        </div>
    </div>

    {{-- Droite : formulaire --}}
    <div class="flex-1 bg-white flex items-center justify-center px-6 py-10 overflow-y-auto">
        <div class="w-full max-w-sm">

            {{-- Mobile : nom --}}
            <div class="text-center mb-8 md:hidden">
                <h1 class="font-serif text-5xl font-bold text-green-700">Hygie<span class="text-green-400">+</span></h1>
            </div>

            <p class="login-title">Bienvenue 👋</p>
            <p class="login-sub">Connectez-vous pour accéder au tableau de bord</p>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div style="margin-bottom:20px;">
                    <label class="login-label">Identifiant / E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="off"
                           placeholder="connexion@hygie.com"
                           class="login-input">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500" />
                </div>

                <div style="margin-bottom:20px;">
                    <label class="login-label">Mot de passe</label>
                    <input type="password" name="password"
                           required autocomplete="new-password"
                           placeholder="••••••••"
                           class="login-input">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-500" />
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:8px;">
                    <label class="login-check-label">
                        <input type="checkbox" name="remember" style="accent-color:#064E3B;width:15px;height:15px;">
                        Rester connecté
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="login-forgot">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <button type="submit" class="login-btn">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    Accéder au dashboard
                </button>

                <div class="login-ssl">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                    </svg>
                    Connexion sécurisée SSL
                </div>
            </form>
        </div>
    </div>
</div>
</x-guest-layout>
