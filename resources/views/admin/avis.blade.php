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
.stat-card { background:white; border-radius:20px; padding:26px 22px; border:1px solid #EEF1F7; position:relative; overflow:hidden; transition:.2s; }
.stat-card:hover { box-shadow:0 8px 30px rgba(0,0,0,.06); transform:translateY(-2px); }
.stat-card.accent { background:#064E3B; border-color:#064E3B; }
.stat-icon { width:38px; height:38px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1rem; margin-bottom:16px; }
.stat-label { font-size:.68rem; font-weight:700; color:#94A3B8; text-transform:uppercase; letter-spacing:.08em; margin-bottom:5px; }
.stat-card.accent .stat-label { color:rgba(255,255,255,.5); }
.stat-value { font-size:1.85rem; font-weight:700; color:#0A1628; letter-spacing:-1px; font-family:'DM Mono',monospace; }
.stat-card.accent .stat-value { color:white; }
.stat-sub { font-size:.68rem; color:#94A3B8; margin-top:6px; }
.stat-card.accent .stat-sub { color:rgba(255,255,255,.4); }
.card { background:white; border-radius:22px; border:1px solid #EEF1F7; overflow:hidden; }
.card-header { display:flex; align-items:center; justify-content:space-between; padding:22px 26px; border-bottom:1px solid #F1F5F9; flex-wrap:wrap; gap:12px; }
.card-title { font-size:.85rem; font-weight:700; color:#0A1628; display:flex; align-items:center; gap:8px; }
.card-dot { width:8px; height:8px; border-radius:50%; background:#F59E0B; }
.filter-select, .filter-input { font-size:.72rem; font-weight:600; color:#374151; background:#F8FAFC; border:1.5px solid #EEF1F7; border-radius:10px; padding:7px 12px; outline:none; font-family:'DM Sans',sans-serif; transition:.15s; appearance:none; }
.filter-select:focus,.filter-input:focus { border-color:#059669; background:white; }
.avis-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; padding:24px 26px; }
.avis-card { background:#FAFBFD; border:1px solid #EEF1F7; border-radius:16px; padding:20px; transition:.2s; }
.avis-card:hover { border-color:#A7F3D0; box-shadow:0 4px 20px rgba(5,150,105,.06); }
.stars { color:#F59E0B; font-size:.75rem; letter-spacing:2px; margin-bottom:10px; }
.avis-sujet { font-size:.65rem; font-weight:700; color:#059669; text-transform:uppercase; letter-spacing:.07em; margin-bottom:8px; }
.avis-msg { font-size:.75rem; color:#64748B; line-height:1.65; font-style:italic; }
.avis-footer { display:flex; justify-content:space-between; align-items:center; margin-top:14px; padding-top:12px; border-top:1px solid #EEF1F7; }
.avis-author { font-size:.65rem; font-weight:700; color:#0A1628; text-transform:uppercase; letter-spacing:.05em; }
.avis-time { font-size:.6rem; color:#94A3B8; font-weight:600; }
.avis-note { display:inline-flex; align-items:center; gap:3px; background:#FEF3C7; color:#D97706; border-radius:6px; padding:2px 7px; font-size:.65rem; font-weight:700; font-family:'DM Mono',monospace; }
.empty-avis { grid-column:1/-1; padding:60px; text-align:center; color:#C8D0DC; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.15em; }
.pagination-wrap { padding:16px 24px; background:#FAFBFD; border-top:1px solid #F1F5F9; }
@media(max-width:1200px){ .avis-grid{grid-template-columns:repeat(3,1fr);} }
@media(max-width:900px) { .avis-grid{grid-template-columns:repeat(2,1fr);} .stats-grid{grid-template-columns:repeat(2,1fr);} .root{padding:24px;} }
@media(max-width:580px) { .avis-grid{grid-template-columns:1fr;} .stats-grid{grid-template-columns:1fr;} }
</style>

<div class="root">

    <div class="page-header">
        <div>
            <h2>Retours Clients</h2>
            <p>Avis et commentaires reçus sur la plateforme</p>
        </div>
        <div class="date-pill">{{ now()->translatedFormat('l d F Y') }}</div>
    </div>

    <div class="stats-grid">
        <div class="stat-card accent">
            <div class="stat-icon" style="background:rgba(255,255,255,.1)">💬</div>
            <div class="stat-label">Total messages</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-sub">Commentaires reçus</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF3C7">✉️</div>
            <div class="stat-label">Avec sujet</div>
            <div class="stat-value" style="color:#D97706">{{ $stats['avec_sujet'] }}</div>
            <div class="stat-sub">Messages classés</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ECFDF5">📝</div>
            <div class="stat-label">Sans sujet</div>
            <div class="stat-value" style="color:#059669">{{ $stats['sans_sujet'] }}</div>
            <div class="stat-sub">Messages libres</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#EFF6FF">📅</div>
            <div class="stat-label">Cette semaine</div>
            <div class="stat-value" style="color:#3B82F6">{{ $stats['cette_semaine'] }}</div>
            <div class="stat-sub">Nouveaux avis</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="card-dot"></div>
                Tous les commentaires
            </div>
            <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="filter-input" placeholder="Rechercher…" style="width:180px;">
                <button type="submit" style="background:#064E3B;color:white;border:none;border-radius:10px;padding:7px 16px;font-size:.7rem;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;text-transform:uppercase;letter-spacing:.06em;">
                    Filtrer
                </button>
            </form>
        </div>

        <div class="avis-grid">
            @forelse($avis as $com)
            <div class="avis-card">
                @if($com->sujet)
                <div class="avis-sujet">{{ $com->sujet }}</div>
                @endif
                <div class="avis-msg">"{{ $com->message }}"</div>
                <div class="avis-footer">
                    <span class="avis-author">{{ $com->nom }}</span>
                    <span class="avis-time">{{ $com->created_at->diffForHumans() }}</span>
                </div>
            </div>
            @empty
            <div class="empty-avis">Aucun commentaire pour le moment</div>
            @endforelse
        </div>

        @if($avis->hasPages())
        <div class="pagination-wrap">{{ $avis->links() }}</div>
        @endif
    </div>
</div>
</x-app-layout>
