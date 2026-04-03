<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hygie+ | {{ ucfirst(Auth::user()->role) }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F8FAFC]" x-data="{ sidebarOpen: true }">
    <div class="flex h-screen overflow-hidden">

        <aside :class="sidebarOpen ? 'w-72' : 'w-20'" class="bg-[#064E3B] text-white transition-all duration-300 flex flex-col shrink-0 z-30 shadow-2xl">

            <div class="h-20 flex items-center px-6 border-b border-white/10 shrink-0">
                <div class="h-10 w-10 bg-white rounded-xl flex items-center justify-center text-[#064E3B] font-black shadow-lg shrink-0 text-lg">H+</div>
                <span x-show="sidebarOpen" class="ml-3 font-black text-xl tracking-tighter transition-all italic uppercase">
                    HYGIE+ <span class="text-green-400 font-light text-[10px] block leading-none tracking-widest">{{ Auth::user()->role }}</span>
                </span>
            </div>

            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">

                <p x-show="sidebarOpen" class="px-4 text-[10px] font-black text-green-400 uppercase tracking-widest mb-2 opacity-50 italic">Général</p>

                <a href="{{ route('dashboard') }}"
                   class="flex items-center p-3 {{ request()->routeIs('*.dashboard') || request()->routeIs('dashboard') ? 'bg-white/10 text-white shadow-lg border-l-4 border-white' : 'text-green-100 hover:bg-white/5 border-l-4 border-transparent' }} rounded-r-xl transition-all mb-4">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span x-show="sidebarOpen" class="ml-4 font-bold text-sm uppercase tracking-tight">Dashboard</span>
                </a>

               @if(Auth::user()->role === 'admin')
    <div class="pt-2 pb-2">
        <p x-show="sidebarOpen" class="px-4 text-[10px] font-black text-green-400 uppercase tracking-widest mb-3 opacity-50 italic">Gestion Plateforme</p>

        <a href="{{ route('admin.pharmacies.index') }}"
           class="flex items-center p-3 {{ request()->routeIs('admin.pharmacies.*') ? 'bg-white/10 text-white shadow-lg border-l-4 border-green-400' : 'text-green-100 hover:bg-white/5 border-l-4 border-transparent' }} rounded-r-xl transition-all group">

            <div class="h-8 w-8 {{ request()->routeIs('admin.pharmacies.*') ? 'bg-green-500 shadow-md' : 'bg-white/5' }} rounded-lg flex items-center justify-center group-hover:bg-green-500 transition-all shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>

            <span x-show="sidebarOpen" class="ml-4 font-bold text-sm">Pharmacies</span>
        </a>
    </div>
@endif

                @if(Auth::user()->role === 'pharmacie')
                    <div class="pt-2 pb-2">
                        <p x-show="sidebarOpen" class="px-4 text-[10px] font-black text-green-400 uppercase tracking-widest mb-3 opacity-50 italic">Ma Pharmacie</p>
                        <a href="#" class="flex items-center p-3 text-green-100 hover:bg-white/5 border-l-4 border-transparent rounded-r-xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <span x-show="sidebarOpen" class="ml-4 font-bold text-sm">Mes Commandes</span>
                        </a>
                    </div>
                @endif

                <div class="pt-6">
                    <p x-show="sidebarOpen" class="px-4 text-[10px] font-black text-green-400 uppercase tracking-widest mb-2 opacity-50 italic">Compte</p>
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center p-3 {{ request()->routeIs('profile.edit') ? 'bg-white/20 text-white' : 'text-green-100 hover:bg-white/10 shadow-lg border-l-4 border-transparent' }} rounded-xl transition-all">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span x-show="sidebarOpen" class="ml-4 font-bold text-sm">Mon Profil</span>
                    </a>
                </div>
            </nav>

            <div class="p-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full p-4 text-red-300 hover:bg-red-500 hover:text-white rounded-2xl transition-all group overflow-hidden">
                        <svg class="w-5 h-5 shrink-0 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span x-show="sidebarOpen" class="ml-4 font-black text-[10px] uppercase tracking-[0.2em]">Quitter</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-gray-100 flex items-center justify-between px-8 z-20 shrink-0">
                <div class="flex items-center gap-6">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-3 rounded-xl bg-gray-50 text-[#064E3B] hover:bg-green-600 hover:text-white transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h7" stroke-width="2.5" stroke-linecap="round"></path></svg>
                    </button>
                    <div class="hidden md:block">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Plateforme Hygie+</p>
                        <h1 class="text-sm font-black text-[#064E3B] italic uppercase">
                            @if(Auth::user()->role === 'admin') Administration Centrale
                            @elseif(Auth::user()->role === 'pharmacie') Espace pharmacie
                            @else Espace Coursier @endif
                        </h1>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-black text-gray-900 leading-none">{{ Auth::user()->name }}</p>
                        <span class="text-[9px] bg-green-100 text-green-700 px-2 py-0.5 rounded font-black">{{ Auth::user()->custom_code }}</span>
                    </div>
                    <div class="h-11 w-11 rounded-2xl bg-[#064E3B] text-white flex items-center justify-center font-black shadow-lg shadow-green-900/30 border-2 border-white uppercase italic">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 md:p-10 bg-[#F8FAFC]">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
