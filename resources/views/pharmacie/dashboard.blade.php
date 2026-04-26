<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <div>
                <div class="flex items-center gap-4">
                    <h2 class="text-4xl font-black text-[#064E3B] tracking-tighter uppercase italic leading-none">
                        {{ Auth::user()->pharmacie->nom_pharmacie ?? 'Ma Pharmacie' }}
                    </h2>
                    <span class="bg-[#10B981]/10 text-[#10B981] text-[10px] px-3 py-1 rounded-full font-black border border-[#10B981]/20 uppercase tracking-widest">
                        Compte Officiel
                    </span>
                </div>
                <p class="text-gray-400 font-bold text-sm mt-2 flex items-center gap-2">
                    <span class="text-[#10B981]">📍</span>
                    {{ Auth::user()->pharmacie->ville ?? 'Cotonou' }}, {{ Auth::user()->pharmacie->adresse ?? 'Bénin' }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-400 font-bold">Dernière mise à jour</p>
                <p class="text-sm font-black text-gray-600">{{ now()->format('d/m/Y à H:i') }}</p>
            </div>
        </div>

        {{-- STATISTIQUES --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

            {{-- Stock --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-50">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-green-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Stock Médicaments</p>
                <p class="text-4xl font-black text-[#064E3B] tracking-tighter">{{ $totalProduits ?? 0 }}</p>
            </div>

            {{-- Nouvelles commandes --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-50 relative">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Nouvelles commandes</p>
                <p class="text-4xl font-black text-blue-500 tracking-tighter">{{ $commandes->where('statut', 'en_attente')->count() }}</p>
               
            </div>

            {{-- Total livrées --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-50">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-1">Total livrées</p>
                <p class="text-4xl font-black text-gray-800 tracking-tighter">{{ $totalLivrees ?? 0}}</p>
            </div>

            {{-- Chiffre d'affaires --}}
            <div class="bg-[#064E3B] p-8 rounded-[2.5rem] shadow-[0_30px_60px_-15px_rgba(6,78,59,0.4)] text-white">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-white/10 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black text-[#10B981] uppercase tracking-[0.2em] mb-1">Chiffre d'affaires</p>
                <p class="text-xl font-black font-mono tracking-tighter">
                    {{ number_format($commandes->sum('montant_pharmacie') ?? 0, 0, ',', ' ') }} FCFA
                </p>
            </div>
        </div>

        {{-- TABLEAU DES COMMANDES --}}
        <div class="bg-white rounded-[3rem] shadow-sm border border-gray-50 overflow-hidden">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                <h3 class="font-black text-[#064E3B] text-xl uppercase tracking-tighter italic">
                    Commandes reçues via Hygie+
                </h3>
                <div class="flex items-center gap-3">
                    <span class="text-[9px] bg-green-50 text-green-600 px-3 py-1 rounded-full font-black uppercase border border-green-100">
                        {{ $totalCommandes ?? 0 }} commandes
                    </span>
                    <span class="flex items-center gap-1 text-[9px] text-green-500 font-black">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse inline-block"></span>
                        LIVE
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 text-[10px] uppercase font-black text-gray-400 tracking-[0.3em]">
                        <tr>
                            <th class="px-6 py-5">Référence</th>
                            <th class="px-6 py-5">Patient</th>
                            <th class="px-6 py-5">Médicaments</th>
                            <th class="px-6 py-5">Mode</th>
                            <th class="px-6 py-5">Paiement</th>
                            <th class="px-6 py-5 text-right">Montant pharmacie</th>
                            <th class="px-6 py-5">État</th>
                            <th class="px-6 py-5">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($commandes ?? [] as $cmd)
                        <tr class="hover:bg-[#F0FDF4]/50 transition-all">

                            {{-- Référence --}}
                            <td class="px-6 py-5">
                                <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded-lg text-gray-700">
                                    {{ $cmd->reference_commande ?? '#' . $cmd->id }}
                                </span>
                            </td>

                            {{-- Patient --}}
                            <td class="px-6 py-5">
                                <p class="font-black text-gray-800 text-sm">
                                    {{ $cmd->patient_nom ?? ($cmd->patient->name ?? 'Patient') }}
                                </p>
                                <p class="text-[9px] text-gray-400 font-bold">
                                    {{ $cmd->patient_telephone ?? '—' }}
                                </p>
                            </td>

                            {{-- Médicaments --}}
                            <td class="px-6 py-5">
                                @if($cmd->lignes && $cmd->lignes->count() > 0)
                                    @foreach($cmd->lignes as $ligne)
                                        <div class="text-xs text-gray-600 mb-1">
                                            <span class="font-bold">{{ $ligne->nom }}</span>
                                            × {{ $ligne->quantite }}
                                            <span class="text-gray-400 ml-1">{{ number_format($ligne->prix, 0, ',', ' ') }} F</span>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="text-gray-400 text-xs italic">Non renseigné</span>
                                @endif
                            </td>

                            {{-- Mode --}}
                            <td class="px-6 py-5">
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest
                                    {{ $cmd->mode_livraison === 'livraison' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }}">
                                    {{ $cmd->mode_livraison === 'livraison' ? '🚚 Livraison' : '🏪 Retrait' }}
                                </span>
                            </td>

                            {{-- Paiement --}}
                            <td class="px-6 py-5">
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs font-bold uppercase
                                        {{ ($cmd->statut_paiement ?? '') === 'payé' ? 'text-green-600' : 'text-amber-500' }}">
                                        {{ ($cmd->statut_paiement ?? '') === 'payé' ? '✅ Payé' : '⏳ En attente' }}
                                    </span>
                                    @if($cmd->fedapay_transaction_id)
                                        <span class="text-[9px] text-gray-400 font-mono">
                                            ID: {{ $cmd->fedapay_transaction_id }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Montant pharmacie --}}
                            <td class="px-6 py-5 text-right">
                                <p class="font-black text-[#064E3B] text-sm">
                                    {{ number_format($cmd->montant_pharmacie ?? $cmd->montant_total ?? 0, 0, ',', ' ') }} FCFA
                                </p>
                                @if($cmd->commission_application)
                                    <p class="text-[9px] text-gray-400">
                                        Commission : {{ number_format($cmd->commission_application, 0, ',', ' ') }} F
                                    </p>
                                @endif
                            </td>

                            {{-- État --}}
                            <td class="px-6 py-5">
                                <form action="{{ route('pharmacie.commandes.statut', $cmd->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <select
                                        name="etat_commande"
                                        onchange="this.form.submit()"
                                        class="text-[9px] font-black uppercase rounded-full px-3 py-1 border cursor-pointer focus:outline-none
                                            {{ $cmd->etat_commande === 'en_attente'   ? 'bg-yellow-100 text-yellow-700 border-yellow-200' :
                                               ($cmd->etat_commande === 'en_livraison' ? 'bg-blue-100 text-blue-700 border-blue-200' :
                                               ($cmd->etat_commande === 'livre'        ? 'bg-green-100 text-green-700 border-green-200' :
                                               ($cmd->etat_commande === 'a_retirer'    ? 'bg-purple-100 text-purple-700 border-purple-200' :
                                               ($cmd->etat_commande === 'en_preparation' ? 'bg-orange-100 text-orange-700 border-orange-200' :
                                               'bg-gray-100 text-gray-600 border-gray-200')))) }}"
                                    >
                                        <option value="en_attente"      {{ $cmd->etat_commande === 'en_attente'      ? 'selected' : '' }}>⏳ En attente</option>
                                        <option value="en_preparation"  {{ $cmd->etat_commande === 'en_preparation'  ? 'selected' : '' }}>💊 En préparation</option>
                                        <option value="en_livraison"    {{ $cmd->etat_commande === 'en_livraison'    ? 'selected' : '' }}>🚚 En livraison</option>
                                        <option value="a_retirer"       {{ $cmd->etat_commande === 'a_retirer'       ? 'selected' : '' }}>🏪 À retirer</option>
                                        <option value="livre"           {{ $cmd->etat_commande === 'livre'           ? 'selected' : '' }}>✅ Livré</option>
                                    </select>
                                </form>
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-5 text-[10px] text-gray-400 font-bold whitespace-nowrap">
                                {{ $cmd->created_at->format('d/m/Y') }}<br>
                                <span class="text-gray-300">{{ $cmd->created_at->format('H:i') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-32 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                    </div>
                                    <p class="font-black text-gray-300 uppercase tracking-[0.5em] italic text-sm">
                                        Aucune commande reçue
                                    </p>
                                    <p class="text-gray-300 text-xs">Les commandes passées via Hygie+ apparaîtront ici automatiquement</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @if(session('success'))
    <div class="fixed bottom-6 right-6 bg-green-500 text-white px-6 py-3 rounded-2xl shadow-lg font-bold text-sm z-50"
         x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
        ✅ {{ session('success') }}
    </div>
    @endif

</x-app-layout>
