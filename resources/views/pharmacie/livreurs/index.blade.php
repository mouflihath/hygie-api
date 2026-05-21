<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
* { box-sizing: border-box; }
.liv-root {
    font-family: 'DM Sans', sans-serif;
    background: #F4F6F9;
    min-height: 100vh;
    padding: 40px 48px;
}

/* HEADER */
.liv-header { display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:36px; }
.liv-header-left h2 { font-size:1.65rem; font-weight:700; color:#0A1628; letter-spacing:-0.5px; margin:0 0 4px; }
.liv-header-left p  { font-size:0.8rem; color:#94A3B8; font-weight:500; margin:0; display:flex; align-items:center; gap:6px; }
.live-dot { width:7px; height:7px; background:#059669; border-radius:50%; animation:pulse-live 1.8s ease-in-out infinite; display:inline-block; }
@keyframes pulse-live { 0%,100%{box-shadow:0 0 0 0 rgba(5,150,105,0.5);} 50%{box-shadow:0 0 0 6px rgba(5,150,105,0);} }
.liv-date { font-size:0.75rem; color:#94A3B8; font-weight:600; background:white; border:1px solid #E8EDF5; padding:8px 16px; border-radius:20px; }

/* STATS */
.stats-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:28px; }
.stat-card { background:white; border-radius:20px; padding:28px 26px; border:1px solid #EEF1F7; position:relative; overflow:hidden; transition:box-shadow 0.2s,transform 0.2s; }
.stat-card:hover { box-shadow:0 8px 30px rgba(0,0,0,0.06); transform:translateY(-2px); }
.stat-card.accent { background:#064E3B; border-color:#064E3B; }
.stat-card::before { content:''; position:absolute; top:-30px; right:-30px; width:90px; height:90px; border-radius:50%; background:rgba(0,0,0,0.03); }
.stat-card.accent::before { background:rgba(255,255,255,0.05); }
.stat-icon { width:38px; height:38px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1rem; margin-bottom:18px; }
.stat-label { font-size:0.7rem; font-weight:600; color:#94A3B8; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:6px; }
.stat-card.accent .stat-label { color:rgba(255,255,255,0.5); }
.stat-value { font-size:1.9rem; font-weight:700; color:#0A1628; letter-spacing:-1px; line-height:1; margin-bottom:8px; font-family:'DM Mono',monospace; }
.stat-card.accent .stat-value { color:white; }
.stat-sub { font-size:0.7rem; color:#94A3B8; font-weight:500; }
.stat-card.accent .stat-sub { color:rgba(255,255,255,0.4); }

/* ADD BUTTON */
.add-btn {
    display:inline-flex; align-items:center; gap:8px;
    background:#064E3B; color:white; padding:10px 20px;
    border-radius:14px; border:none; cursor:pointer;
    font-size:0.7rem; font-weight:700; font-family:'DM Sans',sans-serif;
    text-transform:uppercase; letter-spacing:0.08em; transition:all 0.2s;
}
.add-btn:hover { background:#059669; box-shadow:0 6px 20px rgba(5,150,105,0.25); transform:translateY(-1px); }

/* GRID LIVREURS */
.livreurs-grid {
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
}

/* LIVREUR CARD */
.livreur-card {
    background:white; border-radius:22px; border:1px solid #EEF1F7;
    overflow:hidden; transition:box-shadow 0.2s,transform 0.2s;
    display:flex; flex-direction:column;
}
.livreur-card:hover { box-shadow:0 12px 40px rgba(0,0,0,0.08); transform:translateY(-3px); }

.livreur-card-banner {
    height:72px;
    background: linear-gradient(135deg, #064E3B 0%, #059669 100%);
    position:relative; overflow:hidden;
}
.livreur-card-banner::after {
    content:''; position:absolute; top:-20px; right:-20px;
    width:80px; height:80px; border-radius:50%; background:rgba(255,255,255,0.08);
}
.livreur-matricule {
    position:absolute; top:12px; left:14px;
    font-family:'DM Mono',monospace; font-size:0.65rem; font-weight:600;
    background:rgba(255,255,255,0.15); color:white;
    padding:4px 10px; border-radius:20px; backdrop-filter:blur(4px);
    border:1px solid rgba(255,255,255,0.2);
}

.livreur-card-body {
    padding:0 20px 20px; flex:1; display:flex; flex-direction:column; align-items:center;
    text-align:center; margin-top:-24px;
}
.livreur-avatar {
    width:48px; height:48px; border-radius:14px;
    background:white; border:3px solid white;
    box-shadow:0 4px 14px rgba(0,0,0,0.1);
    display:flex; align-items:center; justify-content:center;
    font-size:1.1rem; font-weight:700; color:#064E3B;
    font-family:'DM Mono',monospace;
    margin-bottom:12px;
}
.livreur-name { font-weight:700; font-size:0.88rem; color:#0A1628; }
.livreur-vehicule {
    display:inline-block; margin-top:5px;
    background:#ECFDF5; color:#059669; border:1px solid #D1FAE5;
    border-radius:20px; padding:3px 10px;
    font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em;
}
.livreur-contact {
    display:flex; align-items:center; justify-content:space-between;
    width:100%; margin-top:14px;
    background:#F8FAFC; border-radius:10px; padding:10px 14px;
    border:1px solid #EEF1F7;
}
.livreur-contact .lbl { font-size:0.6rem; font-weight:700; color:#B0BAC9; text-transform:uppercase; letter-spacing:0.08em; }
.livreur-contact .val { font-size:0.75rem; font-weight:600; color:#374151; font-family:'DM Mono',monospace; }

.livreur-card-footer { padding:14px 20px 18px; display:flex; flex-direction:column; gap:10px; }
.assign-btn {
    width:100%; padding:10px; border-radius:12px; border:none; cursor:pointer;
    background:#064E3B; color:white;
    font-size:0.68rem; font-weight:700; font-family:'DM Sans',sans-serif;
    text-transform:uppercase; letter-spacing:0.08em; transition:all 0.15s;
}
.assign-btn:hover { background:#059669; box-shadow:0 4px 14px rgba(5,150,105,0.2); }
.livreur-actions { display:flex; justify-content:center; gap:20px; }
.livreur-action-btn {
    font-size:0.65rem; font-weight:700; color:#94A3B8;
    text-transform:uppercase; letter-spacing:0.06em;
    background:none; border:none; cursor:pointer; transition:color 0.15s;
    font-family:'DM Sans',sans-serif;
}
.livreur-action-btn:hover { color:#0A1628; }
.livreur-action-btn.danger:hover { color:#EF4444; }

.empty-card {
    grid-column:1/-1; padding:60px 24px; text-align:center;
    background:white; border-radius:22px; border:1.5px dashed #E2E8F0;
    color:#C8D0DC; font-size:0.7rem; font-weight:700;
    text-transform:uppercase; letter-spacing:0.15em;
}

/* MODAL */
.modal-overlay {
    position:fixed; inset:0; z-index:50;
    display:flex; align-items:center; justify-content:center;
    padding:16px; background:rgba(10,22,40,0.4); backdrop-filter:blur(6px);
}
.modal-box {
    background:white; width:100%; max-width:480px;
    border-radius:24px; overflow:hidden;
    box-shadow:0 24px 64px rgba(0,0,0,0.15); border:1px solid #EEF1F7;
}
.modal-head {
    padding:22px 28px; border-bottom:1px solid #F1F5F9;
    background:#FAFBFD; display:flex; align-items:center; justify-content:space-between;
}
.modal-title { font-size:0.75rem; font-weight:700; color:#0A1628; text-transform:uppercase; letter-spacing:0.1em; }
.modal-close {
    width:30px; height:30px; border-radius:8px; border:none;
    background:transparent; color:#94A3B8; cursor:pointer;
    display:flex; align-items:center; justify-content:center; transition:all 0.15s;
}
.modal-close:hover { background:#F4F6F9; color:#374151; }
.modal-body { padding:28px; display:flex; flex-direction:column; gap:16px; }
.form-group label { display:block; font-size:0.65rem; font-weight:700; color:#B0BAC9; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:7px; }
.form-control {
    width:100%; background:#F8FAFC; border:1.5px solid #EEF1F7; border-radius:12px;
    padding:11px 14px; font-size:0.8rem; font-family:'DM Sans',sans-serif;
    color:#0A1628; transition:all 0.15s; outline:none;
}
.form-control:focus { border-color:#059669; background:#fff; box-shadow:0 0 0 4px rgba(5,150,105,0.08); }
.form-control::placeholder { color:#C8D0DC; }
.modal-footer { padding:16px 28px; border-top:1px solid #F1F5F9; display:flex; justify-content:flex-end; align-items:center; gap:8px; }
.btn-cancel { padding:10px 18px; background:transparent; border:none; cursor:pointer; font-size:0.7rem; font-weight:700; color:#94A3B8; font-family:'DM Sans',sans-serif; text-transform:uppercase; letter-spacing:0.08em; transition:color 0.15s; }
.btn-cancel:hover { color:#374151; }
.btn-submit { padding:10px 22px; border-radius:12px; border:none; cursor:pointer; font-size:0.7rem; font-weight:700; font-family:'DM Sans',sans-serif; text-transform:uppercase; letter-spacing:0.08em; transition:all 0.15s; }
.btn-green { background:#064E3B; color:white; }
.btn-green:hover { background:#059669; box-shadow:0 4px 14px rgba(5,150,105,0.25); }
.col-2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.divider { border:none; border-top:1px solid #F1F5F9; margin:0; }

/* TOAST */
.toast {
    position:fixed; bottom:28px; right:28px; z-index:100;
    background:#064E3B; color:white; padding:14px 22px; border-radius:14px;
    display:flex; align-items:center; gap:12px;
    font-family:'DM Sans',sans-serif; font-size:0.8rem; font-weight:500;
    box-shadow:0 8px 32px rgba(5,150,105,0.2); border:1px solid rgba(255,255,255,0.1);
}
.toast-dot { width:8px; height:8px; background:#6EE7B7; border-radius:50%; flex-shrink:0; }

@media (max-width:1200px) { .livreurs-grid { grid-template-columns:repeat(3,1fr); } }
@media (max-width:900px)  { .livreurs-grid { grid-template-columns:repeat(2,1fr); } .stats-grid { grid-template-columns:repeat(2,1fr); } .liv-root { padding:24px; } }
@media (max-width:640px)  { .livreurs-grid { grid-template-columns:1fr; } .stats-grid { grid-template-columns:1fr; } }
</style>

<div class="liv-root" x-data="{
    openModal: {{ $errors->any() && !session('edit_id') ? 'true' : 'false' }},
    editModal: {{ session('edit_id') ? 'true' : 'false' }},
    showToast: '{{ session('success') }}',
    currentLivreur: {
        id: '{{ old('edit_id', session('edit_id')) }}',
        name: '{{ old('name') }}',
        email: '{{ old('email') }}',
        telephone: '{{ old('telephone') }}',
        matricule: '{{ old('matricule') }}',
        vehicule: '{{ old('vehicule') }}'
    },
    initEdit(l) { this.currentLivreur = l; this.editModal = true; }
}">

    {{-- HEADER --}}
    <div class="liv-header">
        <div class="liv-header-left">
            <h2>Gestion Livreurs</h2>
            <p>
                <span class="live-dot"></span>
                Logistique &amp; Flotte opérationnelle
            </p>
        </div>
        <div style="display:flex;align-items:center;gap:12px;">
            <div class="liv-date">{{ now()->translatedFormat('l d F Y') }}</div>
            <button @click="openModal = true" class="add-btn">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Engager un coursier
            </button>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#ECFDF5">🛵</div>
            <div class="stat-label">Coursiers actifs</div>
            <div class="stat-value">{{ $livreurs->count() }}</div>
            <div class="stat-sub">Dans la flotte</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#EFF6FF">🚗</div>
            <div class="stat-label">Types de véhicule</div>
            <div class="stat-value">{{ $livreurs->pluck('vehicule')->filter()->unique()->count() }}</div>
            <div class="stat-sub">Véhicules distincts</div>
        </div>
        <div class="stat-card accent">
            <div class="stat-icon" style="background:rgba(255,255,255,0.1)">📡</div>
            <div class="stat-label">Statut flotte</div>
            <div class="stat-value" style="font-size:1.2rem;letter-spacing:0">Opérationnelle</div>
            <div class="stat-sub">Plateforme Hygie+</div>
        </div>
    </div>

    {{-- GRID --}}
    <div class="livreurs-grid">
        @forelse($livreurs as $livreur)
        <div class="livreur-card">
            <div class="livreur-card-banner">
                <span class="livreur-matricule">{{ $livreur->matricule ?? 'ID-PENDING' }}</span>
            </div>
            <div class="livreur-card-body">
                <div class="livreur-avatar">
                    {{ strtoupper(substr($livreur->user->name ?? 'L', 0, 1)) }}
                </div>
                <div class="livreur-name">{{ $livreur->user->name ?? 'Anonyme' }}</div>
                <span class="livreur-vehicule">🚗 {{ $livreur->vehicule ?? 'Standard' }}</span>
                <div class="livreur-contact">
                    <span class="lbl">Contact</span>
                    <span class="val">{{ $livreur->telephone }}</span>
                </div>
            </div>
            <div class="livreur-card-footer">
                <button class="assign-btn">Assigner une mission</button>
                <div class="livreur-actions">
                    <button class="livreur-action-btn" @click="initEdit({
                        id: '{{ $livreur->id }}',
                        name: '{{ addslashes($livreur->user->name) }}',
                        email: '{{ $livreur->user->email }}',
                        telephone: '{{ $livreur->telephone }}',
                        matricule: '{{ $livreur->matricule }}',
                        vehicule: '{{ $livreur->vehicule }}'
                    })">Éditer</button>
                    <form action="{{ route('pharmacie.livreurs.destroy', $livreur->id) }}" method="POST"
                          onsubmit="return confirm('Révoquer l\'accès ?')" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="livreur-action-btn danger">Révoquer</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-card">Aucun coursier dans la flotte</div>
        @endforelse
    </div>

    {{-- MODAL AJOUT --}}
    <div x-show="openModal" class="modal-overlay" x-cloak>
        <div @click.self="openModal = false" style="position:absolute;inset:0;"></div>
        <div class="modal-box"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="modal-head">
                <span class="modal-title">Nouvelle recrue</span>
                <button @click="openModal = false" class="modal-close">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form action="{{ route('pharmacie.livreurs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="col-2">
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Matricule</label>
                            <input type="text" name="matricule" value="{{ old('matricule') }}" placeholder="ML-2026" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Téléphone</label>
                            <input type="text" name="telephone" value="{{ old('telephone') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Véhicule</label>
                            <input type="text" name="vehicule" value="{{ old('vehicule') }}" placeholder="Ex: Yamaha 125" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mot de passe provisoire</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <hr class="divider">
                <div class="modal-footer">
                    <button type="button" @click="openModal = false" class="btn-cancel">Annuler</button>
                    <button type="submit" class="btn-submit btn-green">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL ÉDITION --}}
    <div x-show="editModal" class="modal-overlay" x-cloak>
        <div @click.self="editModal = false" style="position:absolute;inset:0;"></div>
        <div class="modal-box"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="modal-head">
                <span class="modal-title">Modifier le coursier</span>
                <button @click="editModal = false" class="modal-close">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form :action="'{{ url('pharmacie/livreurs') }}/' + currentLivreur.id" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="col-2">
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="name" x-model="currentLivreur.name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Matricule</label>
                            <input type="text" name="matricule" x-model="currentLivreur.matricule" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" x-model="currentLivreur.email" class="form-control" required>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Téléphone</label>
                            <input type="text" name="telephone" x-model="currentLivreur.telephone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Véhicule</label>
                            <input type="text" name="vehicule" x-model="currentLivreur.vehicule" class="form-control">
                        </div>
                    </div>
                </div>
                <hr class="divider">
                <div class="modal-footer">
                    <button type="button" @click="editModal = false" class="btn-cancel">Annuler</button>
                    <button type="submit" class="btn-submit btn-green">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>

    {{-- TOAST --}}
    <template x-if="showToast">
        <div x-init="setTimeout(() => showToast = false, 4000)" class="toast" x-transition>
            <span class="toast-dot"></span>
            <span x-text="showToast"></span>
        </div>
    </template>

</div>
</x-app-layout>
