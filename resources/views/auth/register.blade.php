<x-guest-layout>
    @php
        $role = request()->query('role');
    @endphp

    @if($role)
        <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-center">
            <span class="text-xl">{{ $role === 'pharmacie' ? '🏥' : '🚴' }}</span>
            <p class="text-xs font-bold text-green-800 uppercase tracking-wide">
                Inscription {{ ucfirst($role) }}
            </p>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="hidden" name="role" value="{{ $role ?? 'admin' }}">

        {{-- CODE --}}
        <div class="mb-4">
            <x-input-label for="custom_code" :value="__('Matricule / Code Identifiant Unique')" />
            <x-text-input id="custom_code" class="block mt-1 w-full border-green-500 font-bold uppercase"
                type="text" name="custom_code"
                placeholder="{{ $role === 'pharmacie' ? 'Ex: PHARMA000' : 'Ex: LIV111' }}" required />
            <x-input-error :messages="$errors->get('custom_code')" class="mt-1" />
        </div>

        {{-- NOM PRENOM --}}
        <div class="flex gap-4 mb-3">
            <div class="w-1/2">
                <x-input-label for="name" :value="__('Nom')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required />
            </div>
            <div class="w-1/2">
                <x-input-label for="surname" :value="__('Prénom')" />
                <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" required />
            </div>
        </div>

        {{-- TEL EMAIL --}}
        <div class="flex gap-4 mb-3">
            <div class="w-1/2">
                <x-input-label for="telephone" :value="__('Téléphone')" />
                <x-text-input id="telephone" class="block mt-1 w-full" type="text" name="telephone" placeholder="+229..." required />
            </div>
            <div class="w-1/2">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required />
            </div>
        </div>

        {{-- PHARMACIE --}}
        @if($role === 'pharmacie')
            <div class="mb-3">
                <x-input-label for="nom_pharmacie" :value="__('Nom de la Pharmacie')" />
                <x-text-input id="nom_pharmacie" class="block mt-1 w-full" type="text" name="nom_pharmacie" required />
            </div>

            <div class="flex gap-4 mb-3">
                <div class="w-1/2">
                    <x-input-label for="ville" :value="__('Ville')" />
                    <select name="ville" id="ville" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-green-500">
                        <option value="">Choisir une ville</option>
                        <option value="Cotonou">Cotonou</option>
                        <option value="Abomey-Calavi">Abomey-Calavi</option>
                        <option value="Porto-Novo">Porto-Novo</option>
                        <option value="Parakou">Parakou</option>
                    </select>
                </div>
                <div class="w-1/2">
                    <x-input-label for="adresse" :value="__('Quartier / Adresse')" />
                    <x-text-input id="adresse" class="block mt-1 w-full" type="text" name="adresse" placeholder="Ex: Fidjrossè" required />
                </div>
            </div>
        @endif

        {{-- LIVREUR --}}
        @if($role === 'livreur')
            <div class="flex gap-4 mb-3">
                <div class="w-1/2">
                    <x-input-label for="vehicule" :value="__('Type de véhicule')" />
                    <select name="vehicule" id="vehicule" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-green-500">
                        <option value="moto">Moto</option>
                        <option value="velo">Vélo</option>
                        <option value="voiture">Voiture</option>
                    </select>
                </div>
                <div class="w-1/2">
                    <x-input-label for="matricule_vehicule" :value="__('N° Immatriculation')" />
                    <x-text-input id="matricule_vehicule" class="block mt-1 w-full"
                        type="text" name="matricule" placeholder="Ex: AB 1234 RB" required />
                </div>
            </div>
        @endif

        {{-- PASSWORD --}}
        <div class="flex gap-4 mb-3">
            <div class="w-1/2">
                <x-input-label for="password" :value="__('Mot de passe')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" required />
            </div>
            <div class="w-1/2">
                <x-input-label for="password_confirmation" :value="__('Confirmation')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" required />
            </div>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-xs text-gray-600 hover:text-green-700" href="{{ route('login') }}">Déjà inscrit ?</a>
            <x-primary-button class="bg-green-600">S'inscrire sur Hygie+</x-primary-button>
        </div>
    </form>
</x-guest-layout>
