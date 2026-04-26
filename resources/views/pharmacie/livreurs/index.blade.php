<x-app-layout>
    <div x-data="{
        openModal: {{ $errors->any() && !session('edit_id') ? 'true' : 'false' }},
        editModal: {{ session('edit_id') || ($errors->any() && session('edit_id')) ? 'true' : 'false' }},
        showToast: '{{ session('success') }}',
        currentLivreur: {
            id: '{{ old('edit_id', session('edit_id')) }}',
            name: '{{ old('name') }}',
            email: '{{ old('email') }}',
            telephone: '{{ old('telephone') }}',
            matricule: '{{ old('matricule') }}',
            vehicule: '{{ old('vehicule') }}'
        },

        initEdit(l) {
            this.currentLivreur = {
                id: l.id,
                name: l.name,
                email: l.email,
                telephone: l.telephone,
                matricule: l.matricule,
                vehicule: l.vehicule
            };
            this.editModal = true;
        }
    }" class="p-8 bg-[#F8FAFC] min-h-screen font-sans">

        <div class="flex flex-wrap justify-between items-end mb-12 gap-6">
            <div>
                <h2 class="text-5xl font-black text-[#064E3B] tracking-tighter uppercase italic leading-none">
                    Gestion <span class="text-[#10B981]">Livreurs</span>
                </h2>
                <p class="text-gray-400 font-bold text-[10px] mt-4 uppercase tracking-[0.4em] flex items-center gap-2">
                    <span class="w-1.5 h-1.5 bg-[#10B981] rounded-full animate-ping"></span>
                    Logistique & Flotte opérationnelle
                </p>
            </div>
            <button @click="openModal = true"
                class="bg-[#059669] text-white px-10 py-5 rounded-[1.8rem] font-black text-[11px] uppercase tracking-widest shadow-[0_20px_50px_-15px_rgba(5,150,105,0.3)] hover:bg-[#064E3B] hover:-translate-y-1 transition-all duration-300 flex items-center gap-4 cursor-pointer">
                <span class="text-xl leading-none">＋</span> Engager un coursier
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($livreurs as $livreur)
            <div class="group bg-white rounded-[3rem] overflow-hidden shadow-[0_10px_40px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_40px_80px_-20px_rgba(0,0,0,0.15)] transition-all duration-500 border border-gray-50 flex flex-col relative">

                <div class="absolute top-6 left-6 z-10">
                    <span class="px-4 py-1.5 bg-white/90 backdrop-blur-md text-[#064E3B] text-[9px] font-black rounded-full shadow-sm border border-gray-50 uppercase">
                        {{ $livreur->matricule ?? 'ID-PENDING'}}
                    </span>
                </div>

                <div class="h-28 bg-gradient-to-br from-[#064E3B] to-[#059669] relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                </div>

                <div class="px-8 pb-8 flex-1 flex flex-col items-center text-center -mt-12 relative">
                    <div class="w-24 h-24 bg-white p-2 rounded-[2rem] shadow-xl mb-4 transition-transform group-hover:scale-105 duration-500">
                        <div class="w-full h-full bg-[#F0FDF4] rounded-[1.5rem] flex items-center justify-center border-2 border-dashed border-[#059669]/20">
                            <span class="text-[#064E3B] text-4xl font-black italic">{{ substr($livreur->user->name ?? 'L', 0, 1) }}</span>
                        </div>
                    </div>

                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-tight">{{ $livreur->user->name ?? 'Anonyme' }}</h3>

                    <div class="mt-2 px-4 py-1.5 bg-green-50 rounded-full border border-green-100/50">
                        <p class="text-[10px] font-black text-[#059669] uppercase tracking-widest">{{ $livreur->vehicule ?? 'Standard' }}</p>
                    </div>

                    <div class="mt-8 w-full space-y-3">
                        <div class="flex items-center justify-between p-4 bg-[#F8FAFC] rounded-2xl group/item hover:bg-white hover:shadow-sm transition-all border border-transparent hover:border-gray-100">
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Contact</span>
                            <span class="text-xs font-bold text-gray-700">{{ $livreur->telephone }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0 flex flex-col gap-3">
                    <button class="w-full py-4 bg-[#059669] hover:bg-black text-white rounded-[1.5rem] text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-lg shadow-green-900/10 active:scale-95">
                        Assigner Mission
                    </button>

                    <div class="flex justify-center gap-4 mt-2">
                        <button @click="initEdit({
                            id: '{{ $livreur->id }}',
                            name: '{{ addslashes($livreur->user->name) }}',
                            email: '{{ $livreur->user->email }}',
                            telephone: '{{ $livreur->telephone }}',
                            matricule: '{{ $livreur->matricule }}',
                            vehicule: '{{ $livreur->vehicule }}'
                        })" class="text-[9px] font-black text-gray-400 uppercase hover:text-[#064E3B] transition-colors tracking-widest">Éditer</button>

                        <form action="{{ route('pharmacie.livreurs.destroy', $livreur->id) }}" method="POST" onsubmit="return confirm('Révoquer l\'accès ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-[9px] font-black text-red-300 hover:text-red-500 uppercase transition-colors tracking-widest">Révoquer</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-32 bg-white rounded-[3rem] border-4 border-dashed border-gray-50 flex flex-col items-center">
                <p class="font-black text-gray-300 uppercase tracking-[0.5em] text-[11px]">Aucun coursier dans la flotte</p>
            </div>
            @endforelse
        </div>

        <div x-show="openModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6" x-cloak>
            <div @click="openModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" class="absolute inset-0 bg-[#064E3B]/60 backdrop-blur-xl"></div>

            <div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-10"
                class="bg-white w-full max-w-xl rounded-[4rem] overflow-hidden relative shadow-[0_50px_100px_-20px_rgba(0,0,0,0.4)] border border-white/20">

                <div class="bg-[#064E3B] p-12 text-center relative">
                    <h3 class="font-black text-white text-3xl uppercase italic mb-2 tracking-tighter relative z-10">Nouvelle Recrue</h3>
                    <div class="h-1.5 w-12 bg-[#10B981] mx-auto rounded-full mt-4"></div>
                </div>

                <form action="{{ route('pharmacie.livreurs.store') }}" method="POST" class="p-12 space-y-5">
                    @csrf
                    <div class="grid grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Nom</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-[#F8FAFC] border-none rounded-[1.5rem] text-[11px] font-bold p-5 focus:ring-2 focus:ring-[#059669] transition-all" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Matricule</label>
                            <input type="text" name="matricule" value="{{ old('matricule') }}" placeholder="ML-2026" class="w-full bg-[#F8FAFC] border-none rounded-[1.5rem] text-[11px] font-bold p-5 focus:ring-2 focus:ring-[#059669] transition-all" required>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Email ID</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-[#F8FAFC] border-none rounded-[1.5rem] text-[11px] font-bold p-5 focus:ring-2 focus:ring-[#059669] transition-all" required>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Téléphone</label>
                            <input type="text" name="telephone" value="{{ old('telephone') }}" class="w-full bg-[#F8FAFC] border-none rounded-[1.5rem] text-[11px] font-bold p-5 focus:ring-2 focus:ring-[#059669] transition-all" required>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Véhicule</label>
                            <input type="text" name="vehicule" value="{{ old('vehicule') }}" placeholder="Ex: Yamaha 125" class="w-full bg-[#F8FAFC] border-none rounded-[1.5rem] text-[11px] font-bold p-5 focus:ring-2 focus:ring-[#059669] transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Mot de passe provisoire</label>
                        <input type="password" name="password" class="w-full bg-[#F8FAFC] border-none rounded-[1.5rem] text-[11px] font-bold p-5 focus:ring-2 focus:ring-[#059669] transition-all" required>
                    </div>

                    <button type="submit" class="w-full bg-[#064E3B] text-white py-6 rounded-[2rem] font-black uppercase text-[11px] mt-6 shadow-2xl shadow-green-900/20 hover:bg-black transition-all tracking-[0.2em]">
                        Finaliser l'inscription
                    </button>
                </form>
            </div>
        </div>

        <template x-if="showToast">
            <div x-init="setTimeout(() => showToast = false, 5000)"
                class="fixed bottom-12 right-12 z-[110] bg-black/90 backdrop-blur-md text-white px-10 py-6 rounded-[2.5rem] flex items-center gap-6 shadow-2xl border border-white/10"
                x-transition:enter="translate-y-20 opacity-0" x-transition:enter-end="translate-y-0 opacity-100 transition duration-500">
                <div class="h-10 w-10 bg-[#10B981] rounded-full flex items-center justify-center text-black font-black text-lg">✓</div>
                <div>
                    <p class="text-[9px] font-black text-[#10B981] uppercase tracking-[0.3em]">Opération Réussie</p>
                    <p class="text-[12px] font-bold tracking-tight mt-0.5" x-text="showToast"></p>
                </div>
            </div>
        </template>

    </div>
</x-app-layout>
