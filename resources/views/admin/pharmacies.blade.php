<x-app-layout>
    <div x-data="{
        openModal: {{ $errors->any() && !session('edit_id') ? 'true' : 'false' }},
        editModal: {{ session('edit_id') || ($errors->any() && session('edit_id')) ? 'true' : 'false' }},
        showToast: '{{ session('success') }}',
        currentPh: {
            id: '{{ old('edit_id', session('edit_id')) }}',
            nom: '{{ old('nom') }}',
            email: '{{ old('email') }}',
            tel: '{{ old('telephone') }}',
            ville: '{{ old('ville', 'Cotonou') }}',
            quartier: '{{ old('quartier') }}'
        },

        initEdit(ph) {
            this.currentPh = {
                id: ph.id,
                nom: ph.nom,
                email: ph.email,
                tel: ph.tel,
                ville: ph.ville,
                quartier: ph.quartier
            };
            this.editModal = true;
        }
    }" class="p-6">

        <div class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-4xl font-black text-green-900 tracking-tighter uppercase italic leading-none">Pharmacies</h2>
                <p class="text-gray-400 font-bold text-[10px] mt-2 uppercase tracking-[0.3em]">Gestion du réseau & Partenaires</p>
            </div>
            <button @click="openModal = true" class="bg-[#064E3B] text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-xl shadow-green-100 hover:bg-black hover:scale-105 transition-all flex items-center gap-3">
                <span class="text-lg">＋</span> Ajouter une pharmacie
            </button>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50/50 text-[9px] uppercase font-black text-gray-400 tracking-[0.2em]">
                    <tr>
                        <th class="px-8 py-6">Logo & Nom</th>
                        <th class="px-8 py-6">Contact & Email</th>
                        <th class="px-8 py-6">Localisation</th>
                        <th class="px-8 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-[11px]">
                    @forelse($pharmacies as $ph)
                    <tr class="hover:bg-green-50/10 transition-all group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 rounded-2xl overflow-hidden bg-gray-100 border-2 border-white shadow-sm">
                                    @if($ph->image)
                                        <img src="{{ asset('storage/'.$ph->image) }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full bg-green-900 flex items-center justify-center text-white font-black uppercase text-[10px]">
                                            {{ substr($ph->nom_pharmacie, 0, 2) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-black text-gray-800 uppercase tracking-tight">{{ $ph->nom_pharmacie }}</p>
                                    <p class="text-[9px] text-gray-400 font-bold italic uppercase tracking-tighter">ID: #0{{ $ph->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <p class="font-bold text-gray-700">{{ $ph->telephone }}</p>
                            <p class="text-[10px] text-gray-400 lowercase">{{ $ph->user->email ?? 'Sans email' }}</p>
                        </td>
                        <td class="px-8 py-5">
                            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter">📍 {{ $ph->ville }}</span>
                            <p class="text-[9px] text-gray-400 mt-1 uppercase font-bold">{{ $ph->adresse }}</p>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-2">
                                <button @click="initEdit({
                                    id: '{{ $ph->id }}',
                                    nom: '{{ addslashes($ph->nom_pharmacie) }}',
                                    email: '{{ $ph->user->email ?? '' }}',
                                    tel: '{{ $ph->telephone }}',
                                    ville: '{{ $ph->ville }}',
                                    quartier: '{{ addslashes($ph->adresse) }}'
                                })" class="p-2.5 bg-gray-50 text-gray-400 hover:bg-[#064E3B] hover:text-white rounded-xl transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>

                                <form action="{{ route('admin.pharmacies.destroy', $ph->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-red-50 text-red-400 hover:bg-red-500 hover:text-white rounded-xl transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-20 text-center font-black text-gray-300 uppercase tracking-widest text-[10px]">Aucune pharmacie trouvée</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-green-950/60 backdrop-blur-md" x-cloak x-transition>
            <div @click.away="openModal = false" class="bg-white w-full max-w-lg rounded-[3.5rem] p-10 relative shadow-2xl">
                <h3 class="font-black text-green-900 text-2xl uppercase italic mb-1 text-center">Nouvelle Pharmacie</h3>
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest text-center mb-8 italic">Création du compte partenaire</p>

                <form action="{{ route('admin.pharmacies.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="text" name="nom" value="{{ old('nom') }}" placeholder="NOM DE LA PHARMACIE" class="w-full border-gray-100 rounded-2xl text-[10px] font-bold p-4 uppercase focus:ring-[#064E3B] @error('nom') border-red-500 @enderror" required>

                    <div class="grid grid-cols-2 gap-4">
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="EMAIL PROFESSIONNEL" class="w-full border-gray-100 rounded-2xl text-[10px] font-bold p-4 focus:ring-[#064E3B] @error('email') border-red-500 @enderror" required>
                        <input type="text" name="telephone" value="{{ old('telephone') }}" placeholder="TÉLÉPHONE" class="w-full border-gray-100 rounded-2xl text-[10px] font-bold p-4 focus:ring-[#064E3B] @error('telephone') border-red-500 @enderror" required>
                    </div>

                    <input type="password" name="password" placeholder="MOT DE PASSE (MIN 6 CARACTÈRES)" class="w-full border-gray-100 rounded-2xl text-[10px] font-bold p-4 focus:ring-[#064E3B]" required>

                    <div class="grid grid-cols-2 gap-4">
                        <select name="ville" class="w-full border-gray-100 rounded-2xl text-[10px] font-bold p-4 focus:ring-[#064E3B]">
                            <option value="Cotonou" {{ old('ville') == 'Cotonou' ? 'selected' : '' }}>COTONOU</option>
                            <option value="Calavi" {{ old('ville') == 'Calavi' ? 'selected' : '' }}>CALAVI</option>
                        </select>
                        <input type="text" name="quartier" value="{{ old('quartier') }}" placeholder="QUARTIER / ADRESSE" class="w-full border-gray-100 rounded-2xl text-[10px] font-bold p-4 uppercase focus:ring-[#064E3B]">
                    </div>

                    <div class="p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <label class="text-[9px] font-black text-gray-400 uppercase mb-2 block tracking-widest">Logo de l'établissement</label>
                        <input type="file" name="image" class="text-[9px] font-bold text-gray-500 w-full">
                    </div>

                    <button type="submit" class="w-full bg-[#064E3B] text-white py-5 rounded-[2rem] font-black uppercase text-[10px] mt-4 shadow-xl hover:bg-black transition-all tracking-widest">
                        Enregistrer la pharmacie
                    </button>
                </form>
            </div>
        </div>

        <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-md" x-cloak x-transition>
            <div @click.away="editModal = false" class="bg-white w-full max-w-lg rounded-[3.5rem] p-10 relative border-t-8 border-yellow-500 shadow-2xl">
                <h3 class="font-black text-gray-800 text-2xl uppercase italic mb-1 text-center">Modifier Pharmacie</h3>
                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest text-center mb-8 italic" x-text="'Mise à jour de l\'ID: #0' + currentPh.id"></p>

                <form :action="'/admin/pharmacies/' + currentPh.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="edit_id" :value="currentPh.id">

                    <input type="text" name="nom" x-model="currentPh.nom" placeholder="NOM" class="w-full border-gray-100 rounded-2xl text-[10px] font-bold p-4 uppercase focus:ring-yellow-500" required>

                    <div class="grid grid-cols-2 gap-4">
                        <input type="email" name="email" x-model="currentPh.email" placeholder="EMAIL" class="w-full border-gray-100 rounded-2xl text-[10px] font-bold p-4 focus:ring-yellow-500" required>
                        <input type="text" name="telephone" x-model="currentPh.tel" placeholder="TÉLÉPHONE" class="w-full border-gray-100 rounded-2xl text-[10px] font-bold p-4 focus:ring-yellow-500" required>
                    </div>

                    <div class="p-4 bg-yellow-50/50 rounded-2xl border border-yellow-100">
                        <p class="text-[8px] text-yellow-700 font-black uppercase mb-2 tracking-tighter">Sécurité du compte</p>
                        <input type="password" name="password" placeholder="NOUVEAU MOT DE PASSE (LAISSER VIDE SI INCHANGÉ)" class="w-full border-white rounded-xl text-[10px] font-bold p-4 focus:ring-yellow-500 shadow-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <select name="ville" x-model="currentPh.ville" class="w-full border-gray-100 rounded-2xl text-[10px] font-bold p-4 focus:ring-yellow-500">
                            <option value="Cotonou">COTONOU</option>
                            <option value="Calavi">CALAVI</option>
                        </select>
                        <input type="text" name="quartier" x-model="currentPh.quartier" placeholder="QUARTIER" class="w-full border-gray-100 rounded-2xl text-[10px] font-bold p-4 uppercase focus:ring-yellow-500">
                    </div>

                    <div class="p-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200 flex items-center gap-4">
                         <div class="w-10 h-10 bg-white rounded-lg border flex items-center justify-center text-[15px]">🖼️</div>
                         <input type="file" name="image" class="text-[9px] font-bold text-gray-500 flex-1">
                    </div>

                    <button type="submit" class="w-full bg-yellow-500 text-black py-5 rounded-[2rem] font-black uppercase text-[10px] mt-4 shadow-xl shadow-yellow-100 hover:bg-black hover:text-white transition-all">
                        Sauvegarder les modifications
                    </button>
                    <button type="button" @click="editModal = false" class="w-full text-gray-400 text-[10px] font-black uppercase mt-4 hover:text-red-500 transition-colors">Annuler</button>
                </form>
            </div>
        </div>

        <template x-if="showToast">
            <div x-init="setTimeout(() => showToast = false, 5000)" class="fixed bottom-10 right-10 z-[100] bg-black text-white px-8 py-5 rounded-[2rem] flex items-center gap-4 shadow-2xl border border-green-500/50">
                <div class="h-8 w-8 bg-green-500 rounded-full flex items-center justify-center text-black font-black">✓</div>
                <div>
                    <p class="text-[8px] font-black text-green-500 uppercase tracking-widest">Succès</p>
                    <p class="text-[11px] font-bold" x-text="showToast"></p>
                </div>
            </div>
        </template>

    </div>
</x-app-layout>
