<?php
include('../db.php');
if (isset($_SESSION['nom'],$_SESSION['prenom'],$_SESSION['mail'],$_SESSION['reference'])) {
    if($_SESSION['acces'] === 'joueur'){

        $nbr_jouers_enregistrer = null;

        if (isset($_POST['query'],$_POST['position'])) {
           
            $query = htmlspecialchars($_POST['query']);
            $position = htmlspecialchars($_POST['position']);

            $recherche = "SELECT * FROM `jouers`WHERE 1";

            if (!empty($query)) {
            
                $recherche .= " AND  nom = '$query' OR prenom = '$query' ";

            }
            if (!empty($position)) {
                
                $recherche .= " AND  position = '$position'";

            }

            $recuperation_joueurs_enregistrer = $db->query($recherche);
            
            $nbr_jouers_enregistrer = $recuperation_joueurs_enregistrer->rowCount();

            
        }

        

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA - Explorer <?= $_SESSION['prenom'].' '.$_SESSION['nom'] ?></title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables et styles de base) -->
    <link rel="stylesheet" href="../style.css">
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour la nav et le header, car c'est une interface globale) -->
    <link rel="stylesheet" href="soccer.css">

    <!-- Inline styles specific to the explore page -->
    <style>
        /* ==================================== */
        /* Styles spécifiques pour la page Explorer */
        /* ==================================== */

        .explore-main {
            flex-grow: 1; /* Allows the main area to take available space */
            background-color: var(--dashboard-bg); /* Uses the soft dashboard background */
            width: 100%;
            max-width: 960px; /* Limits content width */
            margin: 0 auto; /* Centers content */
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            gap: 25px; /* Space between sections */
            padding-top: 80px;
        }

        .search-filter-area {
            background-color: var(--white-color);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-wrap: wrap; /* Allows wrapping on smaller screens */
            gap: 15px;
            align-items: center;
        }

        .search-filter-area input[type="text"] {
            flex-grow: 1; /* Takes available space */
            padding: 12px 15px;
            border: 1px solid var(--input-border-color);
            border-radius: 25px;
            font-size: 1em;
            box-sizing: border-box;
            min-width: 200px; /* Minimum width before wrapping */
        }

        .search-filter-area select {
            padding: 12px 15px;
            border: 1px solid var(--input-border-color);
            border-radius: 25px;
            background-color: var(--white-color);
            font-size: 1em;
            cursor: pointer;
            outline: none;
            appearance: none; /* Remove default arrow */
            background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"%3e%3cpolyline points="6 9 12 15 18 9"%3e%3c/polyline%3e%3c/svg%3e');
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 1em;
            padding-right: 40px; /* Space for the custom arrow */
        }

        .search-filter-area button {
            background: linear-gradient(45deg, var(--primary-color), #0056b3);
            color: var(--white-color);
            padding: 12px 20px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-filter-area button i {
            margin-right: 8px;
        }

        .search-filter-area button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px var(--primary-shadow-color);
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Responsive grid */
            gap: 25px; /* Space between cards */
        }

        .explore-card {
            background-color: var(--white-color);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden; /* Ensures rounded corners are respected for image */
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Pushes button to bottom */
        }

        .explore-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .card-image-container {
            width: 100%;
            height: 200px; /* Fixed height for consistent image size */
            overflow: hidden;
            border-bottom: 1px solid var(--border-color);
        }

        .card-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Cover the area, cropping if necessary */
        }

        .card-content {
            padding: 20px;
            flex-grow: 1; /* Allows content to expand */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card-content h3 {
            margin: 0 0 10px 0;
            font-size: 1.4em;
            color: var(--dark-text-color);
        }

        /* New styles for structured player details */
        .player-details {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping on small screens */
            justify-content: center; /* Center items horizontally */
            gap: 10px; /* Space between detail items */
            margin-bottom: 15px; /* Space before button */
            font-size: 0.95em;
            color: var(--medium-text-color);
        }

        .detail-item {
            display: flex;
            align-items: center;
            background-color: var(--light-bg-color); /* Light background for each detail */
            padding: 5px 10px;
            border-radius: 20px; /* Pill shape */
            border: 1px solid var(--border-color);
        }

        .detail-item i {
            margin-right: 5px;
            color: var(--primary-color); /* Icon color */
            font-size: 0.9em; /* Smaller icon size */
        }

        .explore-card .btn {
            width: calc(100% - 40px); /* Full width minus padding for button */
            margin-bottom: 20px; /* Space below button */
        }

        /* Adjustments for headers in main content area */
        .explore-main h2 {
            color: var(--primary-color);
            font-size: 1.8em;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            .explore-main {
                padding: 15px; /* Reduced padding on mobile */
                gap: 20px;
            }

            .search-filter-area {
                flex-direction: column; /* Stack elements vertically */
                align-items: stretch; /* Stretch to full width */
                padding: 15px;
            }

            .search-filter-area input[type="text"],
            .search-filter-area select,
            .search-filter-area button {
                width: 100%; /* Full width on mobile */
                min-width: unset; /* Reset min-width */
            }

            .content-grid {
                grid-template-columns: 1fr; /* Single column on mobile */
                gap: 20px;
            }

            .explore-card {
                padding-bottom: 0; /* Remove extra padding from bottom for mobile */
            }

            .card-content {
                padding: 15px;
            }

            .card-image-container {
                height: 180px; /* Slightly smaller image height on mobile */
            }

            .explore-card .btn {
                width: calc(100% - 30px); /* Adjust button width for mobile padding */
                margin-bottom: 15px;
            }

            .explore-main h2 {
                font-size: 1.5em;
                margin-bottom: 15px;
            }
            .player-details {
                font-size: 0.9em; /* Smaller font on mobile */
                gap: 8px; /* Slightly less gap on mobile */
            }
            .detail-item {
                padding: 4px 8px;
            }
        }
        @media (max-width: 480px) {
            .explore-main {
                padding: 10px;
            }
            .search-filter-area input[type="text"],
            .search-filter-area select,
            .search-filter-area button {
                font-size: 0.9em;
                padding: 10px 12px;
            }
        }
    </style>
</head>
<body>
    <!-- En-tête de la page -->
    <header class="app-header">
        <div class="header-content">
            <div class="header-logo">
                <i class="fas fa-compass"></i>
                <span>Explorer</span>
            </div>
            <div class="header-user">
                <!-- Icône pour un menu ou des options de l'utilisateur -->
                <i class="fas fa-ellipsis-v"></i>
                <span>Options</span>
            </div>
        </div>
    </header>

    <!-- Contenu principal de la page Explorer -->
    <main class="explore-main" style="padding-top:100px;padding-bottom:100px;">
        <div class="search-filter-area">
            <form action="" method="post" style="width:100%;">
                <input type="text" name="query" placeholder="Rechercher des joueurs, managers, clubs..." style="width:58%;">
                
                <select name="position" style="width:40%;">
                    <option value="">Poste</option>
                    <option value="Gardien">Gardien de But</option>
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
                <button><i class="fas fa-filter"></i> Filtrer</button>
            </form>
        </div>

        <h2>Talents à Découvrir</h2>

        <div class="content-grid">
            <!-- Exemple de carte de joueur -->
            <?php
            if($nbr_jouers_enregistrer >= 1 ){
                while ($donnees_joueur = $recuperation_joueurs_enregistrer->fetch()) {
            ?>
            <div class="explore-card">
                <div class="card-image-container">
                    <img src="../profil_soccer/<?= $donnees_joueur['profil'] ?>" alt="Profil joueur">
                </div>
                <div class="card-content">
                    <h3><?= $donnees_joueur['nom'].' '.$donnees_joueur['prenom']  ?></h3>
                    <div class="player-details">
                        <span class="detail-item"><i class="fas fa-crosshairs"></i> <?= $donnees_joueur['position'] ?></span>
                        <span class="detail-item"><i class="fas fa-birthday-cake"></i> 20 ans</span>
                        <span class="detail-item"><i class="fas fa-shield-alt"></i> <?= $donnees_joueur['club']?></span>
                    </div>
                    <a href="view_player_profile.php?joueur=<?= $donnees_joueur['reference'] ?>" class="btn btn-primary">Voir profil</a>
                </div>
            </div> 
            <?php
                    }
                }
                elseif($nbr_jouers_enregistrer === 0) {
                    echo '<p style="text-align:center;">Aucun résulat trouver </p>';
                }
            ?>
        </div>
    </main>

    <!-- Menu de navigation collé en bas -->
    <nav class="bottom-nav">
        <a href="index.php" class="nav-item">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
        <a href="view_player_profile.php?joueur=<?= $_SESSION['reference'] ?>" class="nav-item">
            <i class="fas fa-user"></i>
            <span>Profil</span>
        </a>
        <a href="select_position.html" class="nav-item"> <!-- This page will be active when on it -->
            <i class="fas fa-graduation-cap"></i> <!-- Changed icon to reflect learning/education -->
            <span>Apprendre</span> <!-- Changed text to reflect learning/education -->
        </a>
        <a href="explore.php" class="nav-item active">
            <i class="fas fa-search"></i>
            <span>Explorer</span>
        </a>
    </nav>
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
