<?php
include('../db.php');
if (isset($_SESSION['nom'],$_SESSION['prenom'],$_SESSION['mail'],$_SESSION['reference'])) {
    if($_SESSION['acces'] === 'manager'){

    $recuperation_joueurs = $db->prepare('SELECT * FROM `jouers` ORDER BY categorie DESC');
    $recuperation_joueurs->execute(array());

    $nbr_joueurs = $recuperation_joueurs->rowCount();

        
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA - Tableau de Bord Manager</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables de couleur et styles de base) -->
    <link rel="stylesheet" href="../style.css">
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour le header et le menu de navigation) -->
    <link rel="stylesheet" href="../soccer/soccer.css">

    <!-- Styles en ligne spécifiques au tableau de bord du manager -->
    <style>
        /* ==================================== */
        /* Styles spécifiques pour le Tableau de Bord Manager (index.php) */
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

        .manager-dashboard-main {
            flex-grow: 1; /* Permet au contenu de s'étendre */
            width: 100%;
            max-width: 1000px; /* Largeur maximale pour le contenu */
            margin: 25px auto; /* Centre le contenu et ajoute une marge supérieure */
            padding: 0 20px; /* Rembourrage latéral */
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            gap: 25px; /* Espace entre les sections */
        }

        .section-title {
            font-size: 2.5em;
            color: var(--dark-text-color);
            text-align: center;
            margin-bottom: 20px;
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

        /* Styles de la grille des profils de joueurs (similaire à la vitrine) */
        .player-profiles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* 4-5 profils sur grand écran */
            gap: 20px; /* Espacement entre les cartes */
            margin-bottom: 30px; /* Espace avant la pagination */
        }

        .profile-card {
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Pousse les boutons vers le bas */
        }

        .profile-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .profile-card .card-image-container {
            width: 100%;
            height: 160px; /* Hauteur légèrement ajustée */
            overflow: hidden;
            border-bottom: 1px solid var(--border-color);
        }

        .profile-card .card-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .profile-card:hover .card-image-container img {
            transform: scale(1.05);
        }

        .profile-card .card-content {
            padding: 18px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .profile-card h3 {
            margin: 0 0 10px 0;
            font-size: 1.4em;
            color: var(--dark-text-color);
            font-weight: 700;
        }

        .profile-card .player-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
            margin-bottom: 15px;
            font-size: 0.85em;
            color: var(--medium-text-color);
        }

        .profile-card .detail-item {
            display: flex;
            align-items: center;
            background-color: var(--light-bg-color);
            padding: 3px 8px;
            border-radius: 20px;
            border: 1px solid var(--border-color);
            white-space: nowrap;
        }

        .profile-card .detail-item i {
            margin-right: 5px;
            color: var(--primary-color);
            font-size: 0.8em;
        }
        
        /* Boutons spécifiques au manager */
        .profile-card .card-actions {
            display: flex;
            flex-direction: column; /* Empile les boutons */
            gap: 8px; /* Espace entre les boutons */
            width: 100%;
            padding: 0 10px 18px 10px; /* Rembourrage pour la zone d'action */
            box-sizing: border-box;
        }

        .profile-card .btn-view-profile,
        .profile-card .btn-contact-player {
            width: calc(100% - 16px); /* Prend la largeur complète moins le rembourrage */
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .profile-card .btn-view-profile {
            background-color: var(--primary-color);
            color: var(--white-color);
            box-shadow: 0 4px 12px var(--primary-shadow-color);
        }
        .profile-card .btn-view-profile:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px var(--primary-shadow-color);
        }

        .profile-card .btn-contact-player {
            background-color: var(--secondary-color); /* Vert pour contacter */
            color: var(--white-color);
            box-shadow: 0 4px 12px var(--secondary-shadow-color);
        }
        .profile-card .btn-contact-player:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px var(--secondary-shadow-color);
        }

        .profile-card .btn-view-profile i,
        .profile-card .btn-contact-player i {
            margin-right: 8px;
        }

        /* Pagination styles (reused from showcase.php) */
        .pagination-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-top: 30px;
            margin-bottom: 40px;
        }

        .pagination-controls button {
            background-color: var(--primary-color);
            color: var(--white-color);
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 3px 10px var(--primary-shadow-color);
        }

        .pagination-controls button i {
            margin: 0 5px;
        }

        .pagination-controls button:hover:not(:disabled) {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px var(--primary-shadow-color);
        }

        .pagination-controls button:disabled {
            background-color: var(--border-color);
            color: var(--medium-text-color);
            cursor: not-allowed;
            box-shadow: none;
        }

        .pagination-info {
            font-size: 1em;
            color: var(--dark-text-color);
            font-weight: 600;
            white-space: nowrap;
        }

        /* Responsive adjustments */
        @media (max-width: 900px) {
            .manager-dashboard-main {
                padding: 20px 15px 40px 15px;
            }
            .section-title {
                font-size: 2em;
            }
            .player-profiles-grid {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 15px;
            }
            .profile-card .card-image-container {
                height: 140px;
            }
            .profile-card .card-content {
                padding: 15px;
            }
            .profile-card h3 {
                font-size: 1.3em;
            }
            .profile-card .player-details {
                font-size: 0.8em;
            }
            .profile-card .detail-item {
                padding: 2px 6px;
            }
            .profile-card .btn-view-profile,
            .profile-card .btn-contact-player {
                font-size: 0.85em;
                padding: 8px 15px;
                width: calc(100% - 16px);
            }
            .profile-card .card-actions {
                padding: 0 8px 15px 8px;
            }
            .pagination-controls button {
                padding: 10px 20px;
                font-size: 0.9em;
            }
            .pagination-info {
                font-size: 0.9em;
            }
        }

        @media (max-width: 600px) {
            .section-title {
                font-size: 1.8em;
            }
            .player-profiles-grid {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); /* 2 colonnes sur mobile */
                gap: 10px;
            }
            .profile-card .card-image-container {
                height: 120px;
            }
            .profile-card .card-content {
                padding: 10px;
            }
            .profile-card h3 {
                font-size: 1.1em;
            }
            .profile-card .player-details {
                font-size: 0.7em;
                gap: 4px;
            }
            .profile-card .detail-item {
                padding: 1px 4px;
            }
            .profile-card .btn-view-profile,
            .profile-card .btn-contact-player {
                font-size: 0.8em;
                padding: 6px 12px;
                width: calc(100% - 12px);
                margin-top: 6px;
            }
            .profile-card .card-actions {
                padding: 0 6px 12px 6px;
                gap: 6px;
            }
            .pagination-controls {
                flex-direction: column;
                gap: 10px;
            }
            .pagination-controls button {
                width: 100%;
                font-size: 0.9em;
                padding: 10px 15px;
            }
            .pagination-info {
                font-size: 0.85em;
            }
        }
    </style>
