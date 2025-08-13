<?php
include('../db.php');
if (isset($_SESSION['nom'],$_SESSION['prenom'],$_SESSION['mail'],$_SESSION['reference'])) {
    if($_SESSION['acces'] === 'joueur'){

        if (isset($_GET['position']) AND !empty($_GET['position'])) {
            
            $position = htmlspecialchars($_GET['position']);
            
        }
        else {
            $position = "tous";
        }

        $recuperations_lecons = $db->prepare('SELECT * FROM `videos_educatives`WHERE destination = ? OR destination = ?  LIMIT 10');
        $recuperations_lecons->execute(array($position,"tous"));
        
        $nbr_cours_enregistrer = $recuperations_lecons->rowCount();

        

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA - Contenu Éducatif</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables et styles de base) -->
    <link rel="stylesheet" href="../style.css"> <!-- Chemin ajusté pour le sous-dossier -->
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour le header et le menu de navigation) -->
    <link rel="stylesheet" href="soccer.css">

    <!-- Styles en ligne spécifiques à la page de contenu éducatif -->
    <style>
        /* ==================================== */
        /* Styles spécifiques pour la page Contenu Éducatif (live.html) */
        /* ==================================== */

        /* Surcharge des styles du corps provenant du CSS global */
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text-color);
            margin: 0;
            padding-top: var(--header-height); /* Espace pour l'en-tête fixe */
            padding-bottom: var(--bottom-nav-height); /* Espace pour la barre de navigation fixe en bas */
            background-color: var(--dashboard-bg); /* Arrière-plan clair cohérent */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            box-sizing: border-box;
            overflow-x: hidden;
        }

        .educational-main {
            flex-grow: 1; /* Permet au contenu de s'étendre */
            width: 100%;
            max-width: 1000px; /* Largeur maximale pour le contenu */
            margin: 25px auto; /* Centre le contenu et ajoute une marge supérieure */
            padding: 0 20px; /* Rembourrage latéral */
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            gap: 25px;
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

        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Responsive grid for videos */
            gap: 25px;
            margin-bottom: 30px;
        }

        .video-card {
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: left;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            /* Hide by default, will be shown by JS filter */
        }

        .video-card.active {
            display: flex; /* Show active cards */
        }

        .video-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .video-card .thumbnail-container {
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio (height / width * 100) */
            position: relative;
            overflow: hidden;
            background-color: #f0f0f0; /* Placeholder background */
        }

        .video-card .thumbnail-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .video-card:hover .thumbnail-container img {
            transform: scale(1.05);
        }

        .video-card .card-content {
            padding: 18px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .video-card h3 {
            font-size: 1.3em;
            color: var(--dark-text-color);
            margin: 0 0 10px 0;
            font-weight: 600;
            line-height: 1.4;
        }

        .video-card p {
            font-size: 0.9em;
            color: var(--medium-text-color);
            line-height: 1.5;
            margin-bottom: 15px;
            flex-grow: 1; /* Allows description to take available space */
        }

        .video-card .video-meta {
            font-size: 0.85em;
            color: var(--medium-text-color);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        .video-card .video-meta i {
            color: var(--primary-color);
            margin-right: 3px;
        }

        .video-card .btn-watch {
            background-color: var(--primary-color);
            color: var(--white-color);
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            font-size: 0.95em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            box-shadow: 0 4px 12px var(--primary-shadow-color);
        }
        .video-card .btn-watch i {
            margin-right: 8px;
        }
        .video-card .btn-watch:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px var(--primary-shadow-color);
        }

        /* Message "aucun contenu" */
        .no-content-message {
            text-align: center;
            font-size: 1.2em;
            color: var(--medium-text-color);
            margin-top: 50px;
            padding: 30px;
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .no-content-message i {
            font-size: 2.5em;
            color: var(--secondary-color);
            margin-bottom: 15px;
            display: block;
        }
        .no-content-message p strong {
            color: var(--primary-color);
        }

        /* Styles pour la modale vidéo (popup) */
        .video-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.85); /* Fond sombre semi-transparent */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000; /* Assure que la modale est au-dessus de tout */
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .video-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .video-modal-content {
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            padding: 20px;
            width: 90%;
            max-width: 900px; /* Largeur maximale de la modale */
            transform: scale(0.9);
            transition: transform 0.3s ease;
            position: relative; /* Pour le bouton de fermeture */
        }

        .video-modal-overlay.active .video-modal-content {
            transform: scale(1);
        }

        .modal-close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 1.8em;
            color: var(--dark-text-color);
            cursor: pointer;
            transition: color 0.2s ease;
            z-index: 1001; /* Au-dessus du titre */
        }
        .modal-close-btn:hover {
            color: var(--danger-color);
        }

        .modal-video-title {
            font-size: 1.8em;
            color: var(--primary-color);
            margin-bottom: 15px;
            text-align: center;
            font-weight: 700;
            padding-right: 40px; /* Espace pour le bouton de fermeture */
        }

        .video-responsive {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
            border-radius: 10px;
            background-color: #000; /* Fond noir pour la vidéo */
        }

        .video-responsive iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* Responsive adjustments for modal */
        @media (max-width: 768px) {
            .video-modal-content {
                padding: 15px;
                width: 95%;
            }
            .modal-close-btn {
                font-size: 1.5em;
                top: 10px;
                right: 10px;
            }
            .modal-video-title {
                font-size: 1.5em;
                padding-right: 30px;
            }
        }
        @media (max-width: 480px) {
            .video-modal-content {
                padding: 10px;
            }
            .modal-close-btn {
                font-size: 1.3em;
                top: 8px;
                right: 8px;
            }
            .modal-video-title {
                font-size: 1.3em;
                padding-right: 25px;
            }
        }
    </style>
