<x-app-layout>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-125 transition-transform">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20"><path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path></svg>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 italic">Courses du jour</p>
            <p class="text-3xl font-black text-[#064E3B]">08</p>
        </div>

        <div class="bg-[#064E3B] p-6 rounded-3xl shadow-xl shadow-green-200 text-white">
            <p class="text-[10px] font-black text-green-300 uppercase tracking-[0.2em] mb-2 italic">Gains (FCFA)</p>
            <p class="text-3xl font-black">12.500</p>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2 italic">Score</p>
            <p class="text-3xl font-black text-[#064E3B]">4.9 <span class="text-sm font-light text-gray-400">/ 5</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-black text-gray-800 tracking-tight">Demandes de Livraisons</h3>
                <span class="flex items-center gap-2 text-[10px] font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full animate-pulse uppercase">
                    Scan actif...
                </span>
            </div>

            <div class="bg-white rounded-[2rem] p-6 border-b-4 border-green-500 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center gap-6">
                    <div class="h-16 w-16 bg-green-50 rounded-2xl flex items-center justify-center text-3xl">🏥</div>
                    <div>
                        <h4 class="font-black text-gray-800 uppercase tracking-tighter">Pharmacie de la Plage</h4>
                        <p class="text-xs text-gray-400 font-medium">📍 Cotonou, Fidjrossè • 1.2 km</p>
                        <p class="mt-2 text-[10px] inline-block px-2 py-0.5 bg-blue-100 text-blue-700 rounded font-bold uppercase tracking-wider">Médicaments Urgents</p>
                    </div>
                </div>
                <div class="text-right flex md:flex-col items-center gap-4">
                    <div>
                        <p class="text-2xl font-black text-green-600">1.500 <span class="text-xs">F</span></p>
                        <p class="text-[10px] text-gray-300 font-bold uppercase">Commission</p>
                    </div>
                    <button class="bg-[#064E3B] hover:bg-green-700 text-white px-8 py-3 rounded-2xl font-black text-xs shadow-lg shadow-green-100 transition-all active:scale-95 uppercase tracking-widest">
                        Accepter
                    </button>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Statut Véhicule</h3>
                <div class="p-4 bg-gray-50 rounded-2xl space-y-2">
                    <p class="text-xs font-bold text-gray-700">{{ Auth::user()->livreur->vehicule ?? 'Moto' }}</p>
                    <p class="text-xs text-green-600 font-mono font-bold">{{ Auth::user()->livreur->matricule ?? 'N/A' }}</p>
                </div>
            </div>

            <button class="w-full bg-red-50 text-red-600 py-4 rounded-2xl font-black text-xs uppercase tracking-widest border border-red-100 hover:bg-red-100 transition-all">
                Signaler un Problème
            </button>
        </div>
    </div>
</x-app-layout>
