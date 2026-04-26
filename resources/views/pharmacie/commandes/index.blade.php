<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-800 leading-tight">
                {{ __('Tableau de bord des Commandes') }}
            </h2>
            <div class="bg-emerald-500 text-white px-4 py-1 rounded-full text-sm font-bold shadow-lg shadow-emerald-200">
                Hygie+ Live
            </div>
        </div>
    </x-slot>

    <div class="py-12" style="font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Stats rapides --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Total Reçu</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $commandes->count() }}</h3>
                </div>
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">En attente</p>
                    <h3 class="text-3xl font-black text-amber-500">{{ $commandes->where('statut', 'en_attente')->count() }}</h3>
                </div>
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
                    <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Chiffre d'affaires</p>
                    <h3 class="text-3xl font-black text-emerald-600">{{ number_format($commandes->sum('montant_total'), 0, ',', ' ') }} <small class="text-sm">CFA</small></h3>
                </div>
            </div>

            {{-- Table des commandes --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-[2.5rem] border border-slate-100">
                <div class="p-8 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-separate border-spacing-y-3">
                            <thead>
                                <tr class="text-slate-400 text-xs font-black uppercase tracking-widest">
                                    <th class="px-6 py-4">Commande</th>
                                    <th class="px-6 py-4">Statut</th>
                                    <th class="px-6 py-4">Mode</th>
                                    <th class="px-6 py-4">Montant</th>
                                    <th class="px-6 py-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($commandes as $commande)
                                <tr class="bg-slate-50/50 hover:bg-emerald-50/50 transition-colors rounded-2xl">
                                    <td class="px-6 py-5 rounded-l-3xl">
                                        <div class="flex flex-col">
                                            <span class="font-black text-slate-800 text-lg">#CMD-{{ $commande->id }}</span>
                                            <span class="text-slate-400 text-xs font-bold">{{ $commande->created_at->format('d M Y à H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase {{ $commande->statut == 'en_attente' ? 'bg-amber-100 text-amber-600' : 'bg-emerald-100 text-emerald-600' }}">
                                            {{ $commande->statut }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2 text-slate-600 font-bold text-sm">
                                            @if($commande->mode_livraison == 'retrait')
                                                <i class="bi bi-shop"></i> Retrait
                                            @else
                                                <i class="bi bi-truck"></i> Livraison
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span class="text-emerald-600 font-black text-lg">
                                            {{ number_format($commande->montant_total, 0, ',', ' ') }}
                                        </span>
                                        <span class="text-[10px] font-bold text-emerald-400">CFA</span>
                                    </td>
                                    <td class="px-6 py-5 rounded-r-3xl text-center">
                                        <div class="flex justify-center gap-2">
                                            <button class="bg-slate-800 text-white p-2 rounded-xl hover:bg-emerald-600 transition shadow-sm" title="Voir détails">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <button class="bg-white border border-slate-200 text-slate-400 p-2 rounded-xl hover:text-emerald-600 hover:border-emerald-200 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="bg-slate-50 p-6 rounded-full mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                            </div>
                                            <p class="text-slate-400 font-bold">Aucune commande reçue pour le moment.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Importation des icônes Bootstrap pour le style Chic --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    </style>
</x-app-layout>