</head>
<body>
    <!-- En-tête de l'application - Utilise les styles globaux -->
    <header class="app-header">
        <div class="header-content">
            <div class="header-logo">
                <i class="fas fa-book-reader"></i>
                <span>Contenu Éducatif</span>
            </div>
            <div class="header-user">
                <!-- Bouton de retour ou de déconnexion -->
                <a href="select_position.html" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                    <i class="fas fa-arrow-left"></i>
                    <span>Retour</span>
                </a>
            </div>
        </div>
    </header>

    <main class="educational-main">
        <h2 class="section-title" id="pageTitle">Cours pour <?= $position ?></h2>

        <div class="video-grid" id="videoGrid">
            
        <?php
            if ($nbr_cours_enregistrer > 0) {
                while($donnees_cours = $recuperations_lecons->fetch()){
        ?>
            <div class="video-card" data-position="<?= $donnees_cours['titre'] ?>">
                <div class="thumbnail-container">
                    <img src="../videos_educatives/<?= $donnees_cours['url_couverture'] ?>?text=<?= $donnees_cours['titre'] ?>" alt="Miniature vidéo: <?= $donnees_cours['titre'] ?>">
                </div>
                <div class="card-content">
                    <h3><?= $donnees_cours['titre'] ?></h3>
                    <p><?= $donnees_cours['description'] ?></p>
                    <div class="video-meta">
                        <span><i class="fas fa-tag"></i> <?= $donnees_cours['destination'] ?></span>
                        <span><i class="fas fa-clock"></i> 5 min</span>
                    </div>
                    <button class="btn-watch" data-video-url="../videos_educatives/<?= $donnees_cours['url'] ?>" data-video-title="<?= $donnees_cours['titre'] ?>">
                        <i class="fas fa-play-circle"></i> Regarder la Vidéo
                    </button>
                </div>
            </div>
        <?php
            }
        ?>

        </div> <!-- end video-grid -->
        <?php
        
        }
        else{
            echo $nbr_cours_enregistrer;
        ?>
        <!-- Message si aucun contenu n'est trouvé -->
        <div class="no-content-message" id="noContentMessage">
            <i class="fas fa-exclamation-circle"></i>
            <p>Aucun contenu éducatif n'est disponible pour ce poste pour le moment.</p>
            <p>Revenez plus tard ou <strong><a href="select_position.html">choisissez un autre poste</a></strong>.</p>
        </div>
        <?php
        }
        ?>
    </main>

    <!-- Menu de navigation fixe en bas - Utilise les styles globaux -->
    <nav class="bottom-nav">
        <a href="index.php" class="nav-item">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
        <a href="view_player_profile.php?joueur=<?= $_SESSION['reference'] ?>" class="nav-item">
            <i class="fas fa-user-circle"></i>
            <span>Profil</span>
        </a>
        <a href="select_position.html" class="nav-item active">
            <i class="fas fa-graduation-cap"></i>
            <span>Apprendre</span>
        </a>
        <a href="explore.php" class="nav-item">
            <i class="fas fa-search"></i>
            <span>Explorer</span>
        </a>
    </nav>

    <!-- Modale Vidéo (Popup) -->
    <div class="video-modal-overlay" id="videoModal">
        <div class="video-modal-content">
            <button class="modal-close-btn" id="closeModalBtn"><i class="fas fa-times-circle"></i></button>
            <h3 class="modal-video-title" id="modalVideoTitle">Titre de la Vidéo</h3>
            <div class="video-responsive">
                <iframe id="modalVideoPlayer" src="" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- Lien vers le fichier JavaScript externe -->
    <script src="js/live.js"></script>
    <script>
        // Update active state for the current page in the bottom navigation
        const currentPath = window.location.pathname;
        const navItems = document.querySelectorAll('.bottom-nav .nav-item');
        navItems.forEach(item => {
            // Remove active from all
            item.classList.remove('active');
            // Check if the current path matches the href of the nav item
            // Use .endsWith() for partial matches in subfolders
            if (currentPath.endsWith(item.getAttribute('href'))) {
                item.classList.add('active');
            }
        });
    </script>
</body>
</html>

<?php
    }
    else {
        header('location:../');
    }
}
else {
    header('location:../');
}