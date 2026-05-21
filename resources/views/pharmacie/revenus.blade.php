<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

<style>
* { box-sizing:border-box; }
.root { font-family:'DM Sans',sans-serif; background:#F4F6F9; min-height:100vh; padding:40px 48px; }
.page-header { display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:36px; }
.page-header h2 { font-size:1.65rem; font-weight:700; color:#0A1628; letter-spacing:-.5px; margin:0 0 4px; }
.page-header p  { font-size:.8rem; color:#94A3B8; font-weight:500; margin:0; }
.date-pill { font-size:.75rem; color:#94A3B8; font-weight:600; background:white; border:1px solid #E8EDF5; padding:8px 16px; border-radius:20px; }
.stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:28px; }
.stat-card { background:white; border-radius:20px; padding:28px 24px; border:1px solid #EEF1F7; position:relative; overflow:hidden; transition:.2s; }
.stat-card:hover { box-shadow:0 8px 30px rgba(0,0,0,.06); transform:translateY(-2px); }
.stat-card.accent { background:#064E3B; border-color:#064E3B; }
.stat-icon { width:38px; height:38px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1rem; margin-bottom:18px; }
.stat-label { font-size:.68rem; font-weight:700; color:#94A3B8; text-transform:uppercase; letter-spacing:.08em; margin-bottom:6px; }
.stat-card.accent .stat-label { color:rgba(255,255,255,.5); }
.stat-value { font-size:1.7rem; font-weight:700; color:#0A1628; letter-spacing:-1px; font-family:'DM Mono',monospace; line-height:1; }
.stat-card.accent .stat-value { color:white; }
.stat-sub { font-size:.68rem; color:#94A3B8; margin-top:7px; }
.stat-card.accent .stat-sub { color:rgba(255,255,255,.4); }
.grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:24px; }
.card { background:white; border-radius:22px; border:1px solid #EEF1F7; overflow:hidden; }
.card-header { display:flex; align-items:center; justify-content:space-between; padding:22px 26px; border-bottom:1px solid #F1F5F9; }
.card-title { font-size:.85rem; font-weight:700; color:#0A1628; display:flex; align-items:center; gap:8px; }
.card-dot { width:8px; height:8px; border-radius:50%; background:#059669; }
.card-badge { font-size:.62rem; font-weight:700; color:#94A3B8; background:#F4F6F9; padding:4px 10px; border-radius:20px; text-transform:uppercase; letter-spacing:.05em; }
.chart-wrapper { padding:24px 26px; position:relative; height:280px; }
/* Table pharmacies */
.dash-table { width:100%; border-collapse:collapse; font-size:.8rem; }
.dash-table thead tr { background:#FAFBFD; }
.dash-table th { padding:12px 20px; font-size:.62rem; font-weight:700; color:#B0BAC9; text-transform:uppercase; letter-spacing:.1em; text-align:left; border-bottom:1px solid #F1F5F9; }
.dash-table th.right { text-align:right; }
.dash-table td { padding:14px 20px; color:#374151; font-weight:500; border-bottom:1px solid #F8FAFC; vertical-align:middle; }
.dash-table tr:last-child td { border-bottom:none; }
.dash-table tr:hover td { background:#FAFBFF; }
.rank-badge { width:26px; height:26px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; font-size:.68rem; font-weight:700; font-family:'DM Mono',monospace; }
.pharma-name { font-weight:600; color:#0A1628; }
.amount-green { font-family:'DM Mono',monospace; font-weight:700; color:#059669; }
.amount-gray  { font-family:'DM Mono',monospace; font-weight:600; color:#94A3B8; font-size:.72rem; }
@media(max-width:1024px){ .stats-grid{grid-template-columns:repeat(2,1fr);} .grid-2{grid-template-columns:1fr;} .root{padding:24px;} }
</style>

<div class="root">

    <div class="page-header">
        <div>
            <h2>Revenus & Finances</h2>
            <p>Commissions générées par {{ auth()->user()->pharmacie->nom_pharmacie ?? 'votre pharmacie' }}</p>
        </div>
        <div class="date-pill">{{ now()->translatedFormat('l d F Y') }}</div>
    </div>

    <div class="stats-grid">
        <div class="stat-card accent">
            <div class="stat-icon" style="background:rgba(255,255,255,.1)">💰</div>
            <div class="stat-label">Revenu total</div>
            <div class="stat-value" style="font-size:1.4rem">{{ number_format($revenuTotal, 0, ',', ' ') }}<span style="font-size:.85rem;opacity:.5"> F</span></div>
            <div class="stat-sub">Depuis le lancement</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ECFDF5">📅</div>
            <div class="stat-label">Aujourd'hui</div>
            <div class="stat-value" style="font-size:1.5rem">{{ number_format($revenuAujourdhui, 0, ',', ' ') }}</div>
            <div class="stat-sub">FCFA ce jour</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#EFF6FF">📆</div>
            <div class="stat-label">Cette semaine</div>
            <div class="stat-value" style="font-size:1.5rem">{{ number_format($revenuSemaine, 0, ',', ' ') }}</div>
            <div class="stat-sub">FCFA cette semaine</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#F3E8FF">🗓️</div>
            <div class="stat-label">Ce mois</div>
            <div class="stat-value" style="font-size:1.5rem">{{ number_format($revenuMois, 0, ',', ' ') }}</div>
            <div class="stat-sub">FCFA en {{ now()->translatedFormat('F') }}</div>
        </div>
    </div>

    <div class="grid-2">

        {{-- Graphique 12 mois --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title"><div class="card-dot"></div>Évolution mensuelle</div>
                <span class="card-badge">12 derniers mois</span>
            </div>
            <div class="chart-wrapper">
                @if($parMois->isEmpty())
                    <p style="text-align:center;color:#C8D0DC;font-size:.75rem;padding:30px 0;">Aucune donnée disponible</p>
                @else
                    <canvas id="revenueChart"></canvas>
                @endif
            </div>
        </div>

        {{-- Commandes récentes --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title"><div class="card-dot" style="background:#F59E0B"></div>Commandes récentes</div>
                <span class="card-badge">10 dernières</span>
            </div>
            <div style="overflow-x:auto">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th class="right">Commission</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commandesRecentes as $cmd)
                        @php
                            $statutColors = [
                                'en_attente'    => ['bg' => '#FEF3C7', 'color' => '#B45309', 'label' => 'En attente'],
                                'en_preparation'=> ['bg' => '#DBEAFE', 'color' => '#1D4ED8', 'label' => 'Préparation'],
                                'en_livraison'  => ['bg' => '#EDE9FE', 'color' => '#7C3AED', 'label' => 'En livraison'],
                                'a_retirer'     => ['bg' => '#FEE2E2', 'color' => '#DC2626', 'label' => 'À retirer'],
                                'livree'        => ['bg' => '#D1FAE5', 'color' => '#065F46', 'label' => 'Livrée'],
                            ];
                            $s = $statutColors[$cmd->statut] ?? ['bg' => '#F4F6F9', 'color' => '#94A3B8', 'label' => $cmd->statut];
                        @endphp
                        <tr>
                            <td>
                                <span style="font-family:'DM Mono',monospace;font-size:.75rem;font-weight:700;color:#0A1628;">
                                    {{ $cmd->reference_commande }}
                                </span>
                            </td>
                            <td>
                                <span class="amount-gray">{{ $cmd->created_at->translatedFormat('d M Y') }}</span>
                            </td>
                            <td>
                                <span style="background:{{ $s['bg'] }};color:{{ $s['color'] }};padding:3px 10px;border-radius:20px;font-size:.65rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">
                                    {{ $s['label'] }}
                                </span>
                            </td>
                            <td style="text-align:right">
                                <span class="amount-green">{{ number_format($cmd->commission_application, 0, ',', ' ') }} F</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="padding:40px;text-align:center;color:#C8D0DC;font-size:.72rem;font-weight:700;text-transform:uppercase;">Aucune commande</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@if($parMois->isNotEmpty())
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('revenueChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 260);
    gradient.addColorStop(0, 'rgba(5,150,105,0.18)');
    gradient.addColorStop(1, 'rgba(5,150,105,0.01)');

    const labels = @json($parMois->map(fn($m) => \Carbon\Carbon::createFromFormat('Y-m', $m->mois)->translatedFormat('M y')));
    const values = @json($parMois->pluck('total'));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenus (FCFA)',
                data: values,
                fill: true,
                backgroundColor: gradient,
                borderColor: '#059669',
                borderWidth: 2.5,
                pointBackgroundColor: '#059669',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.45,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0A1628',
                    titleFont: { family: 'DM Sans', size: 11, weight: '600' },
                    bodyFont: { family: 'DM Mono', size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: function(context) {
                            return ' ' + new Intl.NumberFormat('fr-FR').format(context.parsed.y) + ' F';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        font: { family: 'DM Sans', size: 11, weight: '600' },
                        color: '#94A3B8',
                    }
                },
                y: {
                    grid: { color: '#F1F5F9' },
                    border: { display: false },
                    ticks: {
                        font: { family: 'DM Mono', size: 10 },
                        color: '#B0BAC9',
                        callback: function(value) {
                            if (value >= 1000000) return (value / 1000000).toFixed(1) + 'M F';
                            if (value >= 1000) return (value / 1000).toFixed(0) + 'k F';
                            return value + ' F';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endif

</x-app-layout>
