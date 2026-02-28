<?php
include('db.php');
$ligne_trouver = 0;

if(isset($_POST['keyword'],$_POST['role'],$_POST['position'],$_POST['nationality'],$_POST['min_age'],$_POST['max_age'])){
        
    $keyword = strip_tags($_POST['keyword']);
    $role = strip_tags($_POST['role']);
    $position = strip_tags($_POST['position']);
    $nationality = strip_tags($_POST['nationality']);
    $min_age = strip_tags($_POST['min_age']);
    $max_age = strip_tags($_POST['max_age']);

    switch ($role) {
        case 'player':
            $query = "SELECT * FROM jouers WHERE 1";

            if (!empty($keyword)) {
                
                $query .= " AND (nom = '$keyword' OR prenom = '$keyword' OR Club = '$keyword')";

            }
            if (!empty($position)) {
                
                $query .= " AND position = '$position'";

            }
            if (!empty($nationality)) {
                
                $query .= " AND nationalite = '$nationality'";

            }
            if (!empty($min_age)) {
                $year = date('Y');

                $age_min_fltre = $year - $min_age;

                $query .= " AND YEAR(age) <= '$age_min_fltre'";
            }
            if (!empty($max_age)) {
                $year = date('Y');

                $age_max_fltre = $year - $max_age;

                $query .= " AND YEAR(age) >= '$age_max_fltre'";
            }
            
            $recuperation_infos_joueurs = $db->query($query);

            $ligne_trouver = $recuperation_infos_joueurs->rowCount();
            break;
        
        default:
            # code...
            break;
    }
}
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yebana - Recherche et Filtres</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables de couleur et styles de base) -->
    <link rel="stylesheet" href="style.css">
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour la nav et le header) -->
    <link rel="stylesheet" href="soccer/soccer.css">
     <link rel="shortcut icon" href="images/2000 2000.png" type="image/x-icon">

    <!-- Inline styles specific to the search and filter page -->
    <style>
        /* ==================================== */
        /* Styles spécifiques pour la page Recherche et Filtres */
        /* ==================================== */

        /* Override body styles from global CSS for this specific page */
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

        .search-filter-main {
            flex-grow: 1; /* Allows content to expand and push footer down */
            width: 100%;
            max-width: 1000px; /* Max width for search area and results */
            margin: 0 auto;
            padding: 25px 20px 50px 20px; /* Top padding and bottom padding for footer space */
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .section-title {
            font-size: 2.5em;
            color: var(--dark-text-color);
            text-align: center;
            margin-bottom: 20px; /* Reduced margin, as filter card will have its own padding */
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
            margin-bottom: 25px; /* Space if there are multiple cards */
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

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Responsive columns */
            gap: 20px; /* Space between filter items */
            margin-bottom: 20px;
        }

        .filter-grid .form-group {
            margin-bottom: 0; /* Reset default margin-bottom from .form-group */
        }

        .filter-grid input[type="text"],
        .filter-grid select,
        .filter-grid input[type="number"] {
            width: calc(100% - 24px); /* Full width minus padding/border */
            padding: 12px;
            border: 1px solid var(--input-border-color);
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1em;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .filter-grid select {
            appearance: none; /* Remove default arrow */
            background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"%3e%3cpolyline points="6 9 12 15 18 9"%3e%3c/polyline%3e%3c/svg%3e');
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 1em;
            padding-right: 40px;
        }

        .filter-actions {
            display: flex;
            justify-content: flex-end; /* Align buttons to the right */
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

        /* Results Grid - Reuses styles from showcase.html */
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

        .result-card .profile-details { /* Renamed from player-details to be more general */
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
        
        .result-card .btn-view-profile {
            background-color: var(--primary-color);
            color: var(--white-color);
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            font-size: 1em;
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

        .result-card .btn-view-profile i {
            margin-right: 8px;
        }

        .result-card .btn-view-profile:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
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
            .search-filter-main {
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
            .filter-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 15px;
            }
            .filter-grid input[type="text"],
            .filter-grid select,
            .filter-grid input[type="number"] {
                font-size: 0.95em;
                padding: 10px;
            }
            .filter-actions {
                flex-direction: column; /* Stack buttons vertically on smaller screens */
                align-items: stretch; /* Stretch buttons to full width */
            }
            .filter-actions button {
                width: 100%; /* Full width */
                font-size: 0.95em;
                padding: 10px 20px;
            }
            .results-grid {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); /* More compact results on medium screens */
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
            .result-card .btn-view-profile {
                font-size: 0.9em;
                padding: 8px 15px;
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
            .filter-grid {
                grid-template-columns: 1fr; /* Single column on mobile */
                gap: 15px;
            }
            .results-grid {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); /* 2 columns on small mobiles */
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
            .result-card .btn-view-profile {
                font-size: 0.8em;
                padding: 6px 12px;
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
            .section-title{
                font-size: 16px;
                padding-top: 50px;
            }
            form{
                padding: 5px;
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
                <!-- Links for public actions or user options -->
                <a href="login.php" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Connexion</span>
                </a>
            </div>
        </div>
    </header>

    <main class="search-filter-main">
        <h2 class="section-title">Rechercher et Filtrer des Profils</h2>

        <div class="filter-card">
            <h2><i class="fas fa-search-plus"></i> Options de Recherche</h2>
            <form action="" method="POST" class="filter-form">
                <div class="filter-grid">
                    <div class="form-group">
                        <label for="keyword"><i class="fas fa-keyboard"></i> Mot-clé :</label>
                        <input type="text" id="keyword" name="keyword" placeholder="Nom, club, bio...">
                    </div>

                    <input type="hidden" id="role" name="role" value="player">

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
                    
                    <!-- D'autres filtres peuvent être ajoutés ici (ex: pieds fort, taille, poids, etc.) -->
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
            

            <!-- Example Result Cards (similar to showcase/explore cards) -->
             <?php
             if ($ligne_trouver >= 1) {

                while($donnes_joueurs = $recuperation_infos_joueurs->fetch()){
                            
                    $date_naissance = $donnes_joueurs['age'];
                    $date_info = date_parse($date_naissance);
                    $naissance = $date_info['year'];
                    $date_actuel = date('Y');
                    $age_joueur = $date_actuel - $naissance;
                    ?>
                <div class="result-card">
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
                            <i class="fas fa-eye"></i> Voir Profil
                        </a>
                    </div>
                </div>
                    <?php
                    }
                }
                elseif ($ligne_trouver <= 0) {
                
                ?>
                
                <!-- Message if no results are found (initially hidden by JS later) -->
                <div class="no-results">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Aucun profil ne correspond à votre recherche pour le moment.</p>
                    <p>Essayez d'ajuster vos filtres.</p>
                </div> 
                <?php
                }
                ?>
            </div>

    </main>

    <!-- Bottom fixed navigation menu - Uses global navigation styles from soccer.css -->
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
        <a href="temoignages.html" class="nav-item">
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
