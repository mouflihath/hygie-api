<x-app-layout>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; }
.root { font-family:'DM Sans',sans-serif; background:#F4F6F9; min-height:100vh; padding:40px 48px; }
.page-header { display:flex; align-items:flex-end; justify-content:space-between; margin-bottom:36px; }
.page-header h2 { font-size:1.65rem; font-weight:700; color:#0A1628; letter-spacing:-0.5px; margin:0 0 4px; }
.page-header p  { font-size:0.8rem; color:#94A3B8; font-weight:500; margin:0; }
.date-pill { font-size:0.75rem; color:#94A3B8; font-weight:600; background:white; border:1px solid #E8EDF5; padding:8px 16px; border-radius:20px; }
.stats-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:16px; margin-bottom:28px; }
.stat-card { background:white; border-radius:18px; padding:22px 20px; border:1px solid #EEF1F7; position:relative; overflow:hidden; transition:.2s; }
.stat-card:hover { box-shadow:0 8px 30px rgba(0,0,0,0.06); transform:translateY(-2px); }
.stat-card.accent { background:#064E3B; border-color:#064E3B; }
.stat-icon { width:34px; height:34px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:0.9rem; margin-bottom:14px; }
.stat-label { font-size:0.65rem; font-weight:700; color:#94A3B8; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:4px; }
.stat-card.accent .stat-label { color:rgba(255,255,255,0.5); }
.stat-value { font-size:1.7rem; font-weight:700; color:#0A1628; letter-spacing:-1px; font-family:'DM Mono',monospace; }
.stat-card.accent .stat-value { color:white; }
.card { background:white; border-radius:22px; border:1px solid #EEF1F7; overflow:hidden; }
.card-header { display:flex; align-items:center; justify-content:space-between; padding:20px 26px; border-bottom:1px solid #F1F5F9; flex-wrap:wrap; gap:12px; }
.card-title { font-size:0.85rem; font-weight:700; color:#0A1628; display:flex; align-items:center; gap:8px; }
.card-dot { width:8px; height:8px; border-radius:50%; background:#059669; }
.filter-wrap { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.filter-select, .filter-input {
    font-size:0.72rem; font-weight:600; color:#374151;
    background:#F8FAFC; border:1.5px solid #EEF1F7; border-radius:10px;
    padding:7px 12px; outline:none; font-family:'DM Sans',sans-serif;
    transition:all .15s; appearance:none;
}
.filter-select:focus, .filter-input:focus { border-color:#059669; background:white; }
.filter-input::placeholder { color:#C8D0DC; }
.dash-table { width:100%; border-collapse:collapse; font-size:0.8rem; }
.dash-table thead tr { background:#FAFBFD; }
.dash-table th { padding:12px 20px; font-size:0.62rem; font-weight:700; color:#B0BAC9; text-transform:uppercase; letter-spacing:0.1em; text-align:left; border-bottom:1px solid #F1F5F9; }
.dash-table td { padding:14px 20px; color:#374151; font-weight:500; border-bottom:1px solid #F8FAFC; vertical-align:middle; }
.dash-table tr:last-child td { border-bottom:none; }
.dash-table tr:hover td { background:#FAFBFF; }
.user-avatar { width:38px; height:38px; border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:0.75rem; font-weight:700; font-family:'DM Mono',monospace; flex-shrink:0; }
.user-name { font-weight:600; color:#0A1628; font-size:0.82rem; }
.user-email { font-size:0.68rem; color:#94A3B8; margin-top:2px; }
.role-badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:0.62rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; }
.role-admin     { background:#FEF3C7; color:#D97706; }
.role-pharmacie { background:#ECFDF5; color:#059669; }
.role-livreur   { background:#EFF6FF; color:#3B82F6; }
.role-patient   { background:#F3E8FF; color:#8B5CF6; }
.code-mono { font-family:'DM Mono',monospace; font-size:0.68rem; background:#F4F6F9; color:#64748B; padding:3px 8px; border-radius:6px; }
.action-wrap { display:flex; justify-content:flex-end; gap:6px; opacity:0; transition:opacity .2s; }
.dash-table tr:hover .action-wrap { opacity:1; }
.btn-del { width:30px; height:30px; border-radius:8px; border:1.5px solid #EEF1F7; background:transparent; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; transition:all .15s; color:#94A3B8; }
.btn-del:hover { background:#FEF2F2; border-color:#FECACA; color:#EF4444; }
.empty-row td { padding:60px 20px; text-align:center; color:#C8D0DC; font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.15em; }
.pagination-wrap { padding:16px 24px; background:#FAFBFD; border-top:1px solid #F1F5F9; }
.toast { position:fixed; bottom:28px; right:28px; z-index:100; background:#064E3B; color:white; padding:14px 22px; border-radius:14px; display:flex; align-items:center; gap:12px; font-size:0.8rem; font-weight:500; box-shadow:0 8px 32px rgba(5,150,105,.2); }
.toast-dot { width:8px; height:8px; background:#6EE7B7; border-radius:50%; }
@media(max-width:1200px){ .stats-grid{ grid-template-columns:repeat(3,1fr); } }
@media(max-width:768px) { .stats-grid{ grid-template-columns:repeat(2,1fr); } .root{ padding:20px; } }
</style>

<div class="root">

    <div class="page-header">
        <div>
            <h2>Gestion Utilisateurs</h2>
            <p>Comptes actifs sur la plateforme Hygie+</p>
        </div>
        <div class="date-pill">{{ now()->translatedFormat('l d F Y') }}</div>
    </div>

    <div class="stats-grid">
        <div class="stat-card accent">
            <div class="stat-icon" style="background:rgba(255,255,255,0.1)">👥</div>
            <div class="stat-label">Total</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#FEF3C7">🛡️</div>
            <div class="stat-label">Admins</div>
            <div class="stat-value" style="color:#D97706">{{ $stats['admins'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ECFDF5">🏥</div>
            <div class="stat-label">Pharmacies</div>
            <div class="stat-value" style="color:#059669">{{ $stats['pharmacies'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#EFF6FF">🛵</div>
            <div class="stat-label">Livreurs</div>
            <div class="stat-value" style="color:#3B82F6">{{ $stats['livreurs'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#F3E8FF">👤</div>
            <div class="stat-label">Patients</div>
            <div class="stat-value" style="color:#8B5CF6">{{ $stats['patients'] }}</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <div class="card-dot"></div>
                Liste des comptes
            </div>
            <div class="filter-wrap">
                <form method="GET" style="display:flex;gap:8px;flex-wrap:wrap;">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="filter-input" placeholder="Rechercher…" style="width:180px;">
                    <select name="role" class="filter-select" onchange="this.form.submit()">
                        <option value="">Tous les rôles</option>
                        <option value="admin"     {{ request('role')=='admin'     ? 'selected':'' }}>Admin</option>
                        <option value="pharmacie" {{ request('role')=='pharmacie' ? 'selected':'' }}>Pharmacie</option>
                        <option value="livreur"   {{ request('role')=='livreur'   ? 'selected':'' }}>Livreur</option>
                        <option value="patient"   {{ request('role')=='patient'   ? 'selected':'' }}>Patient</option>
                    </select>
                    <button type="submit" style="background:#064E3B;color:white;border:none;border-radius:10px;padding:7px 16px;font-size:0.7rem;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;text-transform:uppercase;letter-spacing:.06em;">
                        Filtrer
                    </button>
                </form>
            </div>
        </div>

        <div style="overflow-x:auto">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Rôle</th>
                        <th>Code</th>
                        <th>Inscription</th>
                        <th style="text-align:right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    @php
                        $colors = [
                            'admin'     => ['bg'=>'#FEF3C7','color'=>'#D97706'],
                            'pharmacie' => ['bg'=>'#ECFDF5','color'=>'#059669'],
                            'livreur'   => ['bg'=>'#EFF6FF','color'=>'#3B82F6'],
                            'patient'   => ['bg'=>'#F3E8FF','color'=>'#8B5CF6'],
                        ];
                        $c = $colors[$user->role] ?? ['bg'=>'#F4F6F9','color'=>'#64748B'];
                    @endphp
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div class="user-avatar"
                                     style="background:{{ $c['bg'] }};color:{{ $c['color'] }}">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="role-badge role-{{ $user->role }}">{{ $user->role }}</span>
                        </td>
                        <td>
                            <span class="code-mono">{{ $user->custom_code ?? '—' }}</span>
                        </td>
                        <td style="font-size:0.72rem;color:#94A3B8;">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td style="text-align:right">
                            <div class="action-wrap">
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.utilisateurs.destroy', $user->id) }}"
                                      method="POST" onsubmit="return confirm('Supprimer ce compte ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-del">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row"><td colspan="5">Aucun utilisateur trouvé</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="pagination-wrap">{{ $users->links() }}</div>
        @endif
    </div>
</div>

@if(session('success'))
<div class="toast" x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,3500)" x-transition>
    <span class="toast-dot"></span>
    <span>{{ session('success') }}</span>
</div>
@endif
</x-app-layout>
