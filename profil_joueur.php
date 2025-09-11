<?php
include('db.php');

if (isset($_GET['joueur'])) {
    $reference = htmlspecialchars($_GET['joueur']);

    $recuperation_infos_joueur = $db->prepare('SELECT * FROM `jouers` WHERE (reference = ?)');
    $recuperation_infos_joueur->execute(array($reference));
    $lignes_trouver = $recuperation_infos_joueur->rowCount();

    if ($lignes_trouver == 1) {

        $recuperation_media_joueur = $db->prepare('SELECT * FROM `media` WHERE (reference_joueur = ?) AND (`type` = ?) ORDER BY id DESC LIMIT 5');
        $recuperation_media_joueur->execute(array($reference,'image'));
        $lignes_trouver_media = $recuperation_media_joueur->rowCount();

        $recuperation_media_joueur_video = $db->prepare('SELECT * FROM `media` WHERE (reference_joueur = ?) AND (`type` = ?) ORDER BY id DESC LIMIT 2');
        $recuperation_media_joueur_video->execute(array($reference,'video'));
        $lignes_trouver_media_video = $recuperation_media_joueur_video->rowCount();

        $recuperation_match_jouer = $db->prepare('SELECT SUM(nbr_matches) as `matches_jouer` FROM `performances` WHERE (joueurs = ?)');
        $recuperation_match_jouer->execute(array($reference));
        $lignes_trouver_performances = $recuperation_match_jouer->rowCount();
        $donnees_matches_jouer = $recuperation_match_jouer->fetch();

        $recuperation_minute_jouer = $db->prepare('SELECT SUM(nbr_minute_jouer) as `minute` FROM `performances` WHERE (joueurs = ?)');
        $recuperation_minute_jouer->execute(array($reference));
        $lignes_trouver_performances_minute = $recuperation_minute_jouer->rowCount();
        $donnees_minute = $recuperation_minute_jouer->fetch();

        $recuperation_passes_decisives = $db->prepare('SELECT SUM(nbr_passes_decisives) as `passes_decisives` FROM `performances` WHERE (joueurs = ?)');
        $recuperation_passes_decisives->execute(array($reference));
        $lignes_trouver_passes_decisives = $recuperation_passes_decisives->rowCount();
        $donnees_passes_decisives = $recuperation_passes_decisives->fetch();

        $recuperation_buts = $db->prepare('SELECT SUM(nbr_buts) as `buts` FROM `performances` WHERE (joueurs = ?)');
        $recuperation_buts->execute(array($reference));
        $lignes_trouver_buts = $recuperation_buts->rowCount();
        $donnees_buts = $recuperation_buts->fetch();

        $recuperation_passes = $db->prepare('SELECT SUM(nbr_passes_reussis) as `passes_reussis` FROM `performances` WHERE (joueurs = ?)');
        $recuperation_passes->execute(array($reference));
        $lignes_trouver_passes = $recuperation_passes->rowCount();
        $donnees_passes = $recuperation_passes->fetch();

        $recuperation_duos = $db->prepare('SELECT SUM(nbr_recuperation_balles) as `nbr_recuperation_balles` FROM `performances` WHERE (joueurs = ?)');
        $recuperation_duos->execute(array($reference));
        $lignes_trouver_passes = $recuperation_duos->rowCount();
        $donnees_duos = $recuperation_duos->fetch();
        
        $recuperation_notes = $db->prepare('SELECT SUM(notes) as `note` FROM `performances` WHERE (joueurs = ?)');
        $recuperation_notes->execute(array($reference));
        $lignes_trouver_notes = $recuperation_notes->rowCount();
        $donnees_notes = $recuperation_notes->fetch();

        $recuperation_vues = $db->prepare('SELECT * FROM `nombre_vues` WHERE (reference_jouers = ?)');
        $recuperation_vues->execute(array($reference));
        $nbr_vues = $recuperation_vues->rowCount();

        $donnees = $recuperation_infos_joueur->fetch();

        $date_naissance = $donnees['age'];
        $date_info = date_parse($date_naissance);
        $naissance = $date_info['year'];
        $date_actuel = date('Y');
        $age_joueur = $date_actuel - $naissance;
        
        $upladDir = '../media';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA - Profil de Samuel Eto'o</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables et styles de base) -->
    <link rel="stylesheet" href="style.css">
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour la nav et le header) -->
    <link rel="stylesheet" href="soccer/soccer.css">

    <!-- Inline styles specific to the player profile view page -->
   <style>
        /* ==================================== */
        /* Styles spécifiques pour la page d'affichage du Profil Joueur */
        /* ==================================== */

        .profile-view-main {
            flex-grow: 1;
            background-color: var(--dashboard-bg); /* Uses the soft dashboard background */
            width: 100%;
            max-width: 800px; /* Wider for profile display */
            margin: 0 auto; /* Centers content */
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            gap: 25px; /* Space between sections */
            padding-top: 80px;
        }

        .profile-header-card {
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative; /* For the contact button */
        }

        .profile-header-card .profile-pic-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 5px solid var(--primary-color);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .profile-header-card h1 {
            font-size: 2.2em;
            color: var(--dark-text-color);
            margin: 0 0 10px 0;
        }

        .profile-header-card .player-meta {
            font-size: 1.1em;
            color: var(--medium-text-color);
            margin-bottom: 20px;
        }

        .profile-header-card .player-meta span {
            margin: 0 8px;
            display: inline-flex;
            align-items: center;
        }
        .profile-header-card .player-meta i {
            margin-right: 5px;
            color: var(--primary-color);
        }

        .profile-header-card .player-bio {
            font-size: 1em;
            color: var(--dark-text-color);
            line-height: 1.6;
            margin-bottom: 25px;
            max-width: 600px;
        }

        .profile-header-card .contact-btn {
            background: linear-gradient(45deg, var(--secondary-color), #218838);
            color: var(--white-color);
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 5px 15px var(--secondary-shadow-color);
        }
        .profile-header-card .contact-btn i {
            margin-right: 10px;
        }
        .profile-header-card .contact-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--secondary-shadow-color);
        }


        /* General section styling */
        .profile-section-card {
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 25px 30px;
        }

        .profile-section-card h2 {
            font-size: 1.8em;
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        .profile-section-card h2 i {
            margin-right: 10px;
            font-size: 1em;
        }

        /* Detail grid */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .detail-item-view {
            background-color: var(--light-bg-color);
            padding: 15px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            text-align: left;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .detail-item-view strong {
            display: block;
            font-size: 0.9em;
            color: var(--medium-text-color);
            margin-bottom: 5px;
        }

        .detail-item-view span {
            font-size: 1.1em;
            color: var(--dark-text-color);
            font-weight: 600;
        }
        .detail-item-view i {
            margin-right: 8px;
            color: var(--primary-color);
        }

        /* Videos Section */
        .video-player {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio (9 / 16 * 100%) */
            height: 0;
            overflow: hidden;
            background-color: #000;
            border-radius: 10px;
            margin-bottom: 20px; /* Space between videos */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .video-player iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .video-item {
            margin-bottom: 20px;
        }
        .video-item h3 {
            font-size: 1.3em;
            color: var(--dark-text-color);
            margin-top: 0;
            margin-bottom: 10px;
            text-align: left;
        }

        /* CV Section */
        .cv-download-btn {
            background-color: var(--primary-color);
            color: var(--white-color);
            padding: 15px 25px;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            text-decoration: none; /* For link styling */
            box-shadow: 0 5px 15px var(--primary-shadow-color);
        }
        .cv-download-btn i {
            margin-right: 10px;
            font-size: 1.2em;
        }
        .cv-download-btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--primary-shadow-color);
        }


        /* Back link general */
        .back-link {
            margin-top: 30px;
            text-align: center;
        }
        .back-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
        }
        .back-link a i {
            margin-right: 8px;
        }
        .back-link a:hover {
            color: #0056b3;
            text-decoration: underline;
        }


        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            .profile-view-main {
                padding: 15px;
                gap: 20px;
            }

            .profile-header-card {
                padding: 20px;
            }
            .profile-header-card .profile-pic-large {
                width: 100px;
                height: 100px;
            }
            .profile-header-card h1 {
                font-size: 1.8em;
            }
            .profile-header-card .player-meta {
                font-size: 0.95em;
                flex-direction: column; /* Stack details vertically */
                gap: 5px; /* Space between stacked details */
            }
            .profile-header-card .player-meta span {
                margin: 0; /* Reset horizontal margin */
            }
            .profile-header-card .player-bio {
                font-size: 0.95em;
                margin-bottom: 20px;
            }
            .profile-header-card .contact-btn {
                font-size: 1em;
                padding: 10px 20px;
            }

            .profile-section-card {
                padding: 20px;
            }
            .profile-section-card h2 {
                font-size: 1.5em;
            }

            .details-grid {
                grid-template-columns: 1fr; /* Single column on mobile */
                gap: 15px;
            }
            .detail-item-view {
                padding: 12px;
            }
            .detail-item-view strong {
                font-size: 0.85em;
            }
            .detail-item-view span {
                font-size: 1em;
            }

            .video-item h3 {
                font-size: 1.1em;
            }

            .cv-download-btn {
                font-size: 1em;
                padding: 12px 20px;
                width: 100%; /* Full width on mobile */
                justify-content: center;
            }
        }
        @media (max-width: 480px) {
            .profile-header-card h1 {
                font-size: 1.6em;
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

            .nav-item span{
                display: none;
            }
            .nav-item i{
                font-size: 20px;
            }
            .header-logo span, .header-user span{
                display: inline;
            }
            .header-user span{
                font-size: 15px;
            }
            .hero-section h1{
                font-size: 30px;
                padding-top: 50px;
            }
            h2{
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- App Header - Reuses global class -->
    <header class="app-header">
        <div class="header-content">
             <div class="header-logo">
                <i class="fas fa-futbol"></i>
                <span> YEBANA</span>
            </div>
            <div class="header-user">
                <!-- Icon for options or back button -->
                <a href="index.php" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                    <i class="fas fa-arrow-left"></i>
                    <span>Retour</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main profile content -->
    <main class="profile-view-main">

        <!-- Profile Header Section -->
        <div class="profile-header-card">
            <img src="profil_soccer/<?php echo $donnees['profil'] ?>" alt="Photo de profil de <?php echo $donnees['nom'].' '.$donnees['prenom'] ?>" class="profile-pic-large">
            <h1><?php echo $donnees['nom'].' '.$donnees['postnom'].' '.$donnees['prenom'] ?></h1>
            <div class="player-meta">
                <span><i class="fas fa-crosshairs"></i> <?php echo $donnees['position'] ?></span>
                <span><i class="fas fa-birthday-cake"></i> <?php echo $age_joueur ?> ans</span>
                <span><i class="fas fa-globe-africa"></i> <?php echo $donnees['nationalite'] ?></span>
                <span><i class="fas fa-city"></i> <?php echo $donnees['lieu_naissance'] ?></span>
            </div>
            <p class="player-bio">Attaquant rapide et puissant, doté d'une finition clinique et d'une excellente vision du jeu. Capable de jouer en pivot ou sur les ailes, toujours prêt à faire la différence.</p>
            <button class="contact-btn"><i class="fas fa-comment"></i> Contacter</button>
        </div>

        <!-- Sports Characteristics Section -->
        <div class="profile-section-card">
            <h2><i class="fas fa-chart-bar"></i> Caractéristiques Sportives</h2>
            <div class="details-grid">
                <div class="detail-item-view">
                    <strong>Poste Principal :</strong>
                    <span><i class="fas fa-futbol"></i> <?php echo $donnees['position'] ?></span>
                </div>
                <div class="detail-item-view">
                    <strong>Poste(s) Secondaire(s) :</strong>
                    <span><i class="fas fa-futbol"></i> <?php echo $donnees['position_secondaires'] ?></span>
                </div>
                <div class="detail-item-view">
                    <strong>Club Actuel :</strong>
                    <span><i class="fas fa-shield-alt"></i> <?php echo $donnees['club'] ?></span>
                </div>
                <div class="detail-item-view">
                    <strong>Taille :</strong>
                    <span><i class="fas fa-ruler-vertical"></i> <?php echo $donnees['taille'] ?> m</span>
                </div>
                <div class="detail-item-view">
                    <strong>Poids :</strong>
                    <span><i class="fas fa-weight-hanging"></i> 72 kg</span>
                </div>
                <div class="detail-item-view">
                    <strong>Pied Fort :</strong>
                    <span><i class="fas fa-shoe-prints"></i></i> <?php echo $donnees['pied'] ?></span>
                </div>
            </div>
        </div>

        <!-- Player Statistics Section (NEW) -->
        <div class="profile-section-card">
            <h2><i class="fas fa-hockey-puck"></i> Statistiques de Jeu (Saison Actuelle)</h2>
            <div class="details-grid">
                <div class="detail-item-view">
                    <strong>Matchs Joués :</strong>
                    <span><i class="fas fa-calendar-check"></i> <?php echo $donnees_matches_jouer['matches_jouer'] ?></span>
                </div>
                <div class="detail-item-view">
                    <strong>Buts :</strong>
                    <span><i class="fas fa-futbol"></i> <?php echo $donnees_buts['buts'] ?></span>
                </div>
                <div class="detail-item-view">
                    <strong>Passes Décisives :</strong>
                    <span><i class="fas fa-handshake"></i> <?php echo $donnees_passes_decisives['passes_decisives'] ?></span>
                </div>
                <div class="detail-item-view">
                    <strong>Cartons Jaunes :</strong>
                    <span><i class="fas fa-square"></i> 3</span>
                </div>
                <div class="detail-item-view">
                    <strong>Cartons Rouges :</strong>
                    <span><i class="fas fa-times-circle"></i> 0</span>
                </div>
                <div class="detail-item-view">
                    <strong>Minutes Jouées :</strong>
                    <span><i class="fas fa-stopwatch"></i> <?php echo $donnees_minute['minute'] ?>'</span>
                </div>
                <div class="detail-item-view">
                    <strong>Tirs Cadrés :</strong>
                    <span><i class="fas fa-bullseye"></i> 35</span>
                </div>
                <div class="detail-item-view">
                    <strong>Tacles Réussis :</strong>
                    <span><i class="fas fa-fist-raised"></i> <?php echo $donnees_duos['nbr_recuperation_balles'] ?></span>
                </div>
            </div>
        </div>

        <!-- Videos Section -->
        <div class="profile-section-card">
            <h2><i class="fas fa-video"></i> Vidéos</h2>
            <div class="video-item">
                <h3>Mes meilleurs buts 2024</h3>
                <div class="video-player">
                    <!-- Example YouTube Embed - Replace VIDEO_ID with actual YouTube video ID -->
                    <iframe src="https://www.youtube.com/embed/VIDEO_ID_1?rel=0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="video-item">
                <h3>Highlights Entraînement</h3>
                <div class="video-player">
                    <!-- Example YouTube Embed -->
                    <iframe src="https://www.youtube.com/embed/VIDEO_ID_2?rel=0" allowfullscreen></iframe>
                </div>
            </div>
            <!-- Add more video items as needed -->
        </div>

    </main>

    <!-- Bottom fixed navigation menu - Reuses global class -->
    <nav class="bottom-nav">
        <a href="index.php" class="nav-item">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
        <a href="recherche_filtre.php" class="nav-item active">
            <i class="fas fa-search"></i>
            <span>Recherche</span>
        </a>
        <a href="about.html" class="nav-item">
            <i class="fas fa-info-circle"></i>
            <span>À propos</span>
        </a>
        <a href="testimonials.html" class="nav-item">
            <i class="fas fa-quote-right"></i>
            <span>Témoignages</span>
        </a>
        <a href="contact.html" class="nav-item">
            <i class="fas fa-envelope"></i>
            <span>Contact</span>
        </a>
    </nav>
</body>
</html>
<?php 
    $ajout_vues = $db->prepare('INSERT INTO `nombre_vues`( `reference_jouers`, `nombre`) VALUES ( ?, ?)');
    $ajout_vues->execute(array($reference, 1));
    }
}
