<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA - Recherche de Profils</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables de couleur et styles de base) -->
    <link rel="stylesheet" href="../style.css">
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour le header et le menu de navigation) -->
    <link rel="stylesheet" href="../soccer/soccer.css">

    <!-- Styles en ligne spécifiques à la page de recherche pour manager -->
    <style>
        /* ==================================== */
        /* Styles spécifiques pour la page Recherche de Profils (Manager) */
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

        .manager-search-main {
            flex-grow: 1; /* Permet au contenu de s'étendre et de pousser le pied de page vers le bas */
            width: 100%;
            max-width: 1000px; /* Largeur maximale pour la zone de recherche et les résultats */
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

        .filter-card {
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 25px;
            text-align: left;
        }

        .filter-card h2 {
            font-size: 1.8em;
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-weight: 600;
        }

        .filter-card h2 i {
            margin-right: 10px;
            font-size: 1em;
        }

        .filter-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .filter-form-grid .form-group {
            margin-bottom: 0;
        }
        .filter-form-grid label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-text-color);
            font-size: 1em;
        }
        .filter-form-grid label i {
            margin-right: 8px;
            color: var(--primary-color);
        }
        .filter-form-grid input[type="text"],
        .filter-form-grid input[type="number"],
        .filter-form-grid select {
            width: calc(100% - 24px); /* Full width minus padding/border */
            padding: 12px;
            border: 1px solid var(--input-border-color);
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1em;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .filter-form-grid select {
            appearance: none;
            background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"%3e%3cpolyline points="6 9 12 15 18 9"%3e%3c/polyline%3e%3c/svg%3e');
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 1em;
            padding-right: 40px;
        }

        .filter-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 25px;
        }

        .filter-actions button {
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .filter-actions button i {
            margin-right: 8px;
        }

        .filter-actions .btn-primary-filter {
            background: linear-gradient(45deg, var(--primary-color), #0056b3);
            color: var(--white-color);
        }
        .filter-actions .btn-primary-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px var(--primary-shadow-color);
        }

        .filter-actions .btn-secondary-filter {
            background-color: var(--light-bg-color);
            color: var(--dark-text-color);
            border: 1px solid var(--border-color);
        }
        .filter-actions .btn-secondary-filter:hover {
            transform: translateY(-2px);
            background-color: var(--hover-bg-color);
        }

        /* Results Grid - Reusing styles from manager dashboard */
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Adjusted for manager view */
            gap: 20px;
            margin-top: 25px;
        }

        .profile-card { /* Renamed from result-card for clarity */
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* To push buttons to bottom */
        }

        .profile-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .profile-card .card-image-container {
            width: 100%;
            height: 160px; /* Consistent height with manager dashboard */
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
        
        /* Buttons for manager search results */
        .profile-card .card-actions {
            display: flex;
            flex-direction: column; /* Stack buttons */
            gap: 8px; /* Space between buttons */
            width: 100%;
            padding: 0 10px 18px 10px; /* Padding for the action area within the card */
            box-sizing: border-box;
        }

        .profile-card .btn-view-profile,
        .profile-card .btn-contact-player {
            width: calc(100% - 16px); /* Adjusted for padding */
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
            background-color: var(--secondary-color); /* Greenish for contact */
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

        /* No results message */
        .no-results {
            text-align: center;
            font-size: 1.2em;
            color: var(--medium-text-color);
            margin-top: 50px;
            padding: 30px;
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .no-results i {
            font-size: 2em;
            color: var(--primary-color);
            margin-bottom: 15px;
            display: block;
        }

        /* Responsive adjustments */
        @media (max-width: 900px) {
            .manager-search-main {
                padding: 20px 15px 40px 15px;
            }
            .section-title {
                font-size: 2em;
            }
            .filter-card {
                padding: 25px;
            }
            .filter-card h2 {
                font-size: 1.6em;
            }
            .filter-form-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 15px;
            }
            .filter-form-grid input, .filter-form-grid select {
                font-size: 0.95em;
                padding: 10px;
            }
            .filter-actions {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            .filter-actions button {
                width: 100%;
                font-size: 0.95em;
                padding: 10px 20px;
            }
            .results-grid {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); /* More compact results on medium screens */
                gap: 15px;
            }
            .profile-card .card-image-container {
                height: 140px;
            }
            .profile-card .card-content {
                padding: 15px;
            }
            .profile-card h3 {
                font-size: 1.2em;
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
                padding: 0 8px 15px 8px; /* Adjusted padding */
            }
        }

        @media (max-width: 600px) {
            .section-title {
                font-size: 1.8em;
            }
            .filter-card {
                padding: 20px;
            }
            .filter-card h2 {
                font-size: 1.4em;
            }
            .filter-form-grid {
                grid-template-columns: 1fr; /* Single column on mobile */
                gap: 15px;
            }
            .results-grid {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); /* 2 columns on small mobiles */
                gap: 10px;
            }
             .profile-card .card-image-container {
                height: 100px;
            }
            .profile-card .card-content {
                padding: 10px;
            }
            .profile-card h3 {
                font-size: 1em;
            }
            .profile-card .player-details {
                font-size: 0.7em;
            }
            .profile-card .detail-item {
                padding: 1px 4px;
            }
            .profile-card .btn-view-profile,
            .profile-card .btn-contact-player {
                font-size: 0.8em;
                padding: 6px 12px;
                width: calc(100% - 12px); /* Adjusted for padding */
                margin-top: 6px;
            }
            .profile-card .card-actions {
                padding: 0 6px 12px 6px; /* Adjusted padding */
                gap: 6px;
            }
        }
    </style>
</head>
<body>
    <!-- En-tête de l'application - Utilise les styles globaux -->
    <header class="app-header">
        <div class="header-content">
            <div class="header-logo">
                <i class="fas fa-search"></i>
                <span>Recherche de Profils</span>
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

    <main class="manager-search-main">
        <h2 class="section-title">Rechercher des Joueurs</h2>

        <!-- Carte de filtre -->
        <div class="filter-card">
            <h2><i class="fas fa-filter"></i> Options de Filtrage</h2>
            <form action="#" method="GET" class="filter-form">
                <div class="filter-form-grid">
                    <div class="form-group">
                        <label for="keyword"><i class="fas fa-keyboard"></i> Mot-clé :</label>
                        <input type="text" id="keyword" name="keyword" placeholder="Nom, club, bio...">
                    </div>
                    
                    <div class="form-group">
                        <label for="position"><i class="fas fa-crosshairs"></i> Poste :</label>
                        <select id="position" name="position">
                            <option value="">Tous les postes</option>
                            <option value="Gardien">Gardien</option>
                            <option value="Défenseur">Défenseur</option>
                            <option value="Milieu">Milieu</option>
                            <option value="Attaquant">Attaquant</option>
                            <!-- Plus de postes peuvent être ajoutés ici -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nationality"><i class="fas fa-flag"></i> Nationalité :</label>
                        <input type="text" id="nationality" name="nationality" placeholder="Ex: Congolaise, Ghanéenne">
                    </div>

                    <div class="form-group">
                        <label for="min_age"><i class="fas fa-birthday-cake"></i> Âge Min. :</label>
                        <input type="number" id="min_age" name="min_age" min="15" max="45" placeholder="15">
                    </div>
                    <div class="form-group">
                        <label for="max_age"><i class="fas fa-birthday-cake"></i> Âge Max. :</label>
                        <input type="number" id="max_age" name="max_age" min="15" max="45" placeholder="45">
                    </div>
                    
                    <!-- D'autres filtres spécifiques aux managers peuvent être ajoutés (ex: statut de disponibilité) -->
                </div>

                <div class="filter-actions">
                    <button type="reset" class="btn-secondary-filter"><i class="fas fa-redo-alt"></i> Réinitialiser</button>
                    <button type="submit" class="btn-primary-filter"><i class="fas fa-search"></i> Rechercher</button>
                </div>
            </form>
        </div>

        <h2 class="section-title">Résultats de la Recherche</h2>

        <!-- Zone d'affichage des résultats -->
        <div class="results-grid" id="searchResultsGrid">
            <!-- Exemple de Cartes de Profil Joueur (sera rempli dynamiquement) -->
            <!-- Player 1 -->
            <div class="profile-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/007bff/ffffff?text=Joueur+A" alt="Profil de Joueur A">
                </div>
                <div class="card-content">
                    <h3>Samuel Eto'o (Exemple)</h3>
                    <div class="player-details">
                        <span class="detail-item"><i class="fas fa-crosshairs"></i> Attaquant</span>
                        <span class="detail-item"><i class="fas fa-birthday-cake"></i> 20 ans</span>
                        <span class="detail-item"><i class="fas fa-globe-africa"></i> Camerounais</span>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="view_player_profile.php?id=playerA" class="btn-view-profile">
                        <i class="fas fa-eye"></i> Voir Profil
                    </a>
                    <a href="messages.php?to=playerA" class="btn-contact-player">
                        <i class="fas fa-comment"></i> Contacter
                    </a>
                </div>
            </div>

            <!-- Player 2 -->
            <div class="profile-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/28a745/ffffff?text=Joueur+B" alt="Profil de Joueur B">
                </div>
                <div class="card-content">
                    <h3>Sarah Koné</h3>
                    <div class="player-details">
                        <span class="detail-item"><i class="fas fa-shield-alt"></i> Défenseur</span>
                        <span class="detail-item"><i class="fas fa-birthday-cake"></i> 21 ans</span>
                        <span class="detail-item"><i class="fas fa-globe-africa"></i> Ivoirienne</span>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="view_player_profile.php?id=playerB" class="btn-view-profile">
                        <i class="fas fa-eye"></i> Voir Profil
                    </a>
                    <a href="messages.php?to=playerB" class="btn-contact-player">
                        <i class="fas fa-comment"></i> Contacter
                    </a>
                </div>
            </div>

            <!-- Player 3 -->
            <div class="profile-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/ffc107/333333?text=Joueur+C" alt="Profil de Joueur C">
                </div>
                <div class="card-content">
                    <h3>Mamadou Diallo</h3>
                    <div class="player-details">
                        <span class="detail-item"><i class="fas fa-hand-paper"></i> Gardien</span>
                        <span class="detail-item"><i class="fas fa-birthday-cake"></i> 19 ans</span>
                        <span class="detail-item"><i class="fas fa-globe-africa"></i> Guinéen</span>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="view_player_profile.php?id=playerC" class="btn-view-profile">
                        <i class="fas fa-eye"></i> Voir Profil
                    </a>
                    <a href="messages.php?to=playerC" class="btn-contact-player">
                        <i class="fas fa-comment"></i> Contacter
                    </a>
                </div>
            </div>

            <!-- Player 4 -->
            <div class="profile-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/17a2b8/ffffff?text=Joueur+D" alt="Profil de Joueur D">
                </div>
                <div class="card-content">
                    <h3>Aisha Musa</h3>
                    <div class="player-details">
                        <span class="detail-item"><i class="fas fa-futbol"></i> Milieu</span>
                        <span class="detail-item"><i class="fas fa-birthday-cake"></i> 22 ans</span>
                        <span class="detail-item"><i class="fas fa-globe-africa"></i> Nigériane</span>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="view_player_profile.php?id=playerD" class="btn-view-profile">
                        <i class="fas fa-eye"></i> Voir Profil
                    </a>
                    <a href="messages.php?to=playerD" class="btn-contact-player">
                        <i class="fas fa-comment"></i> Contacter
                    </a>
                </div>
            </div>

            <!-- Player 5 -->
            <div class="profile-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/6f42c1/ffffff?text=Joueur+E" alt="Profil de Joueur E">
                </div>
                <div class="card-content">
                    <h3>Thabo Mbeki</h3>
                    <div class="player-details">
                        <span class="detail-item"><i class="fas fa-bolt"></i> Ailier</span>
                        <span class="detail-item"><i class="fas fa-birthday-cake"></i> 20 ans</span>
                        <span class="detail-item"><i class="fas fa-globe-africa"></i> Sud-Africain</span>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="view_player_profile.php?id=playerE" class="btn-view-profile">
                        <i class="fas fa-eye"></i> Voir Profil
                    </a>
                    <a href="messages.php?to=playerE" class="btn-contact-player">
                        <i class="fas fa-comment"></i> Contacter
                    </a>
                </div>
            </div>
            
            <!-- Player 6 -->
            <div class="profile-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/dc3545/ffffff?text=Joueur+F" alt="Profil de Joueur F">
                </div>
                <div class="card-content">
                    <h3>Chiamaka Okeke</h3>
                    <div class="player-details">
                        <span class="detail-item"><i class="fas fa-bullseye"></i> Avant-Centre</span>
                        <span class="detail-item"><i class="fas fa-birthday-cake"></i> 23 ans</span>
                        <span class="detail-item"><i class="fas fa-globe-africa"></i> Nigériane</span>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="view_player_profile.php?id=playerF" class="btn-view-profile">
                        <i class="fas fa-eye"></i> Voir Profil
                    </a>
                    <a href="messages.php?to=playerF" class="btn-contact-player">
                        <i class="fas fa-comment"></i> Contacter
                    </a>
                </div>
            </div>

            <!-- Player 7 -->
            <div class="profile-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/8b5cf6/ffffff?text=Joueur+G" alt="Profil de Joueur G">
                </div>
                <div class="card-content">
                    <h3>Yusuf Kamara</h3>
                    <div class="player-details">
                        <span class="detail-item"><i class="fas fa-code-branch"></i> Milieu Offensif</span>
                        <span class="detail-item"><i class="fas fa-birthday-cake"></i> 17 ans</span>
                        <span class="detail-item"><i class="fas fa-globe-africa"></i> Sierra-Léonais</span>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="view_player_profile.php?id=playerG" class="btn-view-profile">
                        <i class="fas fa-eye"></i> Voir Profil
                    </a>
                    <a href="messages.php?to=playerG" class="btn-contact-player">
                        <i class="fas fa-comment"></i> Contacter
                    </a>
                </div>
            </div>

            <!-- Player 8 -->
            <div class="profile-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/f43f5e/ffffff?text=Joueur+H" alt="Profil de Joueur H">
                </div>
                <div class="card-content">
                    <h3>Amari Mbengue</h3>
                    <div class="player-details">
                        <span class="detail-item"><i class="fas fa-running"></i> Arrière Latéral</span>
                        <span class="detail-item"><i class="fas fa-birthday-cake"></i> 23 ans</span>
                        <span class="detail-item"><i class="fas fa-globe-africa"></i> Sénégalais</span>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="view_player_profile.php?id=playerH" class="btn-view-profile">
                        <i class="fas fa-eye"></i> Voir Profil
                    </a>
                    <a href="messages.php?to=playerH" class="btn-contact-player">
                        <i class="fas fa-comment"></i> Contacter
                    </a>
                </div>
            </div>

             <!-- Player 9 -->
            <div class="profile-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/a0e7e5/000000?text=Joueur+I" alt="Profil de Joueur I">
                </div>
                <div class="card-content">
                    <h3>Omar Sidibe</h3>
                    <div class="player-details">
                        <span class="detail-item"><i class="fas fa-futbol"></i> Milieu Défensif</span>
                        <span class="detail-item"><i class="fas fa-birthday-cake"></i> 19 ans</span>
                        <span class="detail-item"><i class="fas fa-globe-africa"></i> Malien</span>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="view_player_profile.php?id=playerI" class="btn-view-profile">
                        <i class="fas fa-eye"></i> Voir Profil
                    </a>
                    <a href="messages.php?to=playerI" class="btn-contact-player">
                        <i class="fas fa-comment"></i> Contacter
                    </a>
                </div>
            </div>

            <!-- Player 10 -->
            <div class="profile-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/7a5230/ffffff?text=Joueur+J" alt="Profil de Joueur J">
                </div>
                <div class="card-content">
                    <h3>Aya Cissé</h3>
                    <div class="player-details">
                        <span class="detail-item"><i class="fas fa-shield-alt"></i> Défenseur Central</span>
                        <span class="detail-item"><i class="fas fa-birthday-cake"></i> 22 ans</span>
                        <span class="detail-item"><i class="fas fa-globe-africa"></i> Ivoirienne</span>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="view_player_profile.php?id=playerJ" class="btn-view-profile">
                        <i class="fas fa-eye"></i> Voir Profil
                    </a>
                    <a href="messages.php?to=playerJ" class="btn-contact-player">
                        <i class="fas fa-comment"></i> Contacter
                    </a>
                </div>
            </div>
            <!-- Message if no results are found (initially hidden by JS later) -->
            <!-- <div class="no-results">
                <i class="fas fa-exclamation-circle"></i>
                <p>Aucun profil ne correspond à votre recherche pour le moment.</p>
                <p>Essayez d'ajuster vos filtres.</p>
            </div> -->
        </div>

    </main>

    <!-- Menu de navigation fixe en bas - Utilise les styles globaux -->
    <nav class="bottom-nav">
        <a href="index.php" class="nav-item">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
        <a href="recherche.php" class="nav-item active">
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
        <a href="liste.php" class="nav-item"> <!-- Lien placeholder pour une future fonctionnalité -->
            <i class="fas fa-list"></i>
            <span>Listes</span>
        </a>
    </nav>
</body>
</html>
