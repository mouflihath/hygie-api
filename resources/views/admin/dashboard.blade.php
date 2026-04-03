<x-app-layout>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Pharmacies Partenaires</p>
            <p class="text-3xl font-black text-[#064E3B]">{{ $pharmacies->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Commandes Totales</p>
            <p class="text-3xl font-black text-blue-600">{{ $totalCommandes ?? 0 }}</p>
        </div>
        <div class="bg-[#064E3B] p-6 rounded-[2rem] shadow-xl shadow-green-100 text-white">
            <p class="text-[10px] font-black text-green-200 uppercase tracking-widest mb-1">Revenu Plateforme</p>
            <p class="text-xl font-black">{{ number_format($revenuTotal ?? 0, 0, ',', ' ') }} F</p>
        </div>
    </div>

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
                <p class="text-gray-400 font-black uppercase text-[10px] tracking-[0.3em]">Aucun commentaire enregistré pour le moment</p>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
