<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hygie+ | {{ ucfirst(Auth::user()->role) }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            margin: 0;
            background-color: #F4F6F9;
        }

        /* ── SIDEBAR ── */
        .nav-section-label {
            padding: 0 16px;
            font-size: 0.6rem;
            font-weight: 700;
            color: rgba(110,231,183,0.6);
            text-transform: uppercase;
            letter-spacing: 0.18em;
            margin-bottom: 8px;
            display: block;
        }
        .nav-link {
            display: flex;
            align-items: center;
            padding: 10px 12px;
            border-radius: 0 12px 12px 0;
            border-left: 3px solid transparent;
            color: rgba(187,247,208,0.8);
            font-size: 0.78rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s;
            gap: 0;
        }
        .nav-link:hover {
            background: rgba(255,255,255,0.06);
        }
        .nav-link.active {
            background: rgba(255,255,255,0.12);
            border-left-color: white;
            color: white;
        }
        .nav-link.active-green {
            background: rgba(255,255,255,0.1);
            border-left-color: #6EE7B7;
            color: white;
        }
        .nav-icon-wrap {
            width: 32px; height: 32px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            background: rgba(255,255,255,0.06);
            transition: background 0.15s;
        }
        .nav-link:hover .nav-icon-wrap,
        .nav-link.active-green .nav-icon-wrap { background: #059669; }
        .nav-link.active .nav-icon-wrap { background: rgba(255,255,255,0.2); }
        .nav-label {
            margin-left: 14px;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.01em;
            white-space: nowrap;
        }

        /* ── LOGOUT ── */
        .logout-btn {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 10px 12px;
            border-radius: 0 12px 12px 0;
            border-left: 3px solid transparent;
            background: transparent;
            border-top: none; border-right: none; border-bottom: none;
            color: rgba(187,247,208,0.8);
            font-size: 0.7rem;
            font-weight: 700;
            font-family: 'DM Sans', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            cursor: pointer;
            transition: all 0.15s;
        }
        .logout-btn:hover {
            background: rgba(239,68,68,0.15);
            border-left-color: #EF4444;
            color: #FCA5A5;
        }
        .logout-btn svg { flex-shrink: 0; transition: transform 0.15s; }
        .logout-btn:hover svg { transform: translateX(3px); }

        /* ── HEADER ── */
        .header-platform-label {
            font-size: 0.6rem;
            font-weight: 700;
            color: #B0BAC9;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            line-height: 1;
        }
        .header-role-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: #064E3B;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-top: 3px;
        }
        .header-username {
            font-size: 0.78rem;
            font-weight: 700;
            color: #0A1628;
            line-height: 1;
        }
        .header-code {
            font-size: 0.62rem;
            font-family: 'DM Mono', monospace;
            font-weight: 500;
            background: #ECFDF5;
            color: #059669;
            border: 1px solid #D1FAE5;
            padding: 2px 8px;
            border-radius: 6px;
            margin-top: 3px;
            display: inline-block;
        }
        .header-avatar {
            height: 42px; width: 42px;
            border-radius: 12px;
            background: #064E3B;
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.88rem;
            font-weight: 700;
            font-family: 'DM Mono', monospace;
            box-shadow: 0 4px 14px rgba(6,78,59,0.3);
            border: 2px solid white;
            text-transform: uppercase;
        }
        .toggle-btn {
            padding: 10px;
            border-radius: 10px;
            background: #F4F6F9;
            border: 1px solid #EEF1F7;
            color: #064E3B;
            cursor: pointer;
            transition: all 0.15s;
            display: flex; align-items: center; justify-content: center;
        }
        .toggle-btn:hover { background: #064E3B; color: white; border-color: #064E3B; }
    </style>
</head>

<body class="font-sans antialiased" x-data="{ sidebarOpen: true }">
<div class="flex h-screen overflow-hidden">

    {{-- ── SIDEBAR ── --}}
    <aside :class="sidebarOpen ? 'w-68' : 'w-20'"
           style="width: var(--sidebar-w); transition: width 0.3s;"
           :style="sidebarOpen ? 'width:272px' : 'width:72px'"
           class="bg-[#064E3B] text-white flex flex-col shrink-0 z-30 shadow-2xl">

        {{-- Logo --}}
        <div class="h-20 flex items-center px-5 border-b border-white/10 shrink-0">
            <span x-show="sidebarOpen" class="font-serif font-bold text-2xl text-white leading-none">
                Hygie<span class="text-green-400">+</span>
                <span class="text-green-400 font-sans font-normal text-[10px] block leading-none tracking-widest mt-1 uppercase opacity-70">
                    {{ Auth::user()->role }}
                </span>
            </span>
            <span x-show="!sidebarOpen" class="font-serif font-bold text-xl text-white">H<span class="text-green-400">+</span></span>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 py-5 px-2 space-y-0.5 overflow-y-auto">

            {{-- Général --}}
            <span x-show="sidebarOpen" class="nav-section-label">Général</span>

            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('*.dashboard') || request()->routeIs('dashboard') ? 'active' : '' }}">
                <div class="nav-icon-wrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <span x-show="sidebarOpen" class="nav-label">Dashboard</span>
            </a>

            {{-- ADMIN --}}
            @if(Auth::user()->role === 'admin')
            <div class="pt-5 space-y-0.5">
                <span x-show="sidebarOpen" class="nav-section-label">Gestion Plateforme</span>

                <a href="{{ route('admin.pharmacies.index') }}"
                   class="nav-link {{ request()->routeIs('admin.pharmacies.*') ? 'active-green' : '' }}">
                    <div class="nav-icon-wrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" class="nav-label">Pharmacies</span>
                </a>

                <a href="{{ route('admin.utilisateurs.index') }}"
                   class="nav-link {{ request()->routeIs('admin.utilisateur.*') ? 'active-green' : '' }}">
                    <div class="nav-icon-wrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" class="nav-label">Utilisateurs</span>
                </a>

                <a href="{{ route('admin.commandes.index') }}"
                   class="nav-link {{ request()->routeIs('admin.commandes.*') ? 'active-green' : '' }}">
                    <div class="nav-icon-wrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" class="nav-label">Commandes</span>
                </a>

                <a href="{{ route('admin.revenus.index') }}"
                   class="nav-link {{ request()->routeIs('admin.revenus.*') ? 'active-green' : '' }}">
                    <div class="nav-icon-wrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" class="nav-label">Revenus</span>
                </a>

                <a href="{{ route('admin.avis.index') }}"
                   class="nav-link {{ request()->routeIs('admin.avis.*') ? 'active-green' : '' }}">
                    <div class="nav-icon-wrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" class="nav-label">Avis</span>
                </a>
            </div>
            @endif

            {{-- PHARMACIE --}}
            @if(Auth::user()->role === 'pharmacie')
            <div class="pt-5 space-y-0.5">
                <span x-show="sidebarOpen" class="nav-section-label">Ma Pharmacie</span>

                <a href="{{ route('pharmacie.commandes') }}"
                   class="nav-link {{ request()->routeIs('pharmacie.commandes') ? 'active-green' : '' }}">
                    <div class="nav-icon-wrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" class="nav-label">Mes Commandes</span>
                </a>

                <a href="{{ route('pharmacie.stocks.index') }}"
                   class="nav-link {{ request()->routeIs('pharmacie.stocks.*') ? 'active-green' : '' }}">
                    <div class="nav-icon-wrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 11v10l8 4"/>
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" class="nav-label">Mon Stock</span>
                </a>

                <a href="{{ route('pharmacie.livreurs.index') }}"
                   class="nav-link {{ request()->routeIs('pharmacie.livreurs.*') ? 'active-green' : '' }}">
                    <div class="nav-icon-wrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" class="nav-label">Mes Livreurs</span>
                </a>

                <a href="{{ route('pharmacie.revenus') }}"
                   class="nav-link {{ request()->routeIs('admin.revenus.*') ? 'active-green' : '' }}">
                    <div class="nav-icon-wrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" class="nav-label">Revenus</span>
                </a>
            </div>
            @endif

            {{-- Compte --}}
            <div class="pt-5 space-y-0.5">
                <span x-show="sidebarOpen" class="nav-section-label">Compte</span>
                <a href="{{ route('profile.edit') }}"
                   class="nav-link {{ request()->routeIs('profile.edit') ? 'active-green' : '' }}">
                    <div class="nav-icon-wrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" class="nav-label">Mon Profil</span>
                </a>
            </div>
        </nav>

        {{-- Logout --}}
        <div class="p-3 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span x-show="sidebarOpen" style="margin-left:14px;">Quitter</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- ── CONTENU ── --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Header --}}
        <header class="h-20 bg-white border-b border-gray-100 flex items-center justify-between px-8 z-20 shrink-0"
        style="box-shadow: 0 1px 0 #EEF1F7;">
    <div class="flex items-center gap-5">
        <button @click="sidebarOpen = !sidebarOpen" class="toggle-btn">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h7" stroke-width="2.5" stroke-linecap="round"/>
            </svg>
        </button>
        <div class="hidden md:block">
            <p class="header-platform-label">Plateforme Hygie+</p>
            <p class="header-role-title">
                @if(Auth::user()->role === 'admin') Administration Centrale
                @elseif(Auth::user()->role === 'pharmacie') Espace Pharmacie
                @else Espace Coursier @endif
            </p>
        </div>
    </div>

    <div class="flex items-center gap-4">

        {{-- ── Cloche de notifications ─────────────────────────────── --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                    class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors border border-gray-100"
                    style="color:#0A1628">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>

                {{-- Badge compteur --}}
                @php
                    $nbNotifs = 0;
                    if(Auth::user()->role === 'pharmacie' && Auth::user()->pharmacie) {
                        $nbNotifs = \App\Models\Commande::where('pharmacie_id', Auth::user()->pharmacie->id)
                            ->where('statut', 'en_attente')
                            ->count();
                    } elseif(Auth::user()->role === 'admin') {
                        $nbNotifs = \App\Models\Commande::where('statut', 'en_attente')->count();
                    }
                @endphp

                @if($nbNotifs > 0)
                <span class="absolute -top-1 -right-1 flex items-center justify-center min-w-[18px] h-[18px] px-1
                             text-white rounded-full text-[10px] font-bold leading-none"
                      style="background:#064E3B; font-family:'DM Mono',monospace;">
                    {{ $nbNotifs > 99 ? '99+' : $nbNotifs }}
                </span>
                @endif
            </button>

            {{-- Dropdown notifications --}}
            <div x-show="open"
                 @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50"
                 style="top:100%">

                <div class="px-5 py-4 border-b border-gray-50 flex items-center justify-between">
                    <span style="font-size:.8rem;font-weight:700;color:#0A1628;">Notifications</span>
                    @if($nbNotifs > 0)
                    <span style="font-size:.65rem;font-weight:700;background:#ECFDF5;color:#064E3B;padding:2px 8px;border-radius:20px;">
                        {{ $nbNotifs }} en attente
                    </span>
                    @endif
                </div>

                @php
                    $dernieresCommandes = collect();
                    if(Auth::user()->role === 'pharmacie' && Auth::user()->pharmacie) {
                        $dernieresCommandes = \App\Models\Commande::where('pharmacie_id', Auth::user()->pharmacie->id)
                            ->where('statut', 'en_attente')
                            ->latest()
                            ->limit(5)
                            ->get();
                    } elseif(Auth::user()->role === 'admin') {
                        $dernieresCommandes = \App\Models\Commande::where('statut', 'en_attente')
                            ->latest()
                            ->limit(5)
                            ->get();
                    }
                @endphp

                <div style="max-height:280px;overflow-y:auto;">
                    @forelse($dernieresCommandes as $cmd)
                    <a href="{{ Auth::user()->role === 'pharmacie' ? route('pharmacie.commandes') : route('admin.commandes.index') }}"
                       class="flex items-start gap-3 px-5 py-3 hover:bg-gray-50 transition-colors border-b border-gray-50 last:border-0">
                        <div class="mt-0.5 flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center"
                             style="background:#FEF3C7;">
                            <svg class="w-4 h-4" fill="none" stroke="#B45309" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p style="font-size:.78rem;font-weight:700;color:#0A1628;margin:0;">
                                Nouvelle commande
                            </p>
                            <p style="font-size:.7rem;color:#94A3B8;margin:2px 0 0;font-family:'DM Mono',monospace;">
                                {{ $cmd->reference_commande }} · {{ $cmd->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </a>
                    @empty
                    <div class="px-5 py-8 text-center">
                        <div style="font-size:1.5rem;margin-bottom:8px;">🎉</div>
                        <p style="font-size:.75rem;color:#94A3B8;font-weight:600;">Aucune commande en attente</p>
                    </div>
                    @endforelse
                </div>

                @if($nbNotifs > 5)
                <div class="px-5 py-3 border-t border-gray-50 text-center">
                    <a href="{{ Auth::user()->role === 'pharmacie' ? route('pharmacie.commandes') : route('admin.commandes.index') }}"
                       style="font-size:.75rem;font-weight:700;color:#064E3B;">
                        Voir toutes les commandes →
                    </a>
                </div>
                @endif
            </div>
        </div>

        {{-- ── Avatar + nom ────────────────────────────────────────── --}}
        <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block">
                <p class="header-username">{{ Auth::user()->name }}</p>
@if(Auth::user()->custom_code)
    <span class="header-code">{{ Auth::user()->custom_code }}</span>
@endif
            </div>

            {{-- Photo de profil ou initiale --}}
            <a href="{{ route('profile.edit') }}" class="block relative group">
                @if(Auth::user()->photo_profil)
                    <img src="{{ Storage::url(Auth::user()->photo_profil) }}"
                         alt="{{ Auth::user()->name }}"
                         class="w-10 h-10 rounded-xl object-cover border-2 border-white ring-2 ring-gray-100 group-hover:ring-green-200 transition-all">
                @else
                    <div class="header-avatar group-hover:ring-2 group-hover:ring-green-200 transition-all">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                {{-- Petit crayon au hover --}}
                <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-white border border-gray-100 rounded-full
                             flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-sm">
                    <svg class="w-2.5 h-2.5" fill="none" stroke="#064E3B" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </span>
            </a>
        </div>
    </div>
</header>
        <main class="flex-1 overflow-y-auto bg-[#F4F6F9]">
            {{ $slot }}
        </main>
    </div>
</div>
@flasher_render
</body>
</html>
