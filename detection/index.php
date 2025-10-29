<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA : DÉTECTION Pro & Vidéos de Profil</title>
    <!-- Chargement de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Police Inter pour l'esthétique -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Configuration de base et police */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7fafc; /* Gris clair */
        }
        
        /* Couleur principale (Bleu YEBANA) */
        .bg-primary { background-color: #cc0000; }
        .text-primary { color: #cc0000; }
        .border-primary { border-color: #cc0000; }

        /* Couleur d'accentuation (Vert WhatsApp) */
        .bg-whatsapp { background-color: #25D366; }
        .hover-bg-whatsapp:hover { background-color: #128C7E; }
        
        /* Section Héro avec image de fond */
        .hero-section {
            background-image: url('l-herbe-verte (2) (1) (1).jpg');
            background-size: cover;
            background-position: center;
            background-blend-mode: multiply;
            /* Filtre sombre pour que le texte blanc ressorte */
            background-color: rgba(0, 0, 0, 0.65); 
        }

        /* Effet de l'icône WhatsApp */
        .whatsapp-icon {
            transition: transform 0.3s ease;
        }

        .whatsapp-button:hover .whatsapp-icon {
            transform: scale(1.1);
        }
        
        /* Cartes des avantages */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

    </style>
</head>
<body>

    <!-- Section Héro / En-tête -->
    <header class="hero-section min-h-[60vh] md:min-h-[80vh] flex items-center justify-center p-4 md:p-8">
        <div class="text-center max-w-4xl text-white">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold mb-4 leading-tight shadow-lg">
                <span class="text-yellow-400">PASSEZ DE L'OMBRE À LA LUMIÈRE.</span>
                <br>
                JOURNÉE DE DÉTECTION YEBANA PRO
            </h1>
            <p class="text-lg md:text-2xl font-medium mb-8">
                Votre talent mérite d'être vu. Nous filmerons vos meilleures actions pour créer un  <strong> Profil Vidéo Professionnel </strong> qui impressionnera les recruteurs mondiaux.
            </p>
            
            <!-- CTA Principal -->
            <a id="mainCtaButton" href="https://wa.me/243980021950?text=Salut%2C%20je%20suis%20intéressé(e)%20par%20la%20journée%20de%20détection%20YEBANA%20PRO." target="_blank" 
               class="whatsapp-button inline-flex items-center justify-center space-x-3 
                      bg-whatsapp hover-bg-whatsapp text-white text-xl md:text-2xl font-bold 
                      py-4 px-8 rounded-full shadow-2xl transition duration-300 ease-in-out transform hover:scale-105 border-4 border-white">
                <i class="fab fa-whatsapp whatsapp-icon text-3xl"></i>
                <span>INSCRIVEZ-VOUS VIA WHATSAPP MAINTENANT !</span>
            </a>
            <p class="mt-4 text-sm font-semibold text-gray-200">Places limitées. Contactez-nous pour les détails (date, lieu et frais).</p>
        </div>
    </header>

    <!-- Section 1: Comment ça Marche -->
    <section class="py-16 md:py-24 bg-white">
        <div class="container mx-auto px-4 max-w-6xl">
            <h2 class="text-3xl md:text-4xl font-extrabold text-center mb-12 text-primary">
                Le Processus YEBANA : Révélez votre Potentiel
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                
                <!-- Étape 1 -->
                <div class="card p-6 rounded-xl shadow-lg bg-gray-50 border-t-4 border-primary">
                    <div class="text-4xl text-primary mb-4"><i class="fas fa-camera"></i></div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">1. Détection Filmée</h3>
                    <p class="text-gray-600">Jouez devant nos caméras. Chaque action clé est enregistrée par notre équipe technique professionnelle.</p>
                </div>
                
                <!-- Étape 2 -->
                <div class="card p-6 rounded-xl shadow-lg bg-gray-50 border-t-4 border-primary">
                    <div class="text-4xl text-primary mb-4"><i class="fas fa-video"></i></div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">2. Montage Vidéo Pro</h3>
                    <p class="text-gray-600">Nos monteurs sélectionnent vos meilleurs moments, ajoutent des graphiques et optimisent la vidéo de profil pour le scouting international.</p>
                </div>
                
                <!-- Étape 3 -->
                <div class="card p-6 rounded-xl shadow-lg bg-gray-50 border-t-4 border-primary">
                    <div class="text-4xl text-primary mb-4"><i class="fas fa-bullhorn"></i></div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">3. Visibilité Maximale</h3>
                    <p class="text-gray-600">Votre vidéo est intégrée à votre profil joueur YEBANA, consulté par notre réseau de recruteurs et managers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Pourquoi une Vidéo Pro est Cruciale -->
    <section class="py-16 md:py-24 bg-gray-100">
        <div class="container mx-auto px-4 max-w-6xl">
            <h2 class="text-3xl md:text-4xl font-extrabold text-center mb-12 text-gray-800">
                L'ÈRE du Scouting Numérique
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                <div class="order-2 lg:order-1 space-y-6">
                    <!-- Avantage 1 -->
                    <div class="flex items-start space-x-4 p-4 rounded-lg bg-white shadow-md">
                        <i class="fas fa-eye text-3xl text-primary mt-1"></i>
                        <div>
                            <h4 class="text-xl font-semibold text-gray-800">Le Recruteur Gagne du Temps</h4>
                            <p class="text-gray-600">Un recruteur passe 30 secondes à 1 minute sur un profil. Une vidéo de haute qualité captive et montre immédiatement votre valeur.</p>
                        </div>
                    </div>
                    
                    <!-- Avantage 2 -->
                    <div class="flex items-start space-x-4 p-4 rounded-lg bg-white shadow-md">
                        <i class="fas fa-globe-africa text-3xl text-primary mt-1"></i>
                        <div>
                            <h4 class="text-xl font-semibold text-gray-800">Accès aux Marchés Étrangers</h4>
                            <p class="text-gray-600">Les clubs européens ou asiatiques ne peuvent pas toujours se déplacer. Votre vidéo pro est votre passeport pour l'international.</p>
                        </div>
                    </div>
                    
                    <!-- Avantage 3 -->
                    <div class="flex items-start space-x-4 p-4 rounded-lg bg-white shadow-md">
                        <i class="fas fa-certificate text-3xl text-primary mt-1"></i>
                        <div>
                            <h4 class="text-xl font-semibold text-gray-800">Crédibilité Immédiate</h4>
                            <p class="text-gray-600">Des images filmées par YEBANA garantissent un standard de qualité, augmentant la crédibilité de votre candidature.</p>
                        </div>
                    </div>
                </div>
                
                <div class="order-1 lg:order-2 text-center">
                    <img src="https://placehold.co/500x350/cc0000/ffffff?text=Video+de+Profil+Pro" alt="Exemple de vidéo de profil professionnel" class="rounded-xl shadow-2xl mx-auto transform rotate-3 hover:rotate-0 transition duration-500"/>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Final (Rappel) -->
    <section class="py-12 bg-primary">
        <div class="container mx-auto px-4 max-w-4xl text-center text-white">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4">
                NE LAISSEZ PAS VOTRE TALENT SUR LE BANC DE TOUCHE.
            </h2>
            <p class="text-xl mb-8">
                Les places pour la prochaine session de détection sont limitées. Assurez votre chance dès aujourd'hui.
            </p>
            
            <a href="https://wa.me/243980021950?text=Salut%2C%20je%20suis%20intéressé(e)%20par%20la%20journée%20de%20détection%20YEBANA%20PRO." target="_blank" 
               class="whatsapp-button inline-flex items-center justify-center space-x-3 
                      bg-whatsapp hover-bg-whatsapp text-white text-xl md:text-2xl font-bold 
                      py-4 px-10 rounded-full shadow-2xl transition duration-300 ease-in-out transform hover:scale-105 border-4 border-white">
                <i class="fab fa-whatsapp whatsapp-icon text-3xl"></i>
                <span>JE M'INSCRIS MAINTENANT</span>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-center p-6 text-gray-400">
        <div class="container mx-auto">
            <p>&copy; 2025 YEBANA Sport. Tous droits réservés.</p>
        </div>
    </footer>

    <script>
        
    </script>
</body>
</html>
