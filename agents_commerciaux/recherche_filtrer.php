<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA - Recherche & Modification (Agent)</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables et styles de base) -->
    <link rel="stylesheet" href="../style.css"> <!-- Adjusted path for subfolder -->
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour le header et le menu de navigation) -->
    <link rel="stylesheet" href="../soccer/soccer.css"> <!-- Adjusted path for subfolder -->

    <!-- Inline styles specific to the agent search page -->
    <style>
        /* ==================================== */
        /* Styles spécifiques pour la page Recherche Agents */
        /* ==================================== */

        /* Override body styles from global CSS */
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text-color);
            margin: 0;
            padding-top: var(--header-height); /* Space for the fixed header */
            padding-bottom: var(--bottom-nav-height); /* Space for the fixed bottom nav */
            background-color: var(--dashboard-bg); /* Consistent light background */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            box-sizing: border-box;
            overflow-x: hidden;
        }

        .agent-search-main {
            flex-grow: 1; /* Allows content to expand and push footer down */
            width: 100%;
            max-width: 1000px; /* Max width for search area and results */
            margin: 25px auto; /* Center the content and add some top margin */
            padding: 0 20px; /* Side padding */
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

        /* Results Grid - Reusing styles from showcase.html */
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }

        .result-card {
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

        .result-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .result-card .card-image-container {
            width: 100%;
            height: 150px;
            overflow: hidden;
            border-bottom: 1px solid var(--border-color);
        }

        .result-card .card-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .result-card:hover .card-image-container img {
            transform: scale(1.05);
        }

        .result-card .card-content {
            padding: 18px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .result-card h3 {
            margin: 0 0 10px 0;
            font-size: 1.4em;
            color: var(--dark-text-color);
            font-weight: 700;
        }

        .result-card .profile-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
            margin-bottom: 15px;
            font-size: 0.85em;
            color: var(--medium-text-color);
        }

        .result-card .detail-item {
            display: flex;
            align-items: center;
            background-color: var(--light-bg-color);
            padding: 3px 8px;
            border-radius: 20px;
            border: 1px solid var(--border-color);
            white-space: nowrap;
        }

        .result-card .detail-item i {
            margin-right: 5px;
            color: var(--primary-color);
            font-size: 0.8em;
        }
        
        /* New: Styles for edit button */
        .result-card .btn-edit-profile,
        .result-card .btn-view-profile {
            width: calc(100% - 16px); /* Adjusted for padding */
            background-color: var(--secondary-color); /* Greenish for edit */
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
            box-shadow: 0 4px 12px var(--secondary-shadow-color);
            margin-top: 10px; /* Space between content and button */
        }
        .result-card .btn-edit-profile:hover,
        .result-card .btn-view-profile:hover {
            background-color: #218838;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px var(--secondary-shadow-color);
        }
        .result-card .btn-edit-profile i,
        .result-card .btn-view-profile i {
            margin-right: 8px;
        }

        /* If both buttons are needed, adjust their layout */
        .result-card .card-actions {
            display: flex;
            flex-direction: column; /* Stack buttons */
            gap: 8px; /* Space between buttons */
            width: 100%;
            padding: 0 10px 18px 10px; /* Padding for the action area within the card */
            box-sizing: border-box;
        }
        /* Style for the "View Profile" button if it's primary for agents too */
        .result-card .btn-view-profile.primary-agent {
            background-color: var(--primary-color); /* Blue for view profile */
            box-shadow: 0 4px 12px var(--primary-shadow-color);
        }
        .result-card .btn-view-profile.primary-agent:hover {
            background-color: #0056b3;
            box-shadow: 0 6px 18px var(--primary-shadow-color);
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


        /* Media queries for responsiveness */
        @media (max-width: 900px) {
            .agent-search-main {
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
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 15px;
            }
            .result-card .card-image-container {
                height: 120px;
            }
            .result-card .card-content {
                padding: 15px;
            }
            .result-card h3 {
                font-size: 1.2em;
            }
            .result-card .profile-details {
                font-size: 0.8em;
            }
            .result-card .detail-item {
                padding: 2px 6px;
            }
            .result-card .btn-edit-profile,
            .result-card .btn-view-profile {
                font-size: 0.85em;
                padding: 8px 15px;
                width: calc(100% - 16px);
            }
            .result-card .card-actions {
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
                grid-template-columns: 1fr;
                gap: 15px;
            }
            .results-grid {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                gap: 10px;
            }
             .result-card .card-image-container {
                height: 100px;
            }
            .result-card .card-content {
                padding: 10px;
            }
            .result-card h3 {
                font-size: 1em;
            }
            .result-card .profile-details {
                font-size: 0.7em;
            }
            .result-card .detail-item {
                padding: 1px 4px;
            }
            .result-card .btn-edit-profile,
            .result-card .btn-view-profile {
                font-size: 0.8em;
                padding: 6px 12px;
                width: calc(100% - 12px); /* Adjusted for padding */
                margin-top: 8px;
            }
            .result-card .card-actions {
                padding: 0 6px 12px 6px; /* Adjusted padding */
                gap: 6px;
            }
        }
    </style>
</head>
<body>
    <!-- App Header - Uses global header styles from soccer.css -->
    <header class="app-header">
        <div class="header-content">
            <div class="header-logo">
                <i class="fas fa-search-plus"></i>
                <span>Recherche de Profils (Agent)</span>
            </div>
            <div class="header-user">
                <!-- Links for agents (e.g., Logout) -->
                <a href="../logout.php" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </div>
    </header>

    <main class="agent-search-main">
        <h2 class="section-title">Rechercher et Gérer les Profils</h2>

        <!-- Filter Form Card -->
        <div class="filter-card">
            <h2><i class="fas fa-filter"></i> Options de Filtrage</h2>
            <form action="#" method="GET" class="filter-form">
                <div class="filter-form-grid">
                    <div class="form-group">
                        <label for="keyword"><i class="fas fa-keyboard"></i> Mot-clé :</label>
                        <input type="text" id="keyword" name="keyword" placeholder="Nom, club, bio...">
                    </div>
                    
                    <div class="form-group">
                        <label for="role"><i class="fas fa-user-tag"></i> Type de Profil :</label>
                        <select id="role" name="role">
                            <option value="">Tous</option>
                            <option value="player">Joueur</option>
                            <option value="manager">Manager</option>
                            <option value="recruiter">Recruteur / Club</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="position"><i class="fas fa-crosshairs"></i> Poste (Joueur) :</label>
                        <select id="position" name="position">
                            <option value="">Tous les postes</option>
                            <option value="Gardien">Gardien</option>
                            <option value="Defenseur Central">Défenseur Central</option>
                            <option value="Lateral Droit">Latéral Droit</option>
                            <option value="Lateral Gauche">Latéral Gauche</option>
                            <option value="Milieu Defensif">Milieu Défensif</option>
                            <option value="Milieu Central">Milieu Central</option>
                            <option value="Milieu Offensif">Milieu Offensif</option>
                            <option value="Ailier Droit">Ailier Droit</option>
                            <option value="Ailier Gauche">Ailier Gauche</option>
                            <option value="Avant Centre">Avant-Centre</option>
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
                </div>

                <div class="filter-actions">
                    <button type="reset" class="btn-secondary-filter"><i class="fas fa-redo-alt"></i> Réinitialiser</button>
                    <button type="submit" class="btn-primary-filter"><i class="fas fa-search"></i> Rechercher</button>
                </div>
            </form>
        </div>

        <h2 class="section-title">Résultats de la Recherche</h2>

        <!-- Results Display Area -->
        <div class="results-grid">
            <!-- Example Result Cards (with Edit Button) -->
            <div class="result-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/007bff/ffffff?text=Joueur+A" alt="Profil de Joueur A">
                </div>
                <div class="card-content">
                    <h3>Abel Kasa</h3>
                    <div class="profile-details">
                        <span class="detail-item"><i class="fas fa-crosshairs"></i> Attaquant</span>
                        <span class="detail-item"><i class="fas fa-birthday-cake"></i> 20 ans</span>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="modification_joueur.php" class="btn-edit-profile">
                        <i class="fas fa-edit"></i> Éditer Profil
                    </a>
                    <a href="../view_player_profile.html?id=playerA" class="btn-view-profile primary-agent">
                        <i class="fas fa-eye"></i> Voir Profil
                    </a>
                </div>
            </div>

            <div class="result-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/28a745/ffffff?text=Manager+B" alt="Profil de Manager B">
                </div>
                <div class="card-content">
                    <h3>Fatima Zahra</h3>
                    <div class="profile-details">
                        <span class="detail-item"><i class="fas fa-briefcase"></i> Manager</span>
                        <span class="detail-item"><i class="fas fa-globe"></i> Marocaine</span>
                    </div>
                </div>
                <div class="card-actions">
                    <a href="#" class="btn-edit-profile">
                        <i class="fas fa-edit"></i> Éditer Profil
                    </a>
                    <a href="#" class="btn-view-profile primary-agent">
                        <i class="fas fa-eye"></i> Voir Profil
                    </a>
                </div>
            </div>

            <div class="result-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/6c757d/ffffff?text=Recruteur+C" alt="Profil de Recruteur C">
                </div>
                <div class="card-content">
                    <h3>Club Étoile</h3>
                    <div class="profile-details">
                        <span class="detail-item"><i class="fas fa-shield-alt"></i> Club</span>
                        <span class="detail-item"><i class="fas fa-map-marker-alt"></i> Dakar</span>
                    </div>
                </div>
                 <div class="card-actions">
                    <a href="#" class="btn-edit-profile">
                        <i class="fas fa-edit"></i> Éditer Profil
                    </a>
                    <a href="#" class="btn-view-profile primary-agent">
                        <i class="fas fa-eye"></i> Voir Profil
                    </a>
                </div>
            </div>

            <div class="result-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/dc3545/ffffff?text=Joueur+D" alt="Profil de Joueur D">
                </div>
                <div class="card-content">
                    <h3>Chris Okoro</h3>
                    <div class="profile-details">
                        <span class="detail-item"><i class="fas fa-futbol"></i> Milieu</span>
                        <span class="detail-item"><i class="fas fa-birthday-cake"></i> 18 ans</span>
                    </div>
                </div>
                 <div class="card-actions">
                    <a href="register_player.html?id=playerD" class="btn-edit-profile">
                        <i class="fas fa-edit"></i> Éditer Profil
                    </a>
                    <a href="../view_player_profile.html?id=playerD" class="btn-view-profile primary-agent">
                        <i class="fas fa-eye"></i> Voir Profil
                    </a>
                </div>
            </div>

            <div class="result-card">
                <div class="card-image-container">
                    <img src="https://placehold.co/400x220/17a2b8/ffffff?text=Joueur+E" alt="Profil de Joueur E">
                </div>
                <div class="card-content">
                    <h3>Zara Traoré</h3>
                    <div class="profile-details">
                        <span class="detail-item"><i class="fas fa-hand-paper"></i> Gardien</span>
                        <span class="detail-item"><i class="fas fa-globe-africa"></i> Malienne</span>
                    </div>
                </div>
                 <div class="card-actions">
                    <a href="register_player.html?id=playerE" class="btn-edit-profile">
                        <i class="fas fa-edit"></i> Éditer Profil
                    </a>
                    <a href="../view_player_profile.html?id=playerE" class="btn-view-profile primary-agent">
                        <i class="fas fa-eye"></i> Voir Profil
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

    <!-- Bottom fixed navigation menu - Uses global navigation styles from soccer.css -->
    <nav class="bottom-nav">
        <a href="enregistrement.php" class="nav-item">
            <i class="fas fa-user-plus"></i>
            <span>Enregistrement</span>
        </a>
        <a href="recherche_agent.html" class="nav-item active">
            <i class="fas fa-search"></i>
            <span>Recherche</span>
        </a>
        <a href="profil_agent.php" class="nav-item">
            <i class="fas fa-user-circle"></i>
            <span>Profil</span>
        </a>
        <a href="index.php" class="nav-item">
            <i class="fas fa-chart-pie"></i>
            <span>Rapports</span>
        </a>
    </nav>
</body>
</html>
