<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
* { box-sizing: border-box; }
.ph-dash-root {
    font-family: 'DM Sans', sans-serif;
    background: #F4F6F9;
    min-height: 100vh;
    padding: 40px 48px;
}
.dash-header {
    display: flex; align-items: flex-end; justify-content: space-between;
    margin-bottom: 36px;
}
.dash-header-left h2 {
    font-size: 1.65rem; font-weight: 700; color: #0A1628;
    letter-spacing: -0.5px; margin: 0 0 4px;
}
.dash-header-left p { font-size: 0.8rem; color: #94A3B8; font-weight: 500; margin: 0; }
.dash-date {
    font-size: 0.75rem; color: #94A3B8; font-weight: 600;
    background: white; border: 1px solid #E8EDF5;
    padding: 8px 16px; border-radius: 20px;
}
.header-meta { text-align: right; }
.header-meta .meta-label {
    font-size: 0.65rem; font-weight: 700; color: #B0BAC9;
    text-transform: uppercase; letter-spacing: 0.1em;
}
.header-meta .meta-val {
    font-size: 0.78rem; font-weight: 600; color: #374151; margin-top: 3px;
}
.stats-grid {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 20px; margin-bottom: 28px;
}
.stat-card {
    background: white; border-radius: 20px; padding: 28px 26px;
    border: 1px solid #EEF1F7; position: relative; overflow: hidden;
    transition: box-shadow 0.2s, transform 0.2s;
}
.stat-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.06); transform: translateY(-2px); }
.stat-card.accent { background: #064E3B; border-color: #064E3B; }
.stat-card::before {
    content: ''; position: absolute; top: -30px; right: -30px;
    width: 90px; height: 90px; border-radius: 50%; background: rgba(0,0,0,0.03);
}
.stat-card.accent::before { background: rgba(255,255,255,0.05); }
.stat-icon {
    width: 38px; height: 38px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; margin-bottom: 18px;
}
.stat-label { font-size: 0.7rem; font-weight: 600; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px; }
.stat-card.accent .stat-label { color: rgba(255,255,255,0.5); }
.stat-value { font-size: 1.9rem; font-weight: 700; color: #0A1628; letter-spacing: -1px; line-height: 1; margin-bottom: 8px; font-family: 'DM Mono', monospace; }
.stat-card.accent .stat-value { color: white; }
.stat-sub { font-size: 0.7rem; color: #94A3B8; font-weight: 500; }
.stat-card.accent .stat-sub { color: rgba(255,255,255,0.4); }
.stat-sub b { color: #3B82F6; }
.stat-card.accent .stat-sub b { color: #6EE7B7; }
.card {
    background: white; border-radius: 22px;
    border: 1px solid #EEF1F7; overflow: hidden;
}
.card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 24px 28px; border-bottom: 1px solid #F1F5F9;
}
.card-title {
    font-size: 0.85rem; font-weight: 700; color: #0A1628;
    display: flex; align-items: center; gap: 8px;
}
.card-title-dot { width: 8px; height: 8px; border-radius: 50%; background: #059669; }
.live-badge {
    display: flex; align-items: center; gap: 6px;
    font-size: 0.65rem; font-weight: 700; color: #059669;
    text-transform: uppercase; letter-spacing: 0.08em;
}
.live-dot {
    width: 7px; height: 7px; background: #059669; border-radius: 50%;
    animation: pulse-live 1.8s ease-in-out infinite;
}
@keyframes pulse-live {
    0%,100% { box-shadow: 0 0 0 0 rgba(5,150,105,0.5); }
    50%      { box-shadow: 0 0 0 6px rgba(5,150,105,0); }
}
.card-badge {
    font-size: 0.65rem; font-weight: 700; color: #94A3B8;
    background: #F4F6F9; padding: 5px 12px; border-radius: 20px;
    text-transform: uppercase; letter-spacing: 0.05em;
}
.dash-table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }
.dash-table thead tr { background: #FAFBFD; }
.dash-table th {
    padding: 13px 20px; font-size: 0.65rem; font-weight: 700;
    color: #B0BAC9; text-transform: uppercase; letter-spacing: 0.1em;
    text-align: left; border-bottom: 1px solid #F1F5F9;
}
.dash-table th.right { text-align: right; }
.dash-table th.center { text-align: center; }
.dash-table td {
    padding: 14px 20px; color: #374151; font-weight: 500;
    border-bottom: 1px solid #F8FAFC; vertical-align: middle;
}
.dash-table tr:last-child td { border-bottom: none; }
.dash-table tr:hover td { background: #FAFBFF; }
.ref-badge {
    font-family: 'DM Mono', monospace; font-size: 0.7rem;
    background: #F4F6F9; color: #64748B;
    padding: 4px 9px; border-radius: 7px; font-weight: 500;
}
.date-cell { font-size: 0.68rem; color: #94A3B8; margin-top: 4px; }
.patient-name { font-weight: 600; color: #0A1628; }
.patient-tel  { font-size: 0.7rem; color: #94A3B8; margin-top: 2px; }
.amount-main { font-weight: 700; color: #0A1628; font-family: 'DM Mono', monospace; font-size: 0.78rem; }
.mode-badge {
    display: inline-flex; align-items: center;
    padding: 4px 10px; border-radius: 20px;
    font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
}
.mode-livraison { background: #EFF6FF; color: #3B82F6; }
.mode-retrait   { background: #F3E8FF; color: #8B5CF6; }
.statut-select {
    font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.05em; border-radius: 10px; padding: 6px 12px;
    border: 1.5px solid; cursor: pointer; outline: none;
    font-family: 'DM Sans', sans-serif; transition: all 0.15s; appearance: none;
}
.sel-en_attente { background: #FFFBEB; color: #D97706; border-color: #FDE68A; }
.sel-validee    { background: #ECFDF5; color: #059669; border-color: #A7F3D0; }
.empty-row td {
    padding: 60px 20px; text-align: center;
    color: #C8D0DC; font-size: 0.7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.15em;
}
.toast {
    position: fixed; bottom: 28px; right: 28px; z-index: 100;
    background: #064E3B; color: white; padding: 14px 22px; border-radius: 14px;
    display: flex; align-items: center; gap: 12px;
    font-family: 'DM Sans', sans-serif; font-size: 0.8rem; font-weight: 500;
    box-shadow: 0 8px 32px rgba(5,150,105,0.2); border: 1px solid rgba(255,255,255,0.1);
}
.toast-dot { width: 8px; height: 8px; background: #6EE7B7; border-radius: 50%; flex-shrink: 0; }
@media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2,1fr); } .ph-dash-root { padding: 24px; } }
@media (max-width: 640px)  { .stats-grid { grid-template-columns: 1fr; } }
</style>

<div class="ph-dash-root">

    {{-- HEADER --}}
    <div class="dash-header">
        <div class="dash-header-left">
            <h2>{{ Auth::user()->pharmacie->nom_pharmacie ?? 'Ma Pharmacie' }}</h2>
            <p>📍 {{ Auth::user()->pharmacie->ville ?? 'Cotonou' }}, {{ Auth::user()->pharmacie->adresse ?? 'Bénin' }}</p>
        </div>
        <div class="header-meta">
            <div class="meta-label">Dernière synchro</div>
            <div class="meta-val">{{ now()->format('d/m/Y à H:i') }}</div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#F1F5F9">🧪</div>
            <div class="stat-label">Stock</div>
            <div class="stat-value">{{ $totalProduits ?? 0 }}</div>
            <div class="stat-sub">Médicaments disponibles</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#FFFBEB">📦</div>
            <div class="stat-label">En attente</div>
            <div class="stat-value" style="color:#D97706">{{ $commandes->where('statut', 'en_attente')->count() }}</div>
            <div class="stat-sub">Commandes à traiter</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ECFDF5">🚚</div>
            <div class="stat-label">Validées</div>
            <div class="stat-value">{{ $commandes->where('statut', 'validee')->count() }}</div>
            <div class="stat-sub">Commandes validées</div>
        </div>
        <div class="stat-card accent">
            <div class="stat-icon" style="background:rgba(255,255,255,0.1)">💰</div>
            <div class="stat-label">Revenu net</div>
            <div class="stat-value" style="font-size:1.4rem">
                {{ number_format($commandes->sum('montant_pharmacie') ?? 0, 0, ',', ' ') }}
                <span style="font-size:0.9rem;opacity:0.6">FCFA</span>
            </div>
            <div class="stat-sub">Net pharmacie</div>
        </div>
    </div>

    {{-- TABLE COMMANDES --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="card-title-dot"></div>
                Flux des commandes
            </div>
           
        </div>

        <div style="overflow-x:auto">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Commande</th>
                        <th>Statut</th>
                        <th>Mode</th>
                        <th>Montant</th>
                        <th style="text-align:center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commandes as $commande)
                    <tr>
                        <td>
                            <span class="ref-badge">#CMD-{{ $commande->id }}</span>
                            <div class="date-cell">{{ $commande->created_at->format('d M Y à H:i') }}</div>
                        </td>
                        <td>
                            @php
                                $cls = match($commande->statut) {
                                    'en_attente' => 'status-en_attente',
                                    'validée' => 'status-validée',
                                    default => 'status-default',
                                };
                            @endphp
                            <span class="status-badge {{ $cls }}">{{ $commande->statut }}</span>
                        </td>
                        <td>
                            <span class="mode-badge {{ $commande->mode_livraison === 'livraison' ? 'mode-livraison' : 'mode-retrait' }}">
                                {{ $commande->mode_livraison === 'livraison' ? '🚚 Livraison' : '🏪 Retrait' }}
                            </span>
                        </td>
                        <td>
                            <span class="amount-main">{{ number_format($commande->montant_total, 0, ',', ' ') }} F</span>
                        </td>
                        <td style="text-align:center">
                            <div style="display:flex;justify-content:center;gap:6px;">
                                <button class="action-btn" title="Voir détails">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row"><td colspan="5">Aucune commande reçue pour le moment</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

</div>

{{-- TOAST --}}
@if(session('success'))
<div class="toast" x-data="{ show: true }" x-show="show"
     x-init="setTimeout(() => show = false, 3500)" x-transition>
    <span class="toast-dot"></span>
    <span>{{ session('success') }}</span>
</div>
@endif

</x-app-layout>
