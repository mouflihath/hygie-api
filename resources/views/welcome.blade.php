<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hygie+ | L'excellence en logistique santé</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #059669;
            --primary-dark: #064E3B;
            --glass: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            background-color: #ffffff;
        }

        /* NAVBAR TRANSPARENTE CHIC */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1.5rem 4rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        nav.scrolled {
            padding: 1rem 4rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        }

        .logo-text {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -1px;
            color: white;
            transition: color 0.3s;
        }

        nav.scrolled .logo-text { color: var(--primary-dark); }

        .nav-btn {
            padding: 12px 28px;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .btn-login {
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        nav.scrolled .btn-login {
            color: var(--primary);
            border-color: var(--primary);
            background: transparent;
        }

        /* HERO SECTION */
        .hero-section {
            position: relative;
            height: 100vh; /* Plein écran pour l'effet Wow */
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .video-container {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .video-container::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.7));
            z-index: 2;
        }

        .hero-video {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 1.5s ease;
        }

        .hero-video.active { opacity: 1; }

        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            color: white;
            padding: 0 20px;
        }

        .hero-content h1 {
            font-size: clamp(3rem, 8vw, 5rem);
            font-weight: 800;
            line-height: 1;
            margin-bottom: 1.5rem;
            letter-spacing: -2px;
        }

        .hero-content p {
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto 3rem;
            opacity: 0.8;
            font-weight: 300;
        }

        /* CARTES DE RÔLES */
        .role-selector {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .btn-role {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 30px 40px;
            border-radius: 30px;
            color: white;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            width: 240px;
        }

        .btn-role:hover {
            background: white;
            color: var(--primary-dark);
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .btn-role span:first-child {
            font-size: 3.5rem;
            display: block;
            margin-bottom: 15px;
        }

        .btn-role b {
            font-size: 0.9rem;
            letter-spacing: 2px;
            font-weight: 800;
        }

        /* SECTION ARGUMENTS */
        .features {
            padding: 120px 5%;
            background: #ffffff;
        }

        .feature-card {
            padding: 50px;
            border-radius: 40px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            transition: all 0.3s;
        }

        .feature-card:hover {
            background: #ffffff;
            box-shadow: 0 30px 60px rgba(0,0,0,0.05);
            border-color: var(--primary);
        }

        @media (max-width: 768px) {
            nav { padding: 1rem 1.5rem; }
            .role-selector { flex-direction: column; align-items: center; }
        }
    </style>
</head>
<body>

    <nav id="navbar">

            <span class="logo-text uppercase italic ">Hygie+</span>

        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="nav-btn btn-login">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-btn btn-login">Se Connecter</a>
                @endauth
            @endif
        </div>
    </nav>

    <div class="hero-section">
        <div class="video-container">
            <video class="hero-video active" autoplay muted playsinline id="video1">
                <source src="{{ asset('videos/hero1.mp4') }}" type="video/mp4">
            </video>
            <video class="hero-video" muted playsinline id="video2">
                <source src="{{ asset('videos/hero2.mp4') }}" type="video/mp4">
            </video>
            <video class="hero-video" muted playsinline id="video3">
                <source src="{{ asset('videos/hero3.mp4') }}" type="video/mp4">
            </video>
        </div>

        <div class="hero-content">
           <h1>Bienvenue dans l'écosystème <br><span style="color: var(--primary);">Hygie+</span></h1>
<p>Fluidifier le dernier kilomètre pharmaceutique grâce à une mise en relation haute performance.</p>

        </div>
    </div>

    <div class="features">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 80px;">
                <h2 style="font-size: 3rem; font-weight: 800; color: var(--primary-dark); letter-spacing: -1.5px;">Une expertise au service du patient</h2>
                <div style="width: 60px; height: 6px; background: var(--primary); margin: 20px auto; border-radius: 10px;"></div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px;">
    <div class="feature-card">
        <div style="font-size: 2.5rem; margin-bottom: 20px;">⚡</div>
        <h3 style="font-weight: 800; font-size: 1.5rem; margin-bottom: 15px;">Réactivité Opérationnelle</h3>
        <p style="color: #64748b; line-height: 1.7;">
            Algorithme d'appairage intelligent minimisant le temps d'attente entre la préparation de commande et la prise en charge.
        </p>
    </div>

    <div class="feature-card">
        <div style="font-size: 2.5rem; margin-bottom: 20px;">🛡️</div>
        <h3 style="font-weight: 800; font-size: 1.5rem; margin-bottom: 15px;">Sécurité & Conformité</h3>
        <p style="color: #64748b; line-height: 1.7;">
            Garantie de l'intégrité des produits thermosensibles et respect strict des bonnes pratiques de distribution (BPD).
        </p>
    </div>

    <div class="feature-card">
        <div style="font-size: 2.5rem; margin-bottom: 20px;">📈</div>
        <h3 style="font-weight: 800; font-size: 1.5rem; margin-bottom: 15px;">Traçabilité de Bout en Bout</h3>
        <p style="color: #64748b; line-height: 1.7;">
            Suivi géolocalisé en temps réel et horodatage certifié de chaque étape, du retrait en officine jusqu'à la remise au patient.
        </p>
    </div>
</div>

        </div>
    </div>

    <script>
        // GESTION DU SCROLL NAVBAR
        const navbar = document.getElementById('navbar');
        window.onscroll = () => {
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        };

        // CARROUSSEL VIDEO
        const videos = document.querySelectorAll('.hero-video');
        let current = 0;

        function nextVideo() {
            videos[current].classList.remove('active');
            videos[current].pause();

            current = (current + 1) % videos.length;

            videos[current].classList.add('active');
            videos[current].currentTime = 0;
            videos[current].play();
        }

        videos.forEach(v => {
            v.onended = nextVideo;
            v.addEventListener('error', nextVideo); // Sécurité si une vidéo manque
        });

        // Lancement initial sécurisé
        window.addEventListener('load', () => {
            videos[0].play().catch(() => {
                console.log("Interaction utilisateur requise pour l'autoplay");
            });
        });
    </script>
</body>
</html>
