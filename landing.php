<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA Sport - Téléchargez l'App Mobile</title>
    
    <!-- Chargement de Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* -------------------------------------- */
        /* 1. VARIABLES ET RESET DE BASE          */
        /* -------------------------------------- */
        :root {
            --yebana-blue: #cc0000;
            --yebana-green: #28a745;
            --yebana-dark: #16171aff;
            --yebana-light: #f8f9fa;
            --white: #ffffff;
            --gray-text: #6b7280;
            --max-width: 1280px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--yebana-light);
            color: var(--yebana-dark);
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            max-width: var(--max-width);
            margin: 0 auto;
            padding-left: 1.5rem; /* px-6 */
            padding-right: 1.5rem; /* px-6 */
        }

        /* -------------------------------------- */
        /* 2. SECTION HÉROS                       */
        /* -------------------------------------- */
        .hero-section {
            background-image: linear-gradient( #cc0000, #0056b3), url('images/freepik__the-style-is-candid-image-photography-with-natural__97651.jpeg');
            background-size: cover;
            background-position: center;
            color: var(--white);
            padding-top: 6rem; /* pt-24 */
            padding-bottom: 8rem; /* pb-32 */
            border-bottom-left-radius: 3rem; /* rounded-b-3xl */
            border-bottom-right-radius: 3rem; /* rounded-b-3xl */
            text-align: center;
        }

        .hero-section h1 {
            font-size: 2.25rem; /* text-4xl */
            font-weight: 800; /* font-extrabold */
            margin-bottom: 1rem; /* mb-4 */
            line-height: 1.25; /* leading-tight */
        }

        .hero-section p {
            font-size: 1.25rem; /* text-xl */
            font-weight: 300; /* font-light */
            margin-bottom: 2.5rem; /* mb-10 */
            max-width: 56rem; /* max-w-3xl */
            margin-left: auto;
            margin-right: auto;
            opacity: 0.9;
        }
        
        /* Media query pour le titre sur les grands écrans */
        @media (min-width: 640px) { /* sm: */
            .hero-section h1 {
                font-size: 3.75rem; /* sm:text-6xl */
            }
            .hero-section p {
                font-size: 1.5rem; /* sm:text-2xl */
            }
        }

        /* -------------------------------------- */
        /* 3. BOUTONS D'ACTION (CTA)              */
        /* -------------------------------------- */
        .cta-buttons {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 1rem; /* space-y-4 */
        }

        @media (min-width: 640px) { /* sm: */
            .cta-buttons {
                flex-direction: row;
                gap: 0;
                column-gap: 1.5rem; /* sm:space-x-6 */
            }
        }

        .cta-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem 2rem; /* py-4 px-8 */
            border-radius: 9999px; /* rounded-full */
            font-weight: 700; /* font-bold */
            font-size: 1.125rem; /* text-xl */
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-lg */
            width: 100%; /* w-full */
            max-width: 300px;
        }

        @media (min-width: 640px) { /* sm: */
            .cta-btn {
                width: auto; /* sm:w-auto */
            }
        }

        .cta-btn i {
            font-size: 1.5rem; /* text-2xl */
            margin-right: 0.75rem; /* space-x-3 */
        }
        
        .cta-primary {
            background-color: var(--yebana-green);
            color: var(--white);
        }

        .cta-primary:hover {
            background-color: #218838; /* green-700 */
            transform: scale(1.05);
        }

        .cta-disabled {
            background-color: #6c757d; /* gray-500 */
            color: var(--white);
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        /* Flèche animée */
        .down-arrow {
            font-size: 2.25rem; /* text-4xl */
            margin-top: 4rem; /* mt-16 */
            color: var(--yebana-green);
            animation: bounce-down 2s infinite;
            display: block;
        }
        
        @keyframes bounce-down {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        /* -------------------------------------- */
        /* 4. SECTION CARACTÉRISTIQUES            */
        /* -------------------------------------- */
        .features-section {
            padding-top: 5rem; /* py-20 */
            padding-bottom: 5rem; /* py-20 */
        }

        .features-section h2 {
            font-size: 2rem; /* text-3xl */
            font-weight: 800; /* font-extrabold */
            text-align: center;
            margin-bottom: 4rem; /* mb-16 */
        }
        
        @media (min-width: 640px) { /* sm: */
            .features-section h2 {
                font-size: 2.25rem; /* sm:text-4xl */
            }
        }

        .feature-grid {
            display: grid;
            gap: 2.5rem; /* gap-10 */
        }
        
        @media (min-width: 768px) { /* md: */
            .feature-grid {
                grid-template-columns: repeat(3, 1fr); /* md:grid-cols-3 */
            }
        }

        .feature-card {
            background-color: var(--white);
            padding: 2rem; /* p-8 */
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-xl */
            text-align: center;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); /* shadow-2xl */
            transform: scale(1.02);
        }

        .feature-icon {
            color: var(--yebana-blue);
            font-size: 3rem; /* text-5xl */
            margin-bottom: 1rem; /* mb-4 */
        }

        .feature-card h3 {
            font-size: 1.25rem; /* text-xl */
            font-weight: 700; /* font-bold */
            margin-bottom: 0.75rem; /* mb-3 */
            color: var(--yebana-dark);
        }

        .feature-card p {
            color: var(--gray-text);
        }
        
        /* -------------------------------------- */
        /* 5. SECTION CTA FINALE AVEC IMAGE       */
        /* -------------------------------------- */
        .final-cta-section {
            background-color: var(--yebana-blue);
            color: var(--white);
            padding-top: 5rem; /* py-20 */
            padding-bottom: 5rem; /* py-20 */
            border-top-left-radius: 3rem; /* rounded-t-3xl */
            border-top-right-radius: 3rem; /* rounded-t-3xl */
            margin-top: -10px; /* Petit ajustement pour masquer le débordement du footer */
        }
        
        .final-cta-content {
            display: grid;
            gap: 3rem; /* gap-12 */
            align-items: center;
        }

        @media (min-width: 768px) { /* md: */
            .final-cta-content {
                grid-template-columns: repeat(2, 1fr); /* md:grid-cols-2 */
            }
        }
        
        .cta-text-block {
            text-align: center;
        }
        
        @media (min-width: 768px) {
            .cta-text-block {
                order: 1; /* md:order-1 */
                text-align: left; /* md:text-left */
            }
        }

        .cta-text-block h2 {
            font-size: 2rem; /* text-3xl */
            font-weight: 800; /* font-extrabold */
            margin-bottom: 1rem; /* mb-4 */
        }

        @media (min-width: 640px) { /* sm: */
            .cta-text-block h2 {
                font-size: 2.25rem; /* sm:text-4xl */
            }
        }
        
        .cta-text-block p {
            font-size: 1.125rem; /* text-lg */
            margin-bottom: 2rem; /* mb-8 */
            opacity: 0.9;
        }
        
        /* Image Maquette */
        .mockup-block {
            display: flex;
            justify-content: center;
            /* Pas besoin de perspective ici, mais on simule le md:order-2 */
        }
        
        @media (min-width: 768px) {
            .mockup-block {
                order: 2; /* md:order-2 */
            }
        }

        .app-screenshot {
            width: 16rem; /* w-64 */
            height: auto;
            border-radius: 1.5rem; /* rounded-3xl */
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4); /* shadow-2xl for depth */
            transition: transform 0.5s ease-in-out;
            /* Petite perspective 3D pour l'effet - nécessite un conteneur parent pour 'perspective' */
            transform: rotateY(10deg) rotateX(2deg) scale(1.0); 
        }

        /* -------------------------------------- */
        /* 6. PIED DE PAGE (FOOTER)               */
        /* -------------------------------------- */
        .app-footer {
            background-color: var(--yebana-dark);
            color: var(--white);
            padding: 1.5rem; /* p-6 */
            text-align: center;
            font-size: 0.875rem; /* text-sm */
            border-top-left-radius: 3rem;
            border-top-right-radius: 3rem;
        }

        .footer-links {
            margin-top: 0.5rem; /* mt-2 */
        }

        .footer-links a {
            margin: 0 0.5rem;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--yebana-blue);
        }

        .footer-links span {
            opacity: 0.5;
        }

    </style>
