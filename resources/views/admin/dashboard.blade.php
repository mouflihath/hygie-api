<x-app-layout>
    <div class="p-8 bg-[#F8FAFC] min-h-screen">

        {{-- HEADER ADMIN --}}
        <div class="mb-10">
            <h2 class="text-4xl font-black text-[#064E3B] tracking-tighter uppercase italic">Dashboard Admin</h2>
            <p class="text-gray-400 text-sm font-bold mt-1">Vue globale de la plateforme Hygie+</p>
        </div>

        {{-- STATS PRINCIPALES --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pharmacies Partenaires</p>
                <p class="text-3xl font-black text-[#064E3B]">{{ $pharmacies->count() }}</p>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Commandes Totales</p>
                <p class="text-3xl font-black text-blue-600">{{ $totalCommandes ?? 0 }}</p>
                <p class="text-[9px] text-gray-400 font-bold mt-1">
                    dont <span class="text-blue-500">{{ $commandesAujourdhui ?? 0 }}</span> aujourd'hui
                </p>
            </div>

            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Patients inscrits</p>
                <p class="text-3xl font-black text-purple-600">{{ $totalPatients ?? 0 }}</p>
            </div>

            {{-- REVENU PLATEFORME = somme des commissions 5% --}}
            <div class="bg-[#064E3B] p-6 rounded-[2rem] shadow-xl shadow-green-100 text-white">
                <p class="text-[10px] font-black text-green-200 uppercase tracking-widest mb-1">Revenu Plateforme</p>
                <p class="text-xl font-black font-mono">{{ number_format($revenuTotal ?? 0, 0, ',', ' ') }} FCFA</p>
                <p class="text-[9px] text-green-300 font-bold mt-1">
                    + {{ number_format($revenuAujourdhui ?? 0, 0, ',', ' ') }} F aujourd'hui
                </p>
            </div>
        </div>

        {{-- COMMANDES RÉCENTES --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                <h3 class="font-black text-[#064E3B] text-sm uppercase tracking-widest italic">
                    Commandes récentes
                </h3>
                <span class="text-[9px] bg-gray-100 px-3 py-1 rounded-full font-bold text-gray-400 uppercase">
                    30 dernières
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 text-[10px] uppercase font-black text-gray-400 tracking-[0.2em]">
                        <tr>
                            <th class="px-8 py-4">Référence</th>
                            <th class="px-8 py-4">Pharmacie</th>
                            <th class="px-8 py-4">Mode</th>
                            <th class="px-8 py-4 text-right">Montant patient</th>
                            <th class="px-8 py-4 text-right">Commission Hygie+</th>
                            <th class="px-8 py-4">Statut</th>
                            <th class="px-8 py-4">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($commandesRecentes ?? [] as $cmd)
                        <tr class="hover:bg-[#F0FDF4]/30 transition-all">
                            <td class="px-8 py-4">
                                <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded text-gray-700">
                                    {{ $cmd->reference_commande ?? '—' }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-sm font-bold text-gray-700">
                                {{ $cmd->pharmacie->name ?? ('Pharmacie #' . $cmd->pharmacie_id) }}
                            </td>
                            <td class="px-8 py-4">
                                <span class="px-2 py-1 rounded-full text-[9px] font-black uppercase
                                    {{ $cmd->mode_livraison === 'livraison' ? 'bg-blue-100 text-blue-600' : 'bg-purple-100 text-purple-600' }}">
                                    {{ $cmd->mode_livraison === 'livraison' ? 'Livraison' : 'Retrait' }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right font-bold text-gray-800 text-sm">
                                {{ number_format($cmd->montant_total_patient ?? 0, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="px-8 py-4 text-right font-black text-[#064E3B] text-sm">
                                {{ number_format($cmd->commission_application ?? 0, 0, ',', ' ') }} FCFA
                            </td>
                            <td class="px-8 py-4">
                                <span class="px-2 py-1 rounded-full text-[9px] font-black uppercase
                                    {{ $cmd->etat_commande === 'livre'       ? 'bg-green-100 text-green-600' :
                                       ($cmd->etat_commande === 'en_livraison' ? 'bg-blue-100 text-blue-600' : 'bg-yellow-100 text-yellow-600') }}">
                                    {{ $cmd->etat_commande ?? 'en_attente' }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-[10px] text-gray-400 font-bold">
                                {{ $cmd->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-20 text-center">
                                <p class="text-gray-300 font-black uppercase text-[10px] tracking-[0.3em]">
                                    Aucune commande enregistrée
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- RETOURS CLIENTS --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
            <div class="flex justify-between items-center mb-8">
                <h3 class="font-black text-[#064E3B] text-sm uppercase tracking-widest italic">💬 Retours Clients Récents</h3>
                <span class="text-[9px] bg-gray-100 px-3 py-1 rounded-full font-bold text-gray-400 uppercase">Dernières activités</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($commentaires ?? [] as $com)
                <div class="bg-gray-50/50 p-5 rounded-3xl border border-gray-100 hover:border-green-200 transition-all">
                    <div class="flex gap-1 mb-2 text-amber-400 text-[10px]">★★★★★</div>
                    <p class="text-[11px] italic text-gray-600 leading-relaxed">"{{ $com->message }}"</p>
                    <div class="mt-4 flex justify-between items-center">
                        <p class="text-[9px] font-black text-gray-800 uppercase">{{ $com->user->name ?? 'Anonyme' }}</p>
                        <p class="text-[8px] text-gray-400 font-bold uppercase">{{ $com->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-16 text-center">
                    <p class="text-gray-400 font-black uppercase text-[10px] tracking-[0.3em]">Aucun commentaire</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
