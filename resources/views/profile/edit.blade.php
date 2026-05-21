<x-app-layout>
<div style="padding:40px 48px;max-width:800px;">

    {{-- En-tête --}}
    <div style="margin-bottom:32px;">
        <h2 style="font-size:1.5rem;font-weight:700;color:#0A1628;letter-spacing:-.5px;margin:0 0 4px;">Mon Profil</h2>
        <p style="font-size:.8rem;color:#94A3B8;font-weight:500;margin:0;">Gérez vos informations personnelles et votre mot de passe</p>
    </div>

    {{-- ── CARTE : Informations + Photo ───────────────────────────── --}}
    <div style="background:white;border-radius:22px;border:1px solid #EEF1F7;overflow:hidden;margin-bottom:24px;box-shadow:0 2px 12px rgba(0,0,0,.04);">
        <div style="padding:22px 28px;border-bottom:1px solid #F1F5F9;display:flex;align-items:center;gap:8px;">
            <div style="width:8px;height:8px;border-radius:50%;background:#059669;"></div>
            <span style="font-size:.85rem;font-weight:700;color:#0A1628;">Informations du profil</span>
        </div>
        <div style="padding:28px;">

            <form method="post" action="{{ route('profile.update') }}"
                  enctype="multipart/form-data"
                  id="form-send-verification">
                @csrf
                @method('patch')

                {{-- Photo de profil --}}
                <div style="display:flex;align-items:center;gap:24px;margin-bottom:28px;padding-bottom:28px;border-bottom:1px solid #F1F5F9;">

                    {{-- Aperçu --}}
                    <div style="position:relative;flex-shrink:0;">
                        @if(Auth::user()->photo_profil)
                            <img id="avatar-preview"
                                 src="{{ Storage::url(Auth::user()->photo_profil) }}"
                                 alt="{{ Auth::user()->name }}"
                                 style="width:80px;height:80px;border-radius:18px;object-fit:cover;border:3px solid white;box-shadow:0 4px 16px rgba(0,0,0,.12);">
                        @else
                            <div id="avatar-initiale"
                                 style="width:80px;height:80px;border-radius:18px;background:#064E3B;color:white;display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:700;font-family:'DM Mono',monospace;box-shadow:0 4px 16px rgba(6,78,59,.25);">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <img id="avatar-preview" src="" alt=""
                                 style="width:80px;height:80px;border-radius:18px;object-fit:cover;border:3px solid white;box-shadow:0 4px 16px rgba(0,0,0,.12);display:none;">
                        @endif
                    </div>

                    {{-- Actions photo --}}
                    <div>
                        <p style="font-size:.82rem;font-weight:700;color:#0A1628;margin:0 0 6px;">Photo de profil</p>
                        <p style="font-size:.72rem;color:#94A3B8;margin:0 0 12px;">JPG, PNG ou WEBP · max 2 Mo</p>
                        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                            <label for="photo_profil"
                                   style="cursor:pointer;display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:10px;border:1px solid #E2E8F0;background:white;font-size:.75rem;font-weight:700;color:#374151;transition:.15s;box-shadow:0 1px 4px rgba(0,0,0,.06);">
                                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Changer la photo
                            </label>
                            <input id="photo_profil" name="photo_profil" type="file"
                                   accept="image/jpeg,image/png,image/webp"
                                   style="display:none;"
                                   onchange="previewAvatar(this)">

                            @if(Auth::user()->photo_profil)
                            <label style="display:inline-flex;align-items:center;gap:6px;font-size:.72rem;color:#EF4444;cursor:pointer;font-weight:600;">
                                <input type="checkbox" name="supprimer_photo" value="1"
                                       style="border-radius:4px;accent-color:#EF4444;">
                                Supprimer
                            </label>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Nom --}}
                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:.72rem;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;">
                        Nom
                    </label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', Auth::user()->name) }}"
                           required autofocus
                           style="width:100%;padding:10px 14px;border:1px solid #E2E8F0;border-radius:10px;font-size:.85rem;font-family:'DM Sans',sans-serif;color:#0A1628;outline:none;transition:.15s;"
                           onfocus="this.style.borderColor='#059669';this.style.boxShadow='0 0 0 3px rgba(5,150,105,.1)'"
                           onblur="this.style.borderColor='#E2E8F0';this.style.boxShadow='none'">
                    @error('name')<p style="font-size:.72rem;color:#EF4444;margin-top:4px;">{{ $message }}</p>@enderror
                </div>

                {{-- Email --}}
                <div style="margin-bottom:24px;">
                    <label style="display:block;font-size:.72rem;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.06em;margin-bottom:6px;">
                        Email
                    </label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email', Auth::user()->email) }}"
                           required
                           style="width:100%;padding:10px 14px;border:1px solid #E2E8F0;border-radius:10px;font-size:.85rem;font-family:'DM Sans',sans-serif;color:#0A1628;outline:none;transition:.15s;"
                           onfocus="this.style.borderColor='#059669';this.style.boxShadow='0 0 0 3px rgba(5,150,105,.1)'"
                           onblur="this.style.borderColor='#E2E8F0';this.style.boxShadow='none'">
                    @error('email')<p style="font-size:.72rem;color:#EF4444;margin-top:4px;">{{ $message }}</p>@enderror
                </div>

                {{-- Bouton --}}
                <div style="display:flex;align-items:center;gap:16px;">
                    <button type="submit"
                            style="padding:10px 24px;background:#064E3B;color:white;border:none;border-radius:10px;font-size:.82rem;font-weight:700;font-family:'DM Sans',sans-serif;cursor:pointer;transition:.15s;box-shadow:0 4px 14px rgba(6,78,59,.25);"
                            onmouseover="this.style.background='#065f46'"
                            onmouseout="this.style.background='#064E3B'">
                        Enregistrer les modifications
                    </button>

                    @if(session('status') === 'profile-updated')
                    <span x-data="{ show: true }"
                          x-show="show"
                          x-transition
                          x-init="setTimeout(() => show = false, 2500)"
                          style="font-size:.75rem;color:#059669;font-weight:700;display:flex;align-items:center;gap:4px;">
                        ✓ Modifications enregistrées
                    </span>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- ── CARTE : Mot de passe ─────────────────────────────────────── --}}
    <div style="background:white;border-radius:22px;border:1px solid #EEF1F7;overflow:hidden;margin-bottom:24px;box-shadow:0 2px 12px rgba(0,0,0,.04);">
        <div style="padding:22px 28px;border-bottom:1px solid #F1F5F9;display:flex;align-items:center;gap:8px;">
            <div style="width:8px;height:8px;border-radius:50%;background:#3B82F6;"></div>
            <span style="font-size:.85rem;font-weight:700;color:#0A1628;">Mot de passe</span>
        </div>
        <div style="padding:28px;">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- ── CARTE : Supprimer le compte ─────────────────────────────── --}}
    <div style="background:white;border-radius:22px;border:1px solid #FEE2E2;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.04);">
        <div style="padding:22px 28px;border-bottom:1px solid #FEE2E2;display:flex;align-items:center;gap:8px;">
            <div style="width:8px;height:8px;border-radius:50%;background:#EF4444;"></div>
            <span style="font-size:.85rem;font-weight:700;color:#EF4444;">Zone dangereuse</span>
        </div>
        <div style="padding:28px;">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>

<script>
function previewAvatar(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        const preview  = document.getElementById('avatar-preview');
        const initiale = document.getElementById('avatar-initiale');
        if (preview) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        if (initiale) initiale.style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
</x-app-layout>
