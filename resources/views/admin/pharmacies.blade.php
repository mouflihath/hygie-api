<x-app-layout>
    <div x-data="{
        openModal: {{ $errors->any() && !session('edit_id') ? 'true' : 'false' }},
        editModal: false,
        showToast: '{{ session('success') }}',
        currentPh: { id: '', nom: '', email: '', tel: '', ville: '', quartier: '' },

        initEdit(ph) {
            this.currentPh = ph;
            this.editModal = true;
        }
    }" class="p-8 bg-[#F8FAFC] min-h-screen font-sans">

        {{-- Header --}}
        <div class="flex flex-wrap justify-between items-end mb-12 gap-6">
            <div>
                <h2 class="text-5xl font-black text-[#064E3B] tracking-tighter uppercase italic leading-none">
                    Réseau <span class="text-[#10B981]">Pharmacies</span>
                </h2>
                <p class="text-gray-400 font-bold text-[10px] mt-4 uppercase tracking-[0.4em] flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-[#10B981] rounded-full animate-ping"></span>
                    Gestion du réseau & Partenaires stratégiques
                </p>
            </div>
            <button @click="openModal = true" class="bg-[#064E3B] text-white px-10 py-5 rounded-[1.8rem] font-black text-[11px] uppercase shadow-lg hover:bg-black transition-all">
                ＋ Ajouter un établissement
            </button>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-[3rem] shadow-xl border border-gray-50 overflow-hidden">
            <table class="w-full text-left border-separate border-spacing-0">
                <thead class="bg-gray-50/40 text-[10px] uppercase font-black text-gray-400 tracking-[0.25em]">
                    <tr>
                        <th class="px-10 py-8 border-b">Établissement</th>
                        <th class="px-10 py-8 border-b">Contact & Info</th>
                        <th class="px-10 py-8 border-b">Zone Géographique</th>
                        <th class="px-10 py-8 border-b text-right">Gestion</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-[12px]">
                    @forelse($pharmacies as $ph)
                    <tr class="hover:bg-[#F0FDF4]/50 transition-all group">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-5">
                                <div class="h-16 w-16 rounded-2xl overflow-hidden bg-white border border-gray-100 p-1">
                                    @if($ph->image)
                                        <img src="{{ asset('storage/'.$ph->image) }}" class="h-full w-full object-cover rounded-xl">
                                    @else
                                        <div class="h-full w-full bg-emerald-700 flex items-center justify-center text-white font-black rounded-xl">
                                            {{ substr($ph->nom_pharmacie, 0, 2) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-black text-gray-800 uppercase text-[13px]">{{ $ph->nom_pharmacie }}</p>
                                    <p class="text-[9px] text-[#10B981] font-black uppercase mt-1">Ref: #0{{ $ph->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <p class="font-bold text-gray-700">{{ $ph->telephone }}</p>
                            <p class="text-[10px] text-gray-400 lowercase">{{ $ph->user->email ?? 'Sans email' }}</p>
                        </td>
                        <td class="px-10 py-6">
                            <span class="bg-[#064E3B] text-white px-4 py-1.5 rounded-full text-[9px] font-black uppercase">📍 {{ $ph->ville }}</span>
                            <p class="text-[10px] text-gray-400 mt-2 uppercase font-bold">{{ $ph->adresse }}</p>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end gap-3 translate-x-4 opacity-0 group-hover:opacity-100 group-hover:translate-x-0 transition-all">
                                <button @click="initEdit({
                                    id: '{{ $ph->id }}',
                                    nom: '{{ addslashes($ph->nom_pharmacie) }}',
                                    email: '{{ $ph->user->email ?? '' }}',
                                    tel: '{{ $ph->telephone }}',
                                    ville: '{{ $ph->ville }}',
                                    quartier: '{{ addslashes($ph->adresse) }}'
                                })" class="p-3 bg-white text-gray-400 hover:text-[#064E3B] rounded-xl border">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form action="{{ route('admin.pharmacies.destroy', $ph->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-3 bg-white text-red-300 hover:text-red-500 rounded-xl border">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-20 text-center font-black text-gray-300 uppercase">Aucun partenaire</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- MODALE AJOUT --}}
        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center p-6" x-cloak>
            <div @click="openModal = false" class="absolute inset-0 bg-[#064E3B]/60 backdrop-blur-xl"></div>
            <div class="bg-white w-full max-w-xl rounded-[4rem] overflow-hidden relative shadow-2xl">
                <div class="bg-[#064E3B] p-12 text-center text-white">
                    <h3 class="font-black text-3xl uppercase italic tracking-tighter">Nouvelle Pharmacie</h3>
                </div>
                <form action="{{ route('admin.pharmacies.store') }}" method="POST" enctype="multipart/form-data" class="p-12 space-y-5">
                    @csrf
                    <input type="text" name="nom_pharmacie" placeholder="NOM DE L'ÉTABLISSEMENT" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-5 font-bold uppercase" required>
                    <div class="grid grid-cols-2 gap-5">
                        <input type="email" name="email" placeholder="EMAIL" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-5 font-bold" required>
                        <input type="text" name="telephone" placeholder="TÉLÉPHONE" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-5 font-bold" required>
                    </div>
                    <input type="password" name="password" placeholder="MOT DE PASSE" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-5 font-bold" required>
                    <div class="grid grid-cols-2 gap-5">
                        {{-- Villes dynamiques issues du contrôleur --}}
                        <select name="ville" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-5 font-bold" required>
                            <option value="" disabled selected>CHOISIR VILLE</option>
                            @foreach($villes ?? [] as $ville)
                                <option value="{{ $ville }}">{{ strtoupper($ville) }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="adresse" placeholder="ADRESSE" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-5 font-bold uppercase">
                    </div>
                    <input type="file" name="image" class="w-full text-[10px]" accept="image/*">
                    <button type="submit" class="w-full bg-[#064E3B] text-white py-6 rounded-[2rem] font-black uppercase shadow-xl hover:bg-black transition-all">Enregistrer</button>
                </form>
            </div>
        </div>

        {{-- MODALE ÉDITION --}}
        <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center p-6" x-cloak>
            <div @click="editModal = false" class="absolute inset-0 bg-black/60 backdrop-blur-xl"></div>
            <div class="bg-white w-full max-w-xl rounded-[4rem] overflow-hidden relative shadow-2xl">
                <div class="bg-gray-900 p-12 text-center text-white">
                    <h3 class="font-black text-3xl uppercase italic tracking-tighter">Modifier Partenaire</h3>
                </div>
                <form :action="'{{ url('admin/pharmacies') }}/' + currentPh.id" method="POST" enctype="multipart/form-data" class="p-12 space-y-5">
                    @csrf @method('PUT')
                    <input type="text" name="nom_pharmacie" x-model="currentPh.nom" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-5 font-bold uppercase" required>
                    <div class="grid grid-cols-2 gap-5">
                        <input type="email" name="email" x-model="currentPh.email" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-5 font-bold" required>
                        <input type="text" name="telephone" x-model="currentPh.tel" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-5 font-bold" required>
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        {{-- Villes dynamiques liées avec AlpineJS x-model --}}
                        <select name="ville" x-model="currentPh.ville" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-5 font-bold" required>
                            @foreach($villes ?? [] as $ville)
                                <option value="{{ $ville }}">{{ strtoupper($ville) }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="adresse" x-model="currentPh.quartier" class="w-full bg-gray-50 border-none rounded-[1.5rem] p-5 font-bold uppercase">
                    </div>
                    {{-- AJOUT : Input file pour modifier l'image --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-wider block pl-2">Modifier le logo (optionnel)</label>
                        <input type="file" name="image" class="w-full text-[10px]" accept="image/*">
                    </div>
                    <button type="submit" class="w-full bg-black text-white py-6 rounded-[2rem] font-black uppercase shadow-xl hover:bg-[#064E3B] transition-all">Sauvegarder</button>
                </form>
            </div>
        </div>

        {{-- Toast Notification --}}
        <template x-if="showToast">
            <div x-init="setTimeout(() => showToast = false, 4000)" class="fixed bottom-12 right-12 bg-black text-white px-8 py-4 rounded-full shadow-2xl flex items-center gap-4">
                <span class="text-green-400">✓</span> <span x-text="showToast"></span>
            </div>
        </template>
    </div>
</x-app-layout>