</head>

<body>

    <!-- Section Héros (Introduction et Appel à l'Action) -->
    <header class="hero-section">
        <div class="container">
            <h1>
                YEBANA Sport<br class="hidden-sm"> Le Football entre vos mains.
            </h1>
            <p>
                Ne manquez rien de l'actualité, des vidéos, et du profil de vos joueurs préférés.
            </p>

            <!-- Boutons de Téléchargement -->
            <div class="cta-buttons">
                
                <!-- Bouton Android (Mise en évidence) -->
                <a href="#" id="downloadBtn" class="cta-btn cta-primary">
                    <i class="fab fa-google-play"></i>
                    <span>Télécharger maintenant</span>
                </a>

                <!-- Bouton iOS (Grisé) -->
                <button disabled class="cta-btn cta-disabled">
                    <i class="fab fa-apple"></i>
                    <span>Disponible bientôt sur l'App Store</span>
                </button>
            </div>
            <p id="status"></p>
            
            <i class="fas fa-arrow-down down-arrow"></i>
        </div>
    </header>

    <!-- Section Caractéristiques -->
    <section class="features-section">
        <div class="container">
            <h2>
                Pourquoi YEBANA est l'App Qu'il Vous Faut
            </h2>
            
            <div class="feature-grid">
                <!-- Caractéristique 1: Fil d'Actualités en Temps Réel -->
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-bullhorn"></i></div>
                    <h3>Fil d'Actualités</h3>
                    <p>Suivez les publications, photos et vidéos de vos joueurs et clubs favoris en direct. Ne ratez aucun moment clé.</p>
                </div>
                
                <!-- Caractéristique 2: Profils Détaillés -->
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-user-circle"></i></div>
                    <h3>Profils Joueurs</h3>
                    <p>Accédez aux statistiques, historique, et médias de chaque joueur. Le tout mis à jour par les athlètes eux-mêmes.</p>
                </div>

                <!-- Caractéristique 3: Contenu Exclusif -->
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-video"></i></div>
                    <h3>Vidéos & Photos</h3>
                    <p>Publiez vos propres vidéos de matchs ou d'entraînements et parcourez les galeries des autres membres.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section CTA avec Image de l'App -->
    <section class="final-cta-section">
        <div class="container final-cta-content">
            
            <!-- Bloc Texte CTA -->
            <div class="cta-text-block">
                <h2>
                    Installez YEBANA et rejoignez le jeu !
                </h2>
                <p>
                    Notre application est optimisée pour vous offrir la meilleure expérience possible sur Android. Téléchargez-la maintenant et accédez à tout le contenu sportif immédiatement.
                </p>
                
                <!-- Bouton de Téléchargement Final -->
                <a href="images/YebanaSport_1_1.0.apk" target="_blank" class="cta-btn cta-primary" style="max-width: 350px;">
                    <i class="fab fa-google-play"></i>
                    <span>Télécharger l'App Android</span>
                </a>
            </div>
            
            <!-- Bloc Maquette de Téléphone (simulé) -->
            <div class="mockup-block">
                <img src="images/1080 1920.png" alt="Aperçu de l'application YEBANA Sport sur mobile" class="app-screenshot">
            </div>

        </div>
    </section>

    <script>
        const APK_URL = 'images/YebanaSport_1_1.0.apk'; // <-- remplacer par ton URL
        const FILENAME = 'YebanaSport_1_1.0.apk';

        const status = document.getElementById('status');
        document.getElementById('downloadBtn').addEventListener('click', async () => {
        try {
            status.textContent = 'Préparation du téléchargement…';
            const res = await fetch(APK_URL, { method: 'GET' });

            if (!res.ok) throw new Error('Erreur de téléchargement : ' + res.status);

            const blob = await res.blob();

            // Créer un lien temporaire pour déclencher le téléchargement
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = FILENAME;
            document.body.appendChild(a);
            a.click();

            // nettoyage
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
            status.textContent = 'Téléchargement démarré. Vérifiez vos notifications.';
        } catch (err) {
            console.error(err);
            status.textContent = 'Erreur : ' + err.message;
        }
        });
    </script>

</body>
</html>
