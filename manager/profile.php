<?php
include('../db.php');
if (isset($_SESSION['nom'],$_SESSION['prenom'],$_SESSION['mail'],$_SESSION['reference'])) {
    if($_SESSION['acces'] === 'manager'){

    $recuperation_manager = $db->prepare('SELECT * FROM `jouers` WHERE reference_manager = ? OR contact_manager = ?');
    $recuperation_manager->execute(array($_SESSION['reference'],$_SESSION['contact']));

    $nbr_joueurs = $recuperation_manager->rowCount();

        
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA - Mon Profil Manager</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables de couleur et styles de base) -->
    <link rel="stylesheet" href="../style.css">
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour le header et le menu de navigation) -->
    <link rel="stylesheet" href="../soccer/soccer.css">

    <!-- Styles en ligne spécifiques à la page de profil du manager -->
    <style>
        /* ==================================== */
        /* Styles spécifiques pour la page Profil du Manager */
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

        .manager-profile-main {
            flex-grow: 1; /* Permet au contenu de s'étendre */
            width: 100%;
            max-width: 800px; /* Largeur maximale pour l'affichage du profil */
            margin: 25px auto; /* Centre le contenu et ajoute une marge supérieure */
            padding: 0 20px; /* Rembourrage latéral */
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            gap: 25px; /* Espace entre les sections */
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
            position: relative;
        }

        .profile-header-card .profile-pic-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 5px solid var(--primary-color); /* Couleur spécifique au manager */
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .profile-header-card h1 {
            font-size: 2.2em;
            color: var(--dark-text-color);
            margin: 0 0 10px 0;
        }

        .profile-header-card .manager-meta {
            font-size: 1.1em;
            color: var(--medium-text-color);
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px; /* Espace entre les informations meta */
        }

        .profile-header-card .manager-meta span {
            display: inline-flex;
            align-items: center;
            background-color: var(--light-bg-color);
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid var(--border-color);
        }
        .profile-header-card .manager-meta i {
            margin-right: 8px;
            color: var(--primary-color); /* Couleur d'icône spécifique au manager */
        }

        .profile-header-card .manager-bio {
            font-size: 1em;
            color: var(--dark-text-color);
            line-height: 1.6;
            margin-bottom: 25px;
            max-width: 600px;
        }

        .edit-profile-btn {
            background: linear-gradient(45deg, var(--secondary-color), #218838); /* Vert pour l'édition */
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
        .edit-profile-btn i {
            margin-right: 10px;
        }
        .edit-profile-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--secondary-shadow-color);
        }


        /* Style général des sections - Réutilisé du profil d'agent pour la cohérence */
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

        /* Grille de détails - Réutilisée du profil d'agent */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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


        /* Requêtes média pour la réactivité */
        @media (max-width: 768px) {
            .manager-profile-main {
                margin: 20px auto;
                padding: 0 15px;
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
            .profile-header-card .manager-meta {
                font-size: 0.95em;
                flex-direction: column; /* Empile les détails verticalement */
                gap: 8px; /* Espace entre les détails empilés */
            }
            .profile-header-card .manager-meta span {
                width: 100%; /* Pleine largeur lorsque empilé */
                justify-content: center; /* Centre le contenu dans les pilules empilées */
                padding: 10px;
            }
            .profile-header-card .manager-bio {
                font-size: 0.95em;
            }
            .edit-profile-btn {
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
                grid-template-columns: 1fr; /* Colonne unique sur mobile */
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
        }
        @media (max-width: 480px) {
            .profile-header-card h1 {
                font-size: 1.6em;
            }
            .manager-profile-main {
                padding: 0 10px;
            }
        }
    </style>
</head>
<body>
    <!-- En-tête de l'application - Utilise les styles globaux -->
    <header class="app-header">
        <div class="header-content">
            <div class="header-logo">
                <i class="fas fa-user-circle"></i>
                <span>Mon Profil Manager</span>
            </div>
            <div class="header-user">
                <!-- Bouton de déconnexion -->
                <a href="logout.php" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </div>
    </header>

    <main class="manager-profile-main">
        <!-- Section d'en-tête du profil Manager -->
        <div class="profile-header-card">
            <img src="../profil_soccer/<?= $_SESSION['profil']?>" alt="Photo de profil du manager" class="profile-pic-large">
            <h1><?= $_SESSION['nom'].' '.$_SESSION['prenom'] ?></h1>
            <div class="manager-meta">
                <span><i class="fas fa-id-badge"></i> Manager de Joueurs</span>
                <span><i class="fas fa-phone"></i> <?= $_SESSION['contact']?></span>
                <span><i class="fas fa-envelope"></i> <?= $_SESSION['mail']?></span>
            </div>
            <p class="manager-bio">Manager de football expérimentée, passionnée par la détection et le développement de talents africains. Engagée à ouvrir des portes vers les ligues internationales pour les jeunes joueurs prometteurs.</p>
            <button class="edit-profile-btn"><i class="fas fa-edit"></i> Modifier le Profil</button>
        </div>

        <!-- Section: Détails Professionnels -->
        <div class="profile-section-card">
            <h2><i class="fas fa-briefcase"></i> Détails Professionnels</h2>
            <div class="details-grid">
                <div class="detail-item-view">
                    <strong>Expérience :</strong>
                    <span><i class="fas fa-clock"></i> 8 ans</span>
                </div>
                <div class="detail-item-view">
                    <strong>Licence FIFA :</strong>
                    <span><i class="fas fa-check-circle"></i> Oui (Numéro ABC123DEF)</span>
                </div>
                <div class="detail-item-view">
                    <strong>Joueurs Gérés Actuellement :</strong>
                    <span><i class="fas fa-user-friends"></i> <?= $nbr_joueurs ?></span>
                </div>
                <div class="detail-item-view">
                    <strong>Placements Réussis :</strong>
                    <span><i class="fas fa-trophy"></i> 5</span>
                </div>
                <div class="detail-item-view">
                    <strong>Zones d'Intérêt :</strong>
                    <span><i class="fas fa-globe-africa"></i> Afrique de l'Ouest, Europe</span>
                </div>
                <div class="detail-item-view">
                    <strong>Langues Parlées :</strong>
                    <span><i class="fas fa-language"></i> Français, Anglais, Portugais</span>
                </div>
            </div>
        </div>

        <!-- Section: Historique et Réalisations (Exemple) -->
        <div class="profile-section-card">
            <h2><i class="fas fa-award"></i> Historique et Réalisations</h2>
            <div class="details-grid">
                 <div class="detail-item-view full-width">
                    <strong>Clubs Collaborés :</strong>
                    <span><i class="fas fa-shield-alt"></i> Olympique de Marseille, Sporting Lisbonne, ASEC Mimosas</span>
                </div>
                <div class="detail-item-view full-width">
                    <strong>Notes Spécifiques :</strong>
                    <span><i class="fas fa-info-circle"></i> Spécialisée dans la gestion de carrières post-académie. Réseau étendu en France et au Portugal.</span>
                </div>
            </div>
        </div>

    </main>

    <!-- Menu de navigation fixe en bas - Utilise les styles globaux -->
    <nav class="bottom-nav">
        <a href="index.php" class="nav-item">
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
        <a href="profile.php" class="nav-item active">
            <i class="fas fa-user-circle"></i>
            <span>Mon Profil</span>
        </a>
        <a href="liste.php" class="nav-item">
            <i class="fas fa-list"></i>
            <span>Listes</span>
        </a>
    </nav>

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