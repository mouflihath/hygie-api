<x-app-layout>
    <div x-data="{ openModal: false }">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-3xl font-black text-green-900 tracking-tighter uppercase">
                        {{ Auth::user()->pharmacie->nom_pharmacie ?? 'Ma Pharmacie' }}
                    </h2>
                    <span class="bg-green-100 text-green-700 text-[10px] px-2 py-1 rounded-full font-bold border border-green-200 uppercase tracking-widest">Compte Vérifié</span>
                </div>
                <p class="text-gray-500 font-medium text-sm mt-1 italic">
                    📍 Cotonou, Avenue Jean-Paul II (Aperçu statique)
                </p>
            </div>

            <button @click="openModal = true"
                class="bg-[#064E3B] hover:bg-green-700 text-white px-8 py-4 rounded-[2rem] font-black text-sm shadow-xl shadow-green-100 transition-all flex items-center gap-3 active:scale-95">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                NOUVELLE LIVRAISON
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Stock Produits</p>
                <p class="text-3xl font-black text-green-800">124</p>
            </div>
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 text-blue-600">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Commandes En cours</p>
                <p class="text-3xl font-black">08</p>
            </div>
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 text-gray-800">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Livrées</p>
                <p class="text-3xl font-black">42</p>
            </div>
            <div class="bg-[#064E3B] p-6 rounded-[2rem] shadow-xl shadow-green-100 text-white">
                <p class="text-[10px] font-black text-green-200 uppercase tracking-widest mb-1">Contact Pro</p>
                <p class="text-xl font-bold font-mono">+229 67 00 00 00</p>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                <h3 class="font-black text-green-900 text-lg uppercase tracking-tighter italic">Historique des expéditions</h3>
            </div>
            <div class="overflow-x-auto text-sm">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 text-[10px] uppercase font-black text-gray-400 tracking-[0.2em]">
                        <tr>
                            <th class="px-8 py-4">Client</th>
                            <th class="px-8 py-4">Destination</th>
                            <th class="px-8 py-4">Status</th>
                            <th class="px-8 py-4 text-right">Livreur</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr class="hover:bg-green-50/20 transition-all">
                            <td class="px-8 py-5 font-bold text-gray-800">Marc Gnonlonfoun</td>
                            <td class="px-8 py-5 text-gray-500 italic">Fidjrossè, Villa 42</td>
                            <td class="px-8 py-5 text-blue-600 font-black uppercase text-[10px]">En route</td>
                            <td class="px-8 py-5 text-right font-bold text-[#064E3B]">Saliou B.</td>
                        </tr>
                        <tr class="hover:bg-green-50/20 transition-all">
                            <td class="px-8 py-5 font-bold text-gray-800">Alice Johnson</td>
                            <td class="px-8 py-5 text-gray-500 italic">Cadjehoun, Rue 102</td>
                            <td class="px-8 py-5 text-green-600 font-black uppercase text-[10px]">Livrée</td>
                            <td class="px-8 py-5 text-right font-bold text-[#064E3B]">Koffi A.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" @click="openModal = false"></div>
                <div class="relative bg-white rounded-[2.5rem] w-full max-w-lg p-10 shadow-2xl">
                    <h3 class="text-2xl font-black text-green-900 mb-6 uppercase tracking-tighter">📦 Nouvelle Expédition</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Nom du Client</label>
                            <input type="text" class="w-full mt-1 bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-green-500">
                        </div>
                        <div class="flex gap-4 pt-4">
                            <button @click="openModal = false" class="w-1/2 py-4 text-gray-400 font-bold uppercase text-xs tracking-widest">Annuler</button>
                            <button @click="openModal = false" class="w-1/2 py-4 bg-green-600 text-white rounded-2xl font-black shadow-lg shadow-green-100 uppercase text-xs tracking-widest active:scale-95">Confirmer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
