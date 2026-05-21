<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
* { box-sizing: border-box; }
.ph-root {
    font-family: 'DM Sans', sans-serif;
    background: #F4F6F9;
    min-height: 100vh;
    padding: 40px 48px;
}

/* HEADER */
.ph-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 36px;
}
.ph-header-left h2 {
    font-size: 1.65rem;
    font-weight: 700;
    color: #0A1628;
    letter-spacing: -0.5px;
    margin: 0 0 4px;
}
.ph-header-left p {
    font-size: 0.8rem;
    color: #94A3B8;
    font-weight: 500;
    margin: 0;
}
.ph-date {
    font-size: 0.75rem;
    color: #94A3B8;
    font-weight: 600;
    background: white;
    border: 1px solid #E8EDF5;
    padding: 8px 16px;
    border-radius: 20px;
}

/* STATS */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 28px;
}
.stat-card {
    background: white;
    border-radius: 20px;
    padding: 28px 26px;
    border: 1px solid #EEF1F7;
    position: relative;
    overflow: hidden;
    transition: box-shadow 0.2s, transform 0.2s;
}
.stat-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.06); transform: translateY(-2px); }
.stat-card.accent { background: #064E3B; border-color: #064E3B; }
.stat-card::before {
    content: '';
    position: absolute;
    top: -30px; right: -30px;
    width: 90px; height: 90px;
    border-radius: 50%;
    background: rgba(0,0,0,0.03);
}
.stat-card.accent::before { background: rgba(255,255,255,0.05); }
.stat-icon {
    width: 38px; height: 38px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    margin-bottom: 18px;
}
.stat-label { font-size: 0.7rem; font-weight: 600; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px; }
.stat-card.accent .stat-label { color: rgba(255,255,255,0.5); }
.stat-value { font-size: 1.9rem; font-weight: 700; color: #0A1628; letter-spacing: -1px; line-height: 1; margin-bottom: 8px; font-family: 'DM Mono', monospace; }
.stat-card.accent .stat-value { color: white; }
.stat-sub { font-size: 0.7rem; color: #94A3B8; font-weight: 500; }
.stat-card.accent .stat-sub { color: rgba(255,255,255,0.4); }

/* CARD */
.card {
    background: white;
    border-radius: 22px;
    border: 1px solid #EEF1F7;
    overflow: hidden;
}
.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 24px 28px;
    border-bottom: 1px solid #F1F5F9;
}
.card-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: #0A1628;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card-title-dot { width: 8px; height: 8px; border-radius: 50%; background: #059669; }
.card-badge {
    font-size: 0.65rem; font-weight: 700; color: #94A3B8;
    background: #F4F6F9; padding: 5px 12px; border-radius: 20px;
    text-transform: uppercase; letter-spacing: 0.05em;
}
.add-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: #064E3B; color: white;
    padding: 10px 20px; border-radius: 14px; border: none; cursor: pointer;
    font-size: 0.7rem; font-weight: 700; font-family: 'DM Sans', sans-serif;
    text-transform: uppercase; letter-spacing: 0.08em;
    transition: all 0.2s;
}
.add-btn:hover { background: #059669; box-shadow: 0 6px 20px rgba(5,150,105,0.25); transform: translateY(-1px); }

/* TABLE */
.dash-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }
.dash-table thead tr { background: #FAFBFD; }
.dash-table th {
    padding: 13px 20px; font-size: 0.65rem; font-weight: 700;
    color: #B0BAC9; text-transform: uppercase; letter-spacing: 0.1em;
    text-align: left; border-bottom: 1px solid #F1F5F9;
}
.dash-table th.right { text-align: right; }
.dash-table td {
    padding: 16px 20px; color: #374151; font-weight: 500;
    border-bottom: 1px solid #F8FAFC; vertical-align: middle;
}
.dash-table tr:last-child td { border-bottom: none; }
.dash-table tr:hover td { background: #FAFBFF; }

.ph-avatar {
    width: 42px; height: 42px; border-radius: 12px;
    background: #ECFDF5; border: 1px solid #D1FAE5;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.75rem; font-weight: 700; color: #059669;
    font-family: 'DM Mono', monospace; overflow: hidden; flex-shrink: 0;
}
.ph-name { font-weight: 600; color: #0A1628; font-size: 0.82rem; }
.ph-id { font-size: 0.65rem; color: #94A3B8; font-family: 'DM Mono', monospace; margin-top: 2px; }
.ville-badge {
    display: inline-flex; align-items: center; gap: 4px;
    background: #ECFDF5; color: #059669; border: 1px solid #D1FAE5;
    border-radius: 8px; padding: 3px 10px;
    font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em;
}
.contact-main { font-weight: 600; color: #0A1628; font-size: 0.8rem; }
.contact-sub { font-size: 0.7rem; color: #94A3B8; margin-top: 2px; }
.adresse-sub { font-size: 0.7rem; color: #94A3B8; margin-top: 4px; }

.action-wrap { display: flex; justify-content: flex-end; gap: 6px; opacity: 0; transition: opacity 0.2s; }
.dash-table tr:hover .action-wrap { opacity: 1; }
.btn-icon {
    width: 32px; height: 32px; border-radius: 9px;
    border: 1.5px solid #EEF1F7; background: transparent;
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all 0.15s; color: #94A3B8;
}
.btn-icon:hover.edit { background: #ECFDF5; border-color: #D1FAE5; color: #059669; }
.btn-icon:hover.del  { background: #FEF2F2; border-color: #FECACA; color: #EF4444; }

.empty-row td {
    padding: 60px 20px; text-align: center;
    color: #C8D0DC; font-size: 0.7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.15em;
}

/* MODAL */
.modal-overlay {
    position: fixed; inset: 0; z-index: 50;
    display: flex; align-items: center; justify-content: center;
    padding: 16px; background: rgba(10,22,40,0.4); backdrop-filter: blur(6px);
}
.modal-box {
    background: white; width: 100%; max-width: 480px;
    border-radius: 24px; overflow: hidden;
    box-shadow: 0 24px 64px rgba(0,0,0,0.15);
    border: 1px solid #EEF1F7;
}
.modal-head {
    padding: 22px 28px; border-bottom: 1px solid #F1F5F9;
    background: #FAFBFD;
    display: flex; align-items: center; justify-content: space-between;
}
.modal-title { font-size: 0.75rem; font-weight: 700; color: #0A1628; text-transform: uppercase; letter-spacing: 0.1em; }
.modal-close {
    width: 30px; height: 30px; border-radius: 8px; border: none;
    background: transparent; color: #94A3B8; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.15s;
}
.modal-close:hover { background: #F4F6F9; color: #374151; }
.modal-body { padding: 28px; display: flex; flex-direction: column; gap: 16px; }
.form-group label {
    display: block; font-size: 0.65rem; font-weight: 700;
    color: #B0BAC9; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 7px;
}
.form-control {
    width: 100%; background: #F8FAFC;
    border: 1.5px solid #EEF1F7; border-radius: 12px;
    padding: 11px 14px; font-size: 0.8rem;
    font-family: 'DM Sans', sans-serif; color: #0A1628;
    transition: all 0.15s; outline: none; appearance: none;
}
.form-control:focus { border-color: #059669; background: #fff; box-shadow: 0 0 0 4px rgba(5,150,105,0.08); }
.form-control::placeholder { color: #C8D0DC; }
.modal-footer {
    padding: 16px 28px; border-top: 1px solid #F1F5F9;
    display: flex; justify-content: flex-end; align-items: center; gap: 8px;
}
.btn-cancel {
    padding: 10px 18px; background: transparent; border: none; cursor: pointer;
    font-size: 0.7rem; font-weight: 700; color: #94A3B8;
    font-family: 'DM Sans', sans-serif;
    text-transform: uppercase; letter-spacing: 0.08em; transition: color 0.15s;
}
.btn-cancel:hover { color: #374151; }
.btn-submit {
    padding: 10px 22px; border-radius: 12px; border: none; cursor: pointer;
    font-size: 0.7rem; font-weight: 700; font-family: 'DM Sans', sans-serif;
    text-transform: uppercase; letter-spacing: 0.08em; transition: all 0.15s;
}
.btn-green { background: #064E3B; color: white; }
.btn-green:hover { background: #059669; box-shadow: 0 4px 14px rgba(5,150,105,0.25); }
.btn-dark  { background: #0A1628; color: white; }
.btn-dark:hover  { background: #1E293B; }

/* TOAST */
.toast {
    position: fixed; bottom: 28px; right: 28px; z-index: 100;
    background: #064E3B; color: white;
    padding: 14px 22px; border-radius: 14px;
    display: flex; align-items: center; gap: 12px;
    font-family: 'DM Sans', sans-serif; font-size: 0.8rem; font-weight: 500;
    box-shadow: 0 8px 32px rgba(5,150,105,0.2);
    border: 1px solid rgba(255,255,255,0.1);
}
.toast-dot { width: 8px; height: 8px; background: #6EE7B7; border-radius: 50%; flex-shrink: 0; }

.col-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.divider { border: none; border-top: 1px solid #F1F5F9; margin: 0; }

@media (max-width: 1024px) { .stats-grid { grid-template-columns: 1fr 1fr; } .ph-root { padding: 24px; } }
@media (max-width: 640px)  { .stats-grid { grid-template-columns: 1fr; } }
</style>

<div class="ph-root" x-data="{
    openModal: {{ $errors->any() && !session('edit_id') ? 'true' : 'false' }},
    editModal: false,
    showToast: '{{ session('success') }}',
    currentPh: { id: '', nom: '', email: '', tel: '', ville: '', quartier: '' },
    initEdit(ph) { this.currentPh = ph; this.editModal = true; }
}">

    {{-- HEADER --}}
    <div class="ph-header">
        <div class="ph-header-left">
            <h2>Réseau Pharmacies</h2>
            <p>Gestion des établissements partenaires</p>
        </div>
        <div style="display:flex;align-items:center;gap:12px;">
            <div class="ph-date">{{ now()->translatedFormat('l d F Y') }}</div>
            <button @click="openModal = true" class="add-btn">
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Ajouter un établissement
            </button>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#ECFDF5">🏥</div>
            <div class="stat-label">Établissements</div>
            <div class="stat-value">{{ $pharmacies->count() }}</div>
            <div class="stat-sub">Partenaires enregistrés</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#EFF6FF">🗺️</div>
            <div class="stat-label">Villes couvertes</div>
            <div class="stat-value">{{ $pharmacies->pluck('ville')->unique()->count() }}</div>
            <div class="stat-sub">Zones géographiques</div>
        </div>
        <div class="stat-card accent">
            <div class="stat-icon" style="background:rgba(255,255,255,0.1)">📡</div>
            <div class="stat-label">Statut réseau</div>
            <div class="stat-value" style="font-size:1.2rem;letter-spacing:0">Opérationnel</div>
            <div class="stat-sub">Plateforme Hygie+</div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="card-title-dot"></div>
                Liste des établissements
            </div>
            <span class="card-badge">{{ $pharmacies->count() }} partenaires</span>
        </div>

        <div style="overflow-x:auto">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Établissement</th>
                        <th>Contact</th>
                        <th>Localisation</th>
                        <th class="right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pharmacies as $ph)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:14px;">
                                <div class="ph-avatar">
                                    @if($ph->image)
                                        <img src="{{ asset('storage/'.$ph->image) }}" style="width:100%;height:100%;object-fit:cover;">
                                    @else
                                        {{ strtoupper(substr($ph->nom_pharmacie, 0, 2)) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="ph-name">{{ $ph->nom_pharmacie }}</div>
                                    <div class="ph-id">#{{ str_pad($ph->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="contact-main">{{ $ph->telephone }}</div>
                            <div class="contact-sub">{{ $ph->user->email ?? '—' }}</div>
                        </td>
                        <td>
                            <span class="ville-badge">📍 {{ $ph->ville }}</span>
                            <div class="adresse-sub">{{ $ph->adresse }}</div>
                        </td>
                        <td style="text-align:right">
                            <div class="action-wrap">
                                <button class="btn-icon edit" @click="initEdit({
                                    id: '{{ $ph->id }}',
                                    nom: '{{ addslashes($ph->nom_pharmacie) }}',
                                    email: '{{ $ph->user->email ?? '' }}',
                                    tel: '{{ $ph->telephone }}',
                                    ville: '{{ $ph->ville }}',
                                    quartier: '{{ addslashes($ph->adresse) }}'
                                })">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.pharmacies.destroy', $ph->id) }}" method="POST"
                                      onsubmit="return confirm('Supprimer cet établissement ?')" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon del">
                                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row"><td colspan="4">Aucun établissement enregistré</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL AJOUT --}}
    <div x-show="openModal" class="modal-overlay" x-cloak>
        <div @click.self="openModal = false" style="position:absolute;inset:0;"></div>
        <div class="modal-box"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="modal-head">
                <span class="modal-title">Nouveau partenaire</span>
                <button @click="openModal = false" class="modal-close">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <form action="{{ route('admin.pharmacies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nom de l'établissement</label>
                        <input type="text" name="nom_pharmacie" class="form-control" placeholder="Ex : Pharmacie Centrale" required style="text-transform:uppercase;">
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@pharmacie.bj" required>
                        </div>
                        <div class="form-group">
                            <label>Téléphone</label>
                            <input type="text" name="telephone" class="form-control" placeholder="01 XX XX XX" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mot de passe</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label>Ville</label>
                            <select name="ville" class="form-control" required>
                                <option value="" disabled selected>Choisir…</option>
                                @foreach($villes ?? [] as $ville)
                                    <option value="{{ $ville }}">{{ $ville }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quartier / Adresse</label>
                            <input type="text" name="adresse" class="form-control" placeholder="Quartier…">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Logo (optionnel)</label>
                        <input type="file" name="image" class="form-control" accept="image/*" style="padding:8px 12px;cursor:pointer;font-size:0.75rem;">
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

    {{-- MODAL AJOUT --}}
<div x-show="openModal" class="modal-overlay" x-cloak @click="openModal = false">
    <div class="modal-box"
         @click.stop
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        <div class="modal-head">
            <span class="modal-title">Nouveau partenaire</span>
            <button @click="openModal = false" class="modal-close">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('admin.pharmacies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nom de l'établissement</label>
                    <input type="text" name="nom_pharmacie" class="form-control"
                           placeholder="Ex : Pharmacie Centrale" required style="text-transform:uppercase;">
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                               placeholder="email@pharmacie.bj" required>
                    </div>
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="text" name="telephone" class="form-control"
                               placeholder="01 XX XX XX" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="••••••••" required>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label>Ville</label>
                        <select name="ville" class="form-control" required>
                            <option value="" disabled selected>Choisir…</option>
                            @foreach($villes ?? [] as $ville)
                                <option value="{{ $ville }}">{{ $ville }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Quartier / Adresse</label>
                        <input type="text" name="adresse" class="form-control" placeholder="Quartier…">
                    </div>
                </div>
                <div class="form-group">
                    <label>Logo (optionnel)</label>
                    <input type="file" name="image" class="form-control" accept="image/*"
                           style="padding:8px 12px;cursor:pointer;font-size:0.75rem;">
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
<div x-show="editModal" class="modal-overlay" x-cloak @click="editModal = false">
    <div class="modal-box"
         @click.stop
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        <div class="modal-head">
            <span class="modal-title">Modifier la fiche</span>
            <button @click="editModal = false" class="modal-close">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form :action="'{{ url('admin/pharmacies') }}/' + currentPh.id" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nom de l'établissement</label>
                    <input type="text" name="nom_pharmacie" x-model="currentPh.nom" class="form-control"
                           required style="text-transform:uppercase;">
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" x-model="currentPh.email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="text" name="telephone" x-model="currentPh.tel" class="form-control" required>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label>Ville</label>
                        <select name="ville" x-model="currentPh.ville" class="form-control" required>
                            @foreach($villes ?? [] as $ville)
                                <option value="{{ $ville }}">{{ $ville }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Quartier / Adresse</label>
                        <input type="text" name="adresse" x-model="currentPh.quartier" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Changer le logo (optionnel)</label>
                    <input type="file" name="image" class="form-control" accept="image/*"
                           style="padding:8px 12px;cursor:pointer;font-size:0.75rem;">
                </div>
            </div>
            <hr class="divider">
            <div class="modal-footer">
                <button type="button" @click="editModal = false" class="btn-cancel">Annuler</button>
                <button type="submit" class="btn-submit btn-dark">Sauvegarder</button>
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
