<x-app-layout>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4 text-green-700">Gestion du Stock</h2>

        <div class="bg-white p-6 rounded-xl shadow-md mb-8">
            <form action="{{ route('pharmacie.stocks.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Médicament</label>
                    <select name="medicament_id" class="w-full rounded-lg border-gray-300">
                        @foreach($medicaments as $medoc)
                            <option value="{{ $medoc->id }}">{{ $medoc->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Quantité</label>
                    <input type="number" name="quantite" class="w-full rounded-lg border-gray-300" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Prix (FCFA)</label>
                    <input type="number" name="prix" class="w-full rounded-lg border-gray-300" required>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 w-full">Ajouter au stock</button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-4 border-b">Médicament</th>
                        <th class="p-4 border-b">Quantité</th>
                        <th class="p-4 border-b">Prix</th>
                        <th class="p-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stocks as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 border-b font-semibold">{{ $item->medicament->nom }}</td>
                        <td class="p-4 border-b">
                            <span class="{{ $item->quantite < 5 ? 'text-red-600 font-bold' : '' }}">
                                {{ $item->quantite }}
                            </span>
                        </td>
                        <td class="p-4 border-b">{{ number_format($item->prix, 0, ',', ' ') }} FCFA</td>
                        <td class="p-4 border-b">
                            <form action="{{ route('pharmacie.stocks.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Supprimer ce produit du stock ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