</head>
<body>
    <!-- En-tête de l'application - Utilise les styles globaux -->
    <header class="app-header">
        <div class="header-content">
            <div class="header-logo">
                <i class="fas fa-tachometer-alt"></i>
                <span>Yebana Sport</span>
            </div>
            <div class="header-user">
                <!-- Bouton de déconnexion -->
                <a href="login.php" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </div>
    </header>

    <main class="manager-dashboard-main">
        <h2 class="section-title">Joueurs Recommandés </h2>

        <div class="player-profiles-grid" id="playerProfilesGrid">
            <!-- Exemple de Cartes de Profil Joueur (seront dynamiquement affichées/masquées par JS pour la pagination) -->
            
            <?php
            if($nbr_joueurs >= 1){
                while ($donnees_joueurs = $recuperation_joueurs->fetch()) {

                    $date_naissance = $donnees_joueurs['age'];
                    $date_info = date_parse($date_naissance);
                    $naissance = $date_info['year'];
                    $date_actuel = date('Y');
                    $age_joueur = $date_actuel - $naissance;

                    $recuperation_vues = $db->prepare('SELECT * FROM `nombre_vues` WHERE (reference_jouers = ?)');
                    $recuperation_vues->execute(array($donnees_joueurs['reference']));
                    $nbr_vues = $recuperation_vues->rowCount();
            ?>

            <div class="profile-card">
                <div class="card-image-container">
                    <img src="../profil_soccer/<?= $donnees_joueurs['profil'] ?>" alt="Profil de Joueur A">
                </div>
                <div class="card-content">
                    <h3><?= $donnees_joueurs['nom'].' '.$donnees_joueurs['prenom'] ?></h3>
                    <div class="player-details">
                        <span class="detail-item"><i class="fas fa-crosshairs"></i> <?= $donnees_joueurs['position'] ?></span>
                        <span class="detail-item"><i class="fas fa-birthday-cake"></i> <?= $age_joueur ?> ans</span>
                        <span class="detail-item"><i class="fas fa-globe-africa"></i> <?= $donnees_joueurs['nationalite'] ?></span>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="view_player_profile.php?id=playerA" class="btn-view-profile">
                        <i class="fas fa-eye"></i> <?= $nbr_vues ?>
                    </a>
                    <a href="messages.php?to=playerA" class="btn-contact-player">
                        <i class="fas fa-comment"></i> Contacter
                    </a>
                </div>
            </div>

            <?php
                }
            }
            ?>
            

        </div> <!-- end player-profiles-grid -->

        <div class="pagination-controls">
            <button id="prevPageBtn" disabled><i class="fas fa-arrow-left"></i> Précédent</button>
            <span id="paginationInfo" class="pagination-info">Page 1 sur 1</span>
            <button id="nextPageBtn"><i class="fas fa-arrow-right"></i> Suivant</button>
        </div>
    </main>

    <!-- Menu de navigation fixe en bas - Utilise les styles globaux -->
    <nav class="bottom-nav">
        <a href="index.php" class="nav-item active">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
        <a href="recherche_filtre.php" class="nav-item">
            <i class="fas fa-search"></i>
            <span>Recherche</span>
        </a>
        <a href="messages.php" class="nav-item">
            <i class="fas fa-envelope"></i>
            <span>Messages</span>
        </a>
        <a href="profile.php" class="nav-item"> <!-- A modifier pour un profil Manager dédié plus tard -->
            <i class="fas fa-user-circle"></i>
            <span>Mon Profil</span>
        </a>
        <a href="liste.html" class="nav-item"> <!-- Lien placeholder pour une future fonctionnalité -->
            <i class="fas fa-list"></i>
            <span>Listes</span>
        </a>
    </nav>

    <script>
        const playerProfilesGrid = document.getElementById('playerProfilesGrid');
        const prevPageBtn = document.getElementById('prevPageBtn');
        const nextPageBtn = document.getElementById('nextPageBtn');
        const paginationInfo = document.getElementById('paginationInfo');
        const profileCards = Array.from(playerProfilesGrid.getElementsByClassName('profile-card'));

        const cardsPerPage = 6; // Nombre de cartes à afficher par page
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
<?php
    }
    else {
        header('location:../index.php');
    }
}
else {
    header('location:../index.php');
}