<?php
include('db.php');

if(isset($_POST['send_form'])){
     if(isset($_POST['name'],$_POST['email'],$_POST['message'])){
          $name = htmlspecialchars($_POST['name']);
          $mail = htmlspecialchars($_POST['email']);
          $message = htmlspecialchars($_POST['message']);

          $sauvegarde_message = $db->prepare('INSERT INTO `contact`(`nom_complet`, `mail`, `message`, `reference`) VALUES ( ?, ?, ?, ?)');
          $sauvegarde_message->execute(array($name,$mail,$message,uniqid())); 

          $sauvegarde_message->closeCursor();
          
          header('location:index.php');
     }
}

$recuperation_infos_joueurs = $db->prepare('SELECT * FROM `jouers` ORDER BY RAND()');
$recuperation_infos_joueurs->execute(array());
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yebana - Le Réseau Football Africain</title>
    <!-- Lien vers Font Awesome pour les icônes -->
     <link rel="shortcut icon" href="images/2000 2000.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables de couleur et styles de base) -->
    <link rel="stylesheet" href="style.css">
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour la nav et le header) -->
    <link rel="stylesheet" href="soccer/soccer.css">
    <link rel="stylesheet" href="ultrasmall.css">

    <!-- Inline styles specific to the showcase page -->
    <style>
        /* ==================================== */
        /* Styles spécifiques pour la page Vitrine Publique (Showcase) */
        /* ==================================== */

        /* Override body styles from global CSS for this specific page */
        body {
            /* Keep font-family and color from global styles or redefine if needed */
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text-color);
            margin: 0;
            /* Adjust padding to account for fixed header and bottom nav */
            padding-top: var(--header-height); /* Space for the fixed header */
            padding-bottom: var(--bottom-nav-height); /* Space for the fixed bottom nav */
            background-color: var(--dashboard-bg); /* Use a consistent light background */
            display: flex; /* Keep flexbox for main content */
            flex-direction: column; /* Stack content vertically */
            min-height: 100vh; /* Ensure body takes full viewport height */
            box-sizing: border-box; /* Include padding in height calculation */
            overflow-x: hidden; /* Prevent horizontal scroll */
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
            color: var(--white-color);
            /* Adjust padding-top as it now sits below the fixed header */
            padding: 50px 20px 80px 20px; /* Reduced top padding, kept bottom padding for hero content */
            text-align: center;
            position: relative;
            overflow: hidden; /* For background patterns/animations if added */
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            margin-bottom: 40px;
            /* Ensure hero section also stretches full width */
            width: 100%;
            box-sizing: border-box; /* Include padding in width */
        }

        .hero-section h1 {
            font-size: 3.5em;
            margin-bottom: 15px;
            line-height: 1.2;
            font-weight: 700;
        }

        .hero-section p {
            font-size: 1.4em;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            color: #ffcc33; 
        }

        .hero-section .hero-btn {
            background-color: var(--secondary-color);
            color: var(--white-color);
            padding: 15px 35px;
            border: none;
            border-radius: 30px;
            font-size: 1.3em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }

        .hero-section .hero-btn i {
            margin-right: 10px;
            font-size: 1.1em;
        }

        .hero-section .hero-btn:hover {
            background-color: #ffcc33;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.6);
        }

        .main-content-showcase {
            flex-grow: 1; /* Allows this content to expand and push footer down */
            /* Removed max-width to allow content to span full available width */
            width: 100%; /* Ensure it takes full width */
            margin: 0 auto;
            padding: 0 20px 50px 20px; /* Padding bottom for footer space */
            box-sizing: border-box;
        }

        .section-title {
            font-size: 2.5em;
            color: var(--dark-text-color);
            text-align: center;
            margin-bottom: 40px;
            font-weight: 700;
            position: relative;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background-color: var(--primary-color);
            margin: 15px auto 0 auto;
            border-radius: 2px;
        }

        /* Talent grid - Reusing explore-card styles, but with some overrides */
        .showcase-grid {
            display: grid;
            /* Adjusted grid-template-columns for more profiles on large screens (approx. 5) */
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 30px; /* Slightly less space between cards for density */
            margin-bottom: 50px;
        }

        .showcase-card {
            background-color: var(--white-color);
            border-radius: 15px; /* More rounded corners */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12); /* More prominent shadow */
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .showcase-card:hover {
            transform: translateY(-7px); /* More pronounced lift */
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2); /* Stronger shadow on hover */
        }

        .showcase-card .card-image-container {
            width: 100%;
            height: 150px; /* Reduced height for smaller cards */
            overflow: hidden;
            border-bottom: 1px solid var(--border-color);
        }

        .showcase-card .card-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease; /* Zoom effect on hover */
        }
        .showcase-card:hover .card-image-container img {
            transform: scale(1.05); /* Zoom in effect */
        }

        .showcase-card .card-content {
            padding: 18px; /* Reduced padding for smaller cards */
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between; /* Push button down */
        }

        .showcase-card h3 {
            margin: 0 0 10px 0;
            font-size: 1.4em; /* Slightly smaller name for compact card */
            color: var(--dark-text-color);
            font-weight: 700;
        }

        /* Reusing player-details structure */
        .showcase-card .player-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px; /* Tighter gap for more info */
            margin-bottom: 15px; /* Reduced margin */
            font-size: 0.85em; /* Slightly smaller for detail items */
            color: var(--medium-text-color);
        }

        .showcase-card .detail-item {
            display: flex;
            align-items: center;
            background-color: var(--light-bg-color);
            padding: 3px 8px; /* Reduced padding */
            border-radius: 20px;
            border: 1px solid var(--border-color);
            white-space: nowrap; /* Prevent wrapping for detail items */
        }

        .showcase-card .detail-item i {
            margin-right: 5px;
            color: var(--primary-color);
            font-size: 0.8em;
        }
        
        .showcase-card .btn-view-profile {
            background-color: var(--primary-color);
            color: var(--white-color);
            padding: 10px 20px; /* Reduced padding */
            border: none;
            border-radius: 25px;
            font-size: 1em; /* Slightly smaller font */
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%; /* Full width within card padding */
            box-shadow: 0 4px 12px var(--primary-shadow-color);
        }

        .showcase-card .btn-view-profile i {
            margin-right: 8px; /* Slightly smaller margin */
        }

        .showcase-card .btn-view-profile:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px var(--primary-shadow-color);
        }

        .cta-section {
            background: linear-gradient(135deg, var(--secondary-color), #218838);
            color: var(--white-color);
            padding: 50px 20px;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            margin-bottom: 50px;
            /* Ensure CTA section also stretches full width */
            width: 100%;
            box-sizing: border-box; /* Include padding in width */
        }

        .cta-section h2 {
            font-size: 2.8em;
            margin-bottom: 15px;
            font-weight: 700;
            color: var(--white-color);
        }

        .cta-section p {
            font-size: 1.2em;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            color: rgba(255, 255, 255, 0.9);
        }

        .cta-section .cta-btn {
            background-color: var(--white-color);
            color: var(--secondary-color);
            padding: 15px 40px;
            border: none;
            border-radius: 30px;
            font-size: 1.3em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .cta-section .cta-btn i {
            margin-left: 10px; /* Icon on the right */
            font-size: 1.1em;
        }
        .cta-section .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            color: #1e7e34;
        }

        .app-footer {
            background-color: var(--dark-text-color);
            color: var(--white-color);
            padding: 40px 20px;
            text-align: center;
            font-size: 0.9em;
            margin-top: auto; /* Push footer to the bottom */
            /* Ensure footer also stretches full width */
            width: 100%;
            box-sizing: border-box; /* Include padding in width */
        }

        .app-footer .footer-links a {
            color: var(--white-color);
            text-decoration: none;
            margin: 0 15px;
            transition: color 0.3s ease;
        }
        .app-footer .footer-links a:hover {
            color: var(--primary-color);
        }

        .app-footer p {
            margin-top: 20px;
            color: rgba(255, 255, 255, 0.7);
        }


        /* Media queries for responsiveness */
        @media (max-width: 900px) {
            .hero-section h1 {
                font-size: 3em;
            }
            .hero-section p {
                font-size: 1.2em;
            }
            .section-title {
                font-size: 2em;
            }
            .showcase-grid {
                /* Allows 4 profiles per line on medium screens */
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 15px; /* Adjusted gap for medium screens */
            }
            .showcase-card .card-image-container {
                height: 140px; /* Adjusted height for medium screens */
            }
            .showcase-card .card-content {
                padding: 15px; /* Adjusted padding for medium screens */
            }
            .showcase-card h3 {
                font-size: 1.3em;
            }
            .showcase-card .player-details {
                font-size: 0.8em;
            }
            .showcase-card .detail-item {
                padding: 3px 7px; /* Adjusted padding */
            }
            .showcase-card .btn-view-profile {
                font-size: 0.95em;
                padding: 8px 15px;
            }
            .cta-section h2 {
                font-size: 2.2em;
            }
            .cta-section p {
                font-size: 1.1em;
            }
        }

        @media (max-width: 600px) {
            .hero-section {
                padding: 40px 15px 60px 15px; /* Adjust padding for mobile and fixed header */
                border-bottom-left-radius: 20px;
                border-bottom-right-radius: 20px;
                margin-bottom: 30px;
            }
            .hero-section h1 {
                font-size: 2.5em;
            }
            .hero-section p {
                font-size: 1em;
            }
            .hero-section .hero-btn {
                font-size: 1.1em;
                padding: 12px 25px;
            }
            .main-content-showcase {
                padding: 0 15px 30px 15px;
            }
            .section-title {
                font-size: 1.8em;
                margin-bottom: 30px;
            }
            .showcase-grid {
                /* Allows 2 profiles per line on small screens */
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
                gap: 15px; /* Adjusted gap for small screens */
            }
            .showcase-card .card-image-container {
                height: 120px; /* Keep a decent height for single column */
            }
            .showcase-card .card-content {
                padding: 12px;
            }
            .showcase-card h3 {
                font-size: 1.2em;
            }
            .showcase-card .player-details {
                font-size: 0.75em;
                gap: 5px;
            }
            .showcase-card .detail-item {
                padding: 2px 6px;
            }
            .showcase-card .btn-view-profile {
                font-size: 0.9em;
                padding: 8px 15px;
            }
            .cta-section {
                padding: 40px 15px;
                margin-bottom: 30px;
            }
            .cta-section h2 {
                font-size: 1em;
            }
            .cta-section p {
                font-size: 0.5em;
            }
            .cta-section .cta-btn {
                font-size: 1.1em;
                padding: 12px 25px;
            }
            .app-footer {
                padding: 30px 15px;
            }
            .app-footer .footer-links a {
                display: block; /* Stack links vertically */
                margin: 5px 0;
            }
        }
        @media (max-width: 400px) {
            body {
                padding: 10px;
            }
            .container {
                margin: 0;
                padding: 15px;
                border-radius: 10px;
            }

            .logo i { 
                font-size: 2.5em;
            }
            .logo h1 {
                font-size: 1em;
            }

            p {
                font-size: 0.5em;
            }

            a {
                font-size: 0.5em;
            }

            .nav-item span{
                display: none;
            }
            .nav-item i{
                font-size: 20px;
            }
            .header-logo span{
                display: inline;
            }
            .header-user span{
                font-size: 15px;
            }
            .hero-section h1{
                font-size: 30px;
                padding-top: 50px;
            }
            .hero-section a{
                font-size: 16px;
            }
        }
        @media (max-width: 300px) {
            .hero-section a{
                font-size: 10px;
                padding: 2px;
            }
        }

    </style>
</head>
<body>
    <!-- App Header - Uses global header styles from soccer.css -->
    <header class="app-header">
        <div class="header-content">
            <div class="header-logo">
                <i class="fas fa-futbol"></i>
                <span> Yebana</span>
            </div>
            <div class="header-user">
                <!-- Links for public actions -->
                <a href="live/" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                    <i class="fas fa-satellite-dish"></i>
                    <span>Web TV</span>
                </a>
            </div>
        </div>
    </header>

    <div class="hero-section">
        <h1>Découvrez les Talents Émergents du Football Africain</h1>
        <p>Yebana SPORT connecte les jeunes prodiges avec les clubs, managers et recruteurs du monde entier.</p>
        <a href="landing.php" class="hero-btn">
            <i class="fab fa-google-play"></i> Telecharger
        </a>
        <a href="login.php" class="hero-btn" style="background-color: #f5b70e;">
            <i class="fas fa-sign-in-alt"></i> Connexion
        </a>
    </div>

    <div class="main-content-showcase">
        <h2 class="section-title">Nos Talents à la Une</h2>
        <div class="player-profiles-grid" id="playerProfilesGrid">
            <div class="showcase-grid">
                <?php
                    while($donnes_joueurs = $recuperation_infos_joueurs->fetch()){
                                
                        $date_naissance = $donnes_joueurs['age'];
                        $date_info = date_parse($date_naissance);
                        $naissance = $date_info['year'];
                        $date_actuel = date('Y');
                        $age_joueur = $date_actuel - $naissance;

                        $recuperation_vues = $db->prepare('SELECT SUM(nombre) as nbr_views FROM `nombre_vues` WHERE (reference_jouers = ?)');
                        $recuperation_vues->execute(array($donnes_joueurs['reference']));
                        $nbr_vues = $recuperation_vues->fetch();
                    ?>
                <!-- Exemple de carte de Joueur -->
                <div class="showcase-card">
                    <div class="card-image-container">
                        <img src="profil_soccer/<?php echo $donnes_joueurs['profil'] ?>" alt="Joueur Talentueux">
                    </div>
                    <div class="card-content">
                        <h3><?php echo $donnes_joueurs['prenom']." ".$donnes_joueurs['nom'] ?></h3>
                        <div class="player-details">
                            <span class="detail-item"><i class="fas fa-crosshairs"></i> <?php echo $donnes_joueurs['position'] ?></span>
                            <span class="detail-item"><i class="fas fa-birthday-cake"></i> <?php echo $age_joueur ?> ans</span>
                            <span class="detail-item"><i class="fas fa-globe-africa"></i> <?php echo $donnes_joueurs['nationalite'] ?></span>
                        </div>
                        <a href="profil_joueur.php?joueur=<?php echo $donnes_joueurs['reference'] ?>" class="btn-view-profile">
                            <?php echo $nbr_vues['nbr_views'] ?> <i class="fas fa-eye" style="margin-left:5px"></i> 
                        </a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div> <!-- end showcase-grid -->
    </div>

    <div class="pagination-controls">
        <button id="prevPageBtn" disabled><i class="fas fa-arrow-left"></i> Précédent</button>
        <span id="paginationInfo" class="pagination-info">Page 1 sur 1</span>
        <button id="nextPageBtn"><i class="fas fa-arrow-right"></i> Suivant</button>
    </div>

    <div class="cta-section">
        <h2>Vous êtes un recruteur ou un club ?</h2>
        <p>Trouvez votre prochaine étoile du football africain. Accédez à des milliers de profils vérifiés, de statistiques détaillées et de vidéos de match.</p>
        <a href="login.php" class="cta-btn">
            Explorer les profils <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    </div> <!-- end main-content-showcase -->

    <footer class="app-footer">
        <div class="footer-links">
            <a href="#">À propos</a>
            <a href="#">Contact</a>
            <a href="#">Confidentialité</a>
            <a href="#">Conditions d'utilisation</a>
            <a href="inscription.html">S'inscrire</a>
        </div>
        <p>&copy; 2025 Yebana. Tous droits réservés.</p>
    </footer>

    <!-- Bottom fixed navigation menu - Uses global navigation styles from soccer.css -->
    <nav class="bottom-nav">
        <a href="#" class="nav-item active">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
        <a href="recherche_filtre.php" class="nav-item">
            <i class="fas fa-search"></i>
            <span>Rechercher</span>
        </a>
        <a href="about.html" class="nav-item">
            <i class="fas fa-info-circle"></i>
            <span>À propos</span>
        </a>
        <a href="temoignages.html" class="nav-item">
            <i class="fas fa-quote-right"></i>
            <span>Témoignages</span>
        </a>
        <a href="contact.html" class="nav-item">
            <i class="fas fa-envelope"></i>
            <span>Contact</span>
        </a>
    </nav>
    <script>
        const playerProfilesGrid = document.getElementById('playerProfilesGrid');
        const prevPageBtn = document.getElementById('prevPageBtn');
        const nextPageBtn = document.getElementById('nextPageBtn');
        const paginationInfo = document.getElementById('paginationInfo');
        const profileCards = Array.from(playerProfilesGrid.getElementsByClassName('profile-card'));

        const cardsPerPage = 10; // Nombre de cartes à afficher par page
        let currentPage = 1;

        function displayCards(page) {
            const startIndex = (page - 1) * cardsPerPage;
            const endIndex = startIndex + cardsPerPage;

            profileCards.forEach((card, index) => {
                if (index >= startIndex && index < endIndex) {
                    card.style.display = 'flex'; // Afficher la carte
                } else {
                    card.style.display = 'none'; // Masquer la carte
                }
            });

            updatePaginationControls();
        }

        function updatePaginationControls() {
            const totalPages = Math.ceil(profileCards.length / cardsPerPage);
            paginationInfo.textContent = `Page ${currentPage} sur ${totalPages}`;

            prevPageBtn.disabled = currentPage === 1;
            nextPageBtn.disabled = currentPage === totalPages;
        }

        // Écouteurs d'événements pour les boutons de pagination
        prevPageBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                displayCards(currentPage);
            }
        });

        nextPageBtn.addEventListener('click', () => {
            const totalPages = Math.ceil(profileCards.length / cardsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                displayCards(currentPage);
            }
        });

        // Affichage initial au chargement de la page
        document.addEventListener('DOMContentLoaded', () => {
            displayCards(currentPage);
        });
    </script>
</body>
</html>
