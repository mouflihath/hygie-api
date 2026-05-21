<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
* { box-sizing: border-box; }

.dash-root {
    font-family: 'DM Sans', sans-serif;
    background: #F4F6F9;
    min-height: 100vh;
    padding: 40px 48px;
}

/* ── HEADER ── */
.dash-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 36px;
}

.dash-header-left h2 {
    font-size: 1.65rem;
    font-weight: 700;
    color: #0A1628;
    letter-spacing: -0.5px;
    margin: 0 0 4px;
}

.dash-header-left p {
    font-size: 0.8rem;
    color: #94A3B8;
    font-weight: 500;
    margin: 0;
}

.dash-date {
    font-size: 0.75rem;
    color: #94A3B8;
    font-weight: 600;
    background: white;
    border: 1px solid #E8EDF5;
    padding: 8px 16px;
    border-radius: 20px;
}

/* ── STATS GRID ── */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
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

.stat-card:hover {
    box-shadow: 0 8px 30px rgba(0,0,0,0.06);
    transform: translateY(-2px);
}

.stat-card.accent {
    background: #064E3B;
    border-color: #064E3B;
}

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

.stat-label {
    font-size: 0.7rem;
    font-weight: 600;
    color: #94A3B8;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 6px;
}

.stat-card.accent .stat-label { color: rgba(255,255,255,0.5); }

.stat-value {
    font-size: 1.9rem;
    font-weight: 700;
    color: #0A1628;
    letter-spacing: -1px;
    line-height: 1;
    margin-bottom: 8px;
    font-family: 'DM Mono', monospace;
}

.stat-card.accent .stat-value { color: white; }

.stat-sub {
    font-size: 0.7rem;
    color: #94A3B8;
    font-weight: 500;
}

.stat-card.accent .stat-sub { color: rgba(255,255,255,0.4); }

.stat-sub b { color: #3B82F6; }
.stat-card.accent .stat-sub b { color: #6EE7B7; }

/* ── MAIN GRID ── */
.main-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
}

/* ── TABLE CARD ── */
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

.card-title-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #059669;
}

.card-badge {
    font-size: 0.65rem;
    font-weight: 700;
    color: #94A3B8;
    background: #F4F6F9;
    padding: 5px 12px;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* ── TABLE ── */
.dash-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.8rem;
}

.dash-table thead tr {
    background: #FAFBFD;
}

.dash-table th {
    padding: 13px 20px;
    font-size: 0.65rem;
    font-weight: 700;
    color: #B0BAC9;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    text-align: left;
    border-bottom: 1px solid #F1F5F9;
}

.dash-table th.right { text-align: right; }

.dash-table td {
    padding: 14px 20px;
    color: #374151;
    font-weight: 500;
    border-bottom: 1px solid #F8FAFC;
    vertical-align: middle;
}

.dash-table tr:last-child td { border-bottom: none; }

