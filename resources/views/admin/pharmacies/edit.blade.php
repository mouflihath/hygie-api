<x-layout>
    <x-slot name="title">Modifier la Pharmacie - Admin</x-slot>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    {{-- Header avec dégradé léger pour le côté pro --}}
                    <div class="card-header bg-white py-4 px-4 border-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="fw-bold text-dark mb-0">Modifier la Pharmacie</h3>
                            <p class="text-muted small mb-0">Identifiant : #{{ $pharmacy->id }}</p>
                        </div>
                        <a href="{{ route('admin.pharmacies.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-arrow-left me-2"></i>Retour
                        </a>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('admin.pharmacies.update', $pharmacy->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-5">
                                {{-- Section Informations --}}
                                <div class="col-md-7">
                                    <h5 class="fw-bold mb-4 text-success border-bottom pb-2">Informations Générales</h5>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Nom de l'établissement</label>
                                        <input type="text" name="nom_pharmacie" class="form-control form-control-lg @error('nom_pharmacie') is-invalid @enderror" value="{{ old('nom_pharmacie', $pharmacy->nom_pharmacie) }}" required>
                                        @error('nom_pharmacie') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">Ville</label>
                                            <input type="text" name="ville" class="form-control" value="{{ old('ville', $pharmacy->ville) }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-semibold">Téléphone</label>
                                            <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $pharmacy->telephone) }}" required>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Adresse complète</label>
                                        <textarea name="adresse" class="form-control" rows="3" required>{{ old('adresse', $pharmacy->adresse) }}</textarea>
                                    </div>

                                    {{-- Zone Statut et Vérification --}}
                                    <div class="p-4 rounded-4" style="background-color: #f0f7f4; border: 1px solid #d1e7dd;">
                                        <h6 class="fw-bold text-success mb-3">Certification MediPresto</h6>
                                        <div class="form-check form-switch d-flex align-items-center">
                                            <input class="form-check-input" type="checkbox" name="validee" id="validee" value="1" {{ $pharmacy->validee ? 'checked' : '' }} style="width: 3rem; height: 1.5rem; cursor: pointer;">
                                            <label class="form-check-label ms-3 fw-bold text-dark" for="validee">
                                                <i class="bi bi-patch-check-fill text-primary fs-5 me-1"></i> Compte Vérifié
                                            </label>
                                        </div>
                                        <p class="text-muted small mt-2 mb-0 ms-5">
                                            L'activation de ce badge affiche une icône de confiance bleue sur le profil public de la pharmacie.
                                        </p>
                                    </div>
                                </div>

                                {{-- Section Image --}}
                                <div class="col-md-5">
                                    <h5 class="fw-bold mb-4 text-success border-bottom pb-2">Identité Visuelle</h5>

                                    <div class="card border-dashed bg-light text-center p-3">
                                        <div class="mb-3 position-relative">
                                            @php $imageUrl = $pharmacy->image ? asset('storage/' . $pharmacy->image) : 'https://via.placeholder.com/400x250?text=Aucune+image'; @endphp
                                            <img src="{{ $imageUrl }}" id="preview" class="img-fluid rounded-3 shadow-sm mb-3 w-100 object-fit-cover" style="height: 220px;">

                                            <div class="mt-2 text-start">
                                                <label for="image" class="form-label fw-semibold">Changer l'image</label>
                                                <input type="file" name="image" id="image" class="form-control border-0 bg-white shadow-sm" onchange="previewImage(event)">
                                            </div>
                                        </div>
                                        <div class="text-muted small mt-2">
                                            <i class="bi bi-info-circle me-1"></i> Utilisez une photo de la façade ou de l'intérieur.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 pt-4 border-top d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-light rounded-pill px-4">Réinitialiser</button>
                                <button type="submit" class="btn btn-success rounded-pill px-5 fw-bold shadow-sm py-2">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush

    <style>
        .border-dashed { border: 2px dashed #dee2e6; }
        .object-fit-cover { object-fit: cover; }
        .form-check-input:checked { background-color: #198754; border-color: #198754; }
        .card { border: none; }
        .form-control:focus { border-color: #198754; box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.1); }
    </style>
</x-layout>
