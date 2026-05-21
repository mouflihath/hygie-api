<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
* { box-sizing: border-box; }

.stock-root {
    font-family: 'DM Sans', sans-serif;
    background: #F4F6F9;
    min-height: 100vh;
    padding: 40px 48px;
}

/* ── HEADER ── */
.stock-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 36px;
}
.stock-header-left h2 {
    font-size: 1.65rem;
    font-weight: 700;
    color: #0A1628;
    letter-spacing: -0.5px;
    margin: 0 0 4px;
}
.stock-header-left p {
    font-size: 0.8rem;
    color: #94A3B8;
    font-weight: 500;
    margin: 0;
}
.stock-date {
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

/* ── FORM CARD ── */
.card {
    background: white;
    border-radius: 22px;
    border: 1px solid #EEF1F7;
    overflow: hidden;
    margin-bottom: 24px;
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

/* ── FORM ── */
.form-wrap {
    padding: 28px;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr auto;
    gap: 16px;
    align-items: flex-end;
}
.form-group label {
    display: block;
    font-size: 0.65rem;
    font-weight: 700;
    color: #B0BAC9;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 8px;
}
.form-control {
    width: 100%;
    background: #F8FAFC;
    border: 1.5px solid #EEF1F7;
    border-radius: 12px;
    padding: 11px 14px;
    font-size: 0.8rem;
    font-family: 'DM Sans', sans-serif;
    color: #0A1628;
    transition: all 0.15s;
    outline: none;
    appearance: none;
}
.form-control:focus {
    border-color: #059669;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(5,150,105,0.08);
}
.form-control::placeholder { color: #C8D0DC; }
.submit-btn {
    background: #064E3B;
    color: white;
    border: none;
    border-radius: 12px;
    padding: 12px 22px;
    font-size: 0.7rem;
    font-weight: 700;
    font-family: 'DM Sans', sans-serif;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}
.submit-btn:hover {
    background: #059669;
    box-shadow: 0 6px 20px rgba(5,150,105,0.25);
    transform: translateY(-1px);
}

/* ── TABLE ── */
.dash-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.8rem;
}
.dash-table thead tr { background: #FAFBFD; }
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

.med-name {
    font-weight: 600;
    color: #0A1628;
}
.qty-normal {
    font-family: 'DM Mono', monospace;
    font-weight: 700;
    font-size: 0.82rem;
    color: #374151;
}
.qty-low {
    font-family: 'DM Mono', monospace;
    font-weight: 700;
    font-size: 0.82rem;
    color: #EF4444;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.qty-low::before {
    content: '⚠';
    font-size: 0.7rem;
}
.price-badge {
    font-family: 'DM Mono', monospace;
    font-weight: 700;
    font-size: 0.8rem;
    color: #059669;
}
.del-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.65rem;
    font-weight: 700;
    color: #94A3B8;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    background: transparent;
    border: 1.5px solid #EEF1F7;
    border-radius: 8px;
    padding: 6px 12px;
    cursor: pointer;
    transition: all 0.15s;
    font-family: 'DM Sans', sans-serif;
}
.del-btn:hover {
    color: #EF4444;
    border-color: #FECACA;
    background: #FEF2F2;
}
.ref-badge {
    font-family: 'DM Mono', monospace;
    font-size: 0.7rem;
    background: #F4F6F9;
    color: #64748B;
    padding: 4px 9px;
    border-radius: 7px;
    font-weight: 500;
}
.empty-row td {
    padding: 60px 20px;
    text-align: center;
    color: #C8D0DC;
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.15em;
}

@media (max-width: 1024px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .form-wrap  { grid-template-columns: 1fr 1fr; }
    .stock-root { padding: 24px; }
}
@media (max-width: 640px) {
    .stats-grid { grid-template-columns: 1fr; }
    .form-wrap  { grid-template-columns: 1fr; }
}
</style>

<div class="stock-root">

    {{-- HEADER --}}
    <div class="stock-header">
        <div class="stock-header-left">
            <h2>Gestion du Stock</h2>
            <p>Inventaire & approvisionnement médicaments</p>
        </div>
        <div class="stock-date">
            {{ now()->translatedFormat('l d F Y') }}
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon" style="background:#ECFDF5">🧪</div>
            <div class="stat-label">Références en stock</div>
            <div class="stat-value">{{ $stocks->count() }}</div>
            <div class="stat-sub">Produits enregistrés</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF2F2">⚠️</div>
            <div class="stat-label">Stock faible</div>
            <div class="stat-value">{{ $stocks->where('quantite', '<', 5)->count() }}</div>
            <div class="stat-sub">Produits &lt; 5 unités</div>
        </div>

        <div class="stat-card accent">
            <div class="stat-icon" style="background:rgba(255,255,255,0.1)">💊</div>
            <div class="stat-label">Valeur totale stock</div>
            <div class="stat-value" style="font-size:1.4rem">
                {{ number_format($stocks->sum(fn($s) => ($s->quantite ?? 0) * ($s->prix ?? 0)), 0, ',', ' ') }}
                <span style="font-size:0.9rem;opacity:0.6">FCFA</span>
            </div>
            <div class="stat-sub">Valorisation inventaire</div>
        </div>

    </div>

    {{-- FORM CARD --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="card-title-dot"></div>
                Ajouter un produit au stock
            </div>
            <span class="card-badge">Approvisionnement</span>
        </div>
        <form action="{{ route('pharmacie.stocks.store') }}" method="POST" class="form-wrap">
            @csrf
            <div class="form-group">
                <label for="medicament_id">Médicament</label>
                <select name="medicament_id" id="medicament_id" class="form-control" required>
                    <option value="" disabled selected>Choisir…</option>
                    @foreach($medicaments as $medoc)
                        <option value="{{ $medoc->id }}">{{ $medoc->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="quantite">Quantité</label>
                <input type="number" name="quantite" id="quantite" min="1"
                       class="form-control" placeholder="Ex : 50" required>
            </div>
            <div class="form-group">
                <label for="prix">Prix unitaire (FCFA)</label>
                <input type="number" name="prix" id="prix" min="0" step="1"
                       class="form-control" placeholder="Ex : 1500" required>
            </div>
            <div>
                <button type="submit" class="submit-btn">+ Ajouter</button>
            </div>
        </form>
    </div>

    {{-- TABLE CARD --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="card-title-dot"></div>
                Inventaire actuel
            </div>
            <span class="card-badge">{{ $stocks->count() }} références</span>
        </div>

        <div style="overflow-x:auto">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Médicament</th>
                        <th>Quantité</th>
                        <th class="right">Prix unitaire</th>
                        <th class="right">Valeur stock</th>
                        <th class="right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stocks as $item)
                    <tr>
                        <td>
                            <span class="ref-badge">{{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <span class="med-name">{{ $item->medicament?->nom ?? 'Médicament supprimé' }}</span>
                        </td>
                        <td>
                            @if($item->quantite < 5)
                                <span class="qty-low">{{ $item->quantite }} unités</span>
                            @else
                                <span class="qty-normal">{{ $item->quantite }}</span>
                            @endif
                        </td>
                        <td style="text-align:right">
                            <span class="price-badge">{{ number_format($item->prix, 0, ',', ' ') }} F</span>
                        </td>
                        <td style="text-align:right">
                            <span style="font-family:'DM Mono',monospace;font-weight:600;font-size:0.78rem;color:#374151;">
                                {{ number_format(($item->quantite ?? 0) * ($item->prix ?? 0), 0, ',', ' ') }} F
                            </span>
                        </td>
                        <td style="text-align:right">
                            <form action="{{ route('pharmacie.stocks.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Supprimer ce produit du stock ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="del-btn">
                                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="6">Aucun produit en stock pour le moment</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</x-app-layout>