.dash-table tr:hover td { background: #FAFBFF; }

.ref-badge {
    font-family: 'DM Mono', monospace;
    font-size: 0.7rem;
    background: #F4F6F9;
    color: #64748B;
    padding: 4px 9px;
    border-radius: 7px;
    font-weight: 500;
}

.mode-badge, .status-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.mode-livraison { background: #EFF6FF; color: #3B82F6; }
.mode-retrait   { background: #F3E8FF; color: #8B5CF6; }

.status-livre      { background: #ECFDF5; color: #059669; }
.status-en_livraison { background: #EFF6FF; color: #3B82F6; }
.status-en_attente { background: #FFFBEB; color: #D97706; }

.amount-main { font-weight: 700; color: #0A1628; font-family: 'DM Mono', monospace; font-size: 0.78rem; }
.amount-commission { font-weight: 700; color: #059669; font-family: 'DM Mono', monospace; font-size: 0.78rem; }

.pharma-name { font-weight: 600; color: #374151; }

.date-cell { font-size: 0.7rem; color: #94A3B8; font-weight: 500; }

.empty-row td {
    padding: 60px 20px;
    text-align: center;
    color: #C8D0DC;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.15em;
}

/* ── PAGINATION ── */
.pagination-wrap {
    padding: 16px 24px;
    background: #FAFBFD;
    border-top: 1px solid #F1F5F9;
}

/* ── COMMENTAIRES ── */
.comments-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    padding: 24px 28px;
}

.comment-card {
    background: #FAFBFD;
    border: 1px solid #EEF1F7;
    border-radius: 16px;
    padding: 20px;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.comment-card:hover {
    border-color: #A7F3D0;
    box-shadow: 0 4px 20px rgba(5,150,105,0.06);
}

.comment-stars {
    color: #F59E0B;
    font-size: 0.7rem;
    letter-spacing: 1px;
    margin-bottom: 10px;
}

.comment-subject {
    font-size: 0.68rem;
    font-weight: 700;
    color: #059669;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 6px;
}

.comment-message {
    font-size: 0.75rem;
    color: #64748B;
    line-height: 1.65;
    font-style: italic;
}

.comment-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 14px;
    padding-top: 12px;
    border-top: 1px solid #EEF1F7;
}

.comment-author {
    font-size: 0.65rem;
    font-weight: 700;
    color: #0A1628;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.comment-time {
    font-size: 0.6rem;
    color: #94A3B8;
    font-weight: 600;
}

.empty-comments {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px;
    color: #C8D0DC;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.15em;
}

@media (max-width: 1024px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .comments-grid { grid-template-columns: repeat(2, 1fr); }
    .dash-root { padding: 24px; }
}

@media (max-width: 640px) {
    .stats-grid { grid-template-columns: 1fr; }
    .comments-grid { grid-template-columns: 1fr; }
}
</style>

<div class="dash-root">

    {{-- HEADER --}}
    <div class="dash-header">
        <div class="dash-header-left">
            <h2>Dashboard Admin</h2>
            <p>Vue globale de la plateforme Hygie+</p>
        </div>
        <div class="dash-date">
            {{ now()->translatedFormat('l d F Y') }}
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon" style="background:#ECFDF5">🏥</div>
            <div class="stat-label">Pharmacies partenaires</div>
            <div class="stat-value">{{ $pharmacies->count() }}</div>
            <div class="stat-sub">Actives sur la plateforme</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:#EFF6FF">📦</div>
            <div class="stat-label">Commandes totales</div>
            <div class="stat-value">{{ $totalCommandes ?? 0 }}</div>
            <div class="stat-sub">dont <b>{{ $commandesAujourdhui ?? 0 }}</b> aujourd'hui</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:#F3E8FF">👤</div>
            <div class="stat-label">Patients inscrits</div>
            <div class="stat-value">{{ $totalPatients ?? 0 }}</div>
            <div class="stat-sub">Comptes actifs</div>
        </div>

        <div class="stat-card accent">
            <div class="stat-icon" style="background:rgba(255,255,255,0.1)">💰</div>
            <div class="stat-label">Revenu plateforme</div>
            <div class="stat-value" style="font-size:1.4rem">{{ number_format($revenuTotal ?? 0, 0, ',', ' ') }} <span style="font-size:0.9rem;opacity:0.6">FCFA</span></div>
            <div class="stat-sub">+ <b>{{ number_format($revenuAujourdhui ?? 0, 0, ',', ' ') }} F</b> aujourd'hui</div>
        </div>

    </div>

    {{-- MAIN CONTENT --}}
    <div class="main-grid">

        {{-- TABLE COMMANDES --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="card-title-dot"></div>
                    Commandes récentes
                </div>
                <span class="card-badge">Page {{ $commandesRecentes->currentPage() }}</span>
            </div>

            <div style="overflow-x:auto">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Pharmacie</th>
                            <th>Mode</th>
                            <th class="right">Montant patient</th>
                            <th class="right">Commission</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commandesRecentes ?? [] as $cmd)
                        <tr>
                            <td><span class="ref-badge">{{ $cmd->reference_commande ?? '—' }}</span></td>
                            <td><span class="pharma-name">{{ $cmd->pharmacie->nom_pharmacie ?? $cmd->pharmacie->nom ?? $cmd->pharmacie->name ?? ('Pharmacie #' . $cmd->pharmacie_id) }}</span></td>
                            <td>
                                <span class="mode-badge {{ $cmd->mode_livraison === 'livraison' ? 'mode-livraison' : 'mode-retrait' }}">
                                    {{ $cmd->mode_livraison === 'livraison' ? 'Livraison' : 'Retrait' }}
                                </span>
                            </td>
                            <td style="text-align:right">
                                <span class="amount-main">{{ number_format($cmd->montant_total_patient ?? 0, 0, ',', ' ') }} F</span>
                            </td>
                            <td style="text-align:right">
                                <span class="amount-commission">{{ number_format($cmd->commission_application ?? 0, 0, ',', ' ') }} F</span>
                            </td>
                            <td>
                                @php
                                    $etat = $cmd->etat_commande ?? $cmd->statut ?? 'en_attente';
                                    $cls = match($etat) {
                                        'livree', 'livre'       => 'status-livre',
                                        'en_livraison'         => 'status-en_livraison',
                                        'a_retirer'            => 'status-a_retirer',
                                        'en_preparation'       => 'status-en_preparation',
                                        default                => 'status-en_attente',
                                    };
                                @endphp
                                <span class="status-badge {{ $cls }}">{{ $etat }}</span>
                            </td>
                            <td><span class="date-cell">{{ $cmd->created_at ? $cmd->created_at->format('d/m/Y H:i') : '—' }}</span></td>
                        </tr>
                        @empty
                        <tr class="empty-row"><td colspan="7">Aucune commande enregistrée</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($commandesRecentes->hasPages())
            <div class="pagination-wrap">
                {{ $commandesRecentes->links() }}
            </div>
            @endif
        </div>

        {{-- COMMENTAIRES --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="card-title-dot" style="background:#F59E0B"></div>
                    Retours clients récents
                </div>
                <span class="card-badge">Dernières activités</span>
            </div>

            <div class="comments-grid">
                @forelse($commentaires ?? [] as $com)
                <div class="comment-card">
                    <div class="comment-stars">★★★★★</div>
                    <div class="comment-subject">{{ $com->sujet }}</div>
                    <div class="comment-message">"{{ $com->message }}"</div>
                    <div class="comment-footer">
                        <span class="comment-author">{{ $com->nom }}</span>
                        <span class="comment-time">{{ $com->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @empty
                <div class="empty-comments">Aucun commentaire pour le moment</div>
                @endforelse
            </div>
        </div>

    </div>
</div>
</x-app-layout>
