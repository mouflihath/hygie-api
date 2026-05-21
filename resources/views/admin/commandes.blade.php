<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
* { box-sizing:border-box; }
.root { font-family:'DM Sans',sans-serif; background:#F4F6F9; min-height:100vh; padding:40px 48px; }
.page-header { display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:36px; }
.page-header h2 { font-size:1.65rem; font-weight:700; color:#0A1628; letter-spacing:-.5px; margin:0 0 4px; }
.page-header p  { font-size:.8rem; color:#94A3B8; font-weight:500; margin:0; }
.date-pill { font-size:.75rem; color:#94A3B8; font-weight:600; background:white; border:1px solid #E8EDF5; padding:8px 16px; border-radius:20px; }
.stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:28px; }
.stat-card { background:white; border-radius:18px; padding:24px 22px; border:1px solid #EEF1F7; position:relative; overflow:hidden; transition:.2s; }
.stat-card:hover { box-shadow:0 8px 30px rgba(0,0,0,.06); transform:translateY(-2px); }
.stat-card.accent { background:#064E3B; border-color:#064E3B; }
.stat-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:.9rem; margin-bottom:16px; }
.stat-label { font-size:.65rem; font-weight:700; color:#94A3B8; text-transform:uppercase; letter-spacing:.08em; margin-bottom:5px; }
.stat-card.accent .stat-label { color:rgba(255,255,255,.5); }
.stat-value { font-size:1.8rem; font-weight:700; color:#0A1628; letter-spacing:-1px; font-family:'DM Mono',monospace; }
.stat-card.accent .stat-value { color:white; }
.stat-sub { font-size:.68rem; color:#94A3B8; margin-top:5px; }
.stat-card.accent .stat-sub { color:rgba(255,255,255,.4); }
.card { background:white; border-radius:22px; border:1px solid #EEF1F7; overflow:hidden; }
.card-header { display:flex; align-items:center; justify-content:space-between; padding:20px 26px; border-bottom:1px solid #F1F5F9; flex-wrap:wrap; gap:12px; }
.card-title { font-size:.85rem; font-weight:700; color:#0A1628; display:flex; align-items:center; gap:8px; }
.card-dot { width:8px; height:8px; border-radius:50%; background:#059669; }
.filter-select, .filter-input { font-size:.72rem; font-weight:600; color:#374151; background:#F8FAFC; border:1.5px solid #EEF1F7; border-radius:10px; padding:7px 12px; outline:none; font-family:'DM Sans',sans-serif; transition:.15s; appearance:none; }
.filter-select:focus, .filter-input:focus { border-color:#059669; background:white; }
.dash-table { width:100%; border-collapse:collapse; font-size:.8rem; }
.dash-table thead tr { background:#FAFBFD; }
.dash-table th { padding:12px 20px; font-size:.62rem; font-weight:700; color:#B0BAC9; text-transform:uppercase; letter-spacing:.1em; text-align:left; border-bottom:1px solid #F1F5F9; }
.dash-table th.right { text-align:right; }
.dash-table td { padding:14px 20px; color:#374151; font-weight:500; border-bottom:1px solid #F8FAFC; vertical-align:middle; }
.dash-table tr:last-child td { border-bottom:none; }
.dash-table tr:hover td { background:#FAFBFF; }
.ref-badge { font-family:'DM Mono',monospace; font-size:.7rem; background:#F4F6F9; color:#64748B; padding:4px 9px; border-radius:7px; }
.pharma-name { font-weight:600; color:#0A1628; }
.date-small { font-size:.68rem; color:#94A3B8; margin-top:3px; }
.mode-badge { display:inline-flex; align-items:center; padding:3px 9px; border-radius:20px; font-size:.62rem; font-weight:700; text-transform:uppercase; }
.mode-livraison { background:#EFF6FF; color:#3B82F6; }
.mode-retrait   { background:#F3E8FF; color:#8B5CF6; }
.status-badge { display:inline-flex; align-items:center; padding:3px 9px; border-radius:20px; font-size:.62rem; font-weight:700; text-transform:uppercase; }
.s-en_attente    { background:#FFFBEB; color:#D97706; }
.s-en_livraison  { background:#EFF6FF; color:#3B82F6; }
.s-livree,.s-livre { background:#ECFDF5; color:#059669; }
.s-en_preparation { background:#FFF7ED; color:#EA580C; }
.s-a_retirer     { background:#F3E8FF; color:#8B5CF6; }
.s-default       { background:#F4F6F9; color:#64748B; }
.amount { font-family:'DM Mono',monospace; font-weight:700; font-size:.78rem; }
.commission { color:#059669; }
.empty-row td { padding:60px 20px; text-align:center; color:#C8D0DC; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.15em; }
.pagination-wrap { padding:16px 24px; background:#FAFBFD; border-top:1px solid #F1F5F9; }
@media(max-width:1024px){ .stats-grid{ grid-template-columns:repeat(2,1fr); } .root{ padding:24px; } }
</style>

<div class="root">

    <div class="page-header">
        <div>
            <h2>Toutes les Commandes</h2>
            <p>Suivi global des commandes sur la plateforme</p>
        </div>
        <div class="date-pill">{{ now()->translatedFormat('l d F Y') }}</div>
    </div>

    <div class="stats-grid">
        <div class="stat-card accent">
            <div class="stat-icon" style="background:rgba(255,255,255,.1)">📦</div>
            <div class="stat-label">Total commandes</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-sub">Toutes pharmacies</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#FFFBEB">⏳</div>
            <div class="stat-label">En attente</div>
            <div class="stat-value" style="color:#D97706">{{ $stats['en_attente'] }}</div>
            <div class="stat-sub">À traiter</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ECFDF5">✅</div>
            <div class="stat-label">Livrées</div>
            <div class="stat-value" style="color:#059669">{{ $stats['livrees'] }}</div>
            <div class="stat-sub">Complétées</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ECFDF5">💰</div>
            <div class="stat-label">Commissions</div>
            <div class="stat-value" style="font-size:1.3rem">{{ number_format($stats['revenu_total'], 0, ',', ' ') }}</div>
            <div class="stat-sub">FCFA collectés</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="card-dot"></div>
                Journal des commandes
            </div>
            <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="filter-input" placeholder="Réf. commande…" style="width:160px;">
                <select name="statut" class="filter-select" onchange="this.form.submit()">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente"     {{ request('statut')=='en_attente'     ?'selected':'' }}>En attente</option>
                    <option value="en_preparation" {{ request('statut')=='en_preparation' ?'selected':'' }}>En préparation</option>
                    <option value="en_livraison"   {{ request('statut')=='en_livraison'   ?'selected':'' }}>En livraison</option>
                    <option value="a_retirer"      {{ request('statut')=='a_retirer'      ?'selected':'' }}>À retirer</option>
                    <option value="livree"         {{ request('statut')=='livree'         ?'selected':'' }}>Livrée</option>
                </select>
                <button type="submit" style="background:#064E3B;color:white;border:none;border-radius:10px;padding:7px 16px;font-size:.7rem;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;text-transform:uppercase;letter-spacing:.06em;">
                    Filtrer
                </button>
            </form>
        </div>

        <div style="overflow-x:auto">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Pharmacie</th>
                        <th>Mode</th>
                        <th>Statut</th>
                        <th class="right">Montant patient</th>
                        <th class="right">Commission</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($commandes as $cmd)
                    @php
                        $etat = $cmd->etat_commande ?? $cmd->statut ?? 'en_attente';
                        $sCls = match($etat) {
                            'livree','livre' => 's-livree',
                            'en_livraison'   => 's-en_livraison',
                            'en_preparation' => 's-en_preparation',
                            'a_retirer'      => 's-a_retirer',
                            'en_attente'     => 's-en_attente',
                            default          => 's-default',
                        };
                    @endphp
                    <tr>
                        <td><span class="ref-badge">{{ $cmd->reference_commande ?? '#'.$cmd->id }}</span></td>
                        <td>
                            <div class="pharma-name">{{ $cmd->pharmacie->nom_pharmacie ?? 'Pharmacie #'.$cmd->pharmacie_id }}</div>
                        </td>
                        <td>
                            <span class="mode-badge {{ $cmd->mode_livraison==='livraison' ? 'mode-livraison':'mode-retrait' }}">
                                {{ $cmd->mode_livraison==='livraison' ? 'Livraison':'Retrait' }}
                            </span>
                        </td>
                        <td><span class="status-badge {{ $sCls }}">{{ $etat }}</span></td>
                        <td style="text-align:right">
                            <span class="amount">{{ number_format($cmd->montant_total_patient ?? 0, 0, ',', ' ') }} F</span>
                        </td>
                        <td style="text-align:right">
                            <span class="amount commission">{{ number_format($cmd->commission_application ?? 0, 0, ',', ' ') }} F</span>
                        </td>
                        <td style="font-size:.7rem;color:#94A3B8;">{{ $cmd->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr class="empty-row"><td colspan="7">Aucune commande trouvée</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($commandes->hasPages())
        <div class="pagination-wrap">{{ $commandes->links() }}</div>
        @endif
    </div>
</div>
</x-app-layout>
