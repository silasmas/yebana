<?php
include('../db.php');
if (isset($_SESSION['nom'],$_SESSION['prenom'],$_SESSION['mail'],$_SESSION['reference'])) {
    if($_SESSION['acces'] === 'Agent'){

        $recuperation_jouers = $db->prepare('SELECT * FROM `jouers` WHERE (agent = ?) ORDER BY id DESC');
        $recuperation_jouers->execute(array($_SESSION['reference']));
        $nbr_jouers = $recuperation_jouers->rowCount();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA - Profil Agent Commercial</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables et styles de base) -->
    <link rel="stylesheet" href="../style.css"> <!-- Adjusted path for subfolder -->
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour le header et le menu de navigation) -->
    <link rel="stylesheet" href="../soccer/soccer.css"> <!-- Adjusted path for subfolder -->

    <!-- Inline styles specific to the agent profile page -->
    <style>
        /* ==================================== */
        /* Styles spécifiques pour la page Profil Agent Commercial */
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

        .agent-profile-main {
            flex-grow: 1; /* Allows content to expand */
            width: 100%;
            max-width: 800px; /* Max width for profile display */
            margin: 25px auto; /* Center the content and add some top margin */
            padding: 0 20px; /* Side padding */
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            gap: 25px; /* Space between sections */
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
            border: 5px solid var(--secondary-color); /* Agent specific color */
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .profile-header-card h1 {
            font-size: 2.2em;
            color: var(--dark-text-color);
            margin: 0 0 10px 0;
        }

        .profile-header-card .agent-meta {
            font-size: 1.1em;
            color: var(--medium-text-color);
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px; /* Space between meta info */
        }

        .profile-header-card .agent-meta span {
            display: inline-flex;
            align-items: center;
            background-color: var(--light-bg-color);
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid var(--border-color);
        }
        .profile-header-card .agent-meta i {
            margin-right: 8px;
            color: var(--secondary-color); /* Agent specific icon color */
        }

        .profile-header-card .agent-bio {
            font-size: 1em;
            color: var(--dark-text-color);
            line-height: 1.6;
            margin-bottom: 25px;
            max-width: 600px;
        }

        .edit-profile-btn {
            background: linear-gradient(45deg, var(--primary-color), #0056b3);
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
            box-shadow: 0 5px 15px var(--primary-shadow-color);
        }
        .edit-profile-btn i {
            margin-right: 10px;
        }
        .edit-profile-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--primary-shadow-color);
        }


        /* General section styling - Reusing from player profile for consistency */
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

        /* Detail grid - Reusing from player profile */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Adjusted min-width for agents */
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


        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            .agent-profile-main {
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
            .profile-header-card .agent-meta {
                font-size: 0.95em;
                flex-direction: column; /* Stack details vertically */
                gap: 8px; /* Space between stacked details */
            }
            .profile-header-card .agent-meta span {
                width: 100%; /* Full width when stacked */
                justify-content: center; /* Center content in stacked pills */
                padding: 10px;
            }
            .profile-header-card .agent-bio {
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
        }
        @media (max-width: 480px) {
            .profile-header-card h1 {
                font-size: 1.6em;
            }
            .agent-profile-main {
                padding: 0 10px;
            }
        }
    </style>
</head>
<body>
    <!-- App Header - Uses global header styles from soccer.css -->
    <header class="app-header">
        <div class="header-content">
            <div class="header-logo">
                <i class="fas fa-user-circle"></i>
                <span>Mon Profil</span>
            </div>
            <div class="header-user">
                <!-- Links for public actions or user options -->
                <a href="../logout.php" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </div>
    </header>

    <main class="agent-profile-main">
        <!-- Agent Profile Header Section -->
        <div class="profile-header-card">
            <img src="https://placehold.co/120x120/28a745/ffffff?text=Agent" alt="Photo de profil de l'agent" class="profile-pic-large">
            <h1><?php echo $_SESSION['nom'].' '.$_SESSION['prenom'] ?></h1>
            <div class="agent-meta">
                <span><i class="fas fa-id-badge"></i> Agent Commercial</span>
                <span><i class="fas fa-map-marker-alt"></i> Kinshasa, RDC</span>
                <span><i class="fas fa-phone"></i> <?php echo $_SESSION['contact'] ?></span>
                <span><i class="fas fa-envelope"></i> <?php echo $_SESSION['mail']?></span>
            </div>
            <p class="agent-bio">Agent commercial expérimenté pour YEBANA, spécialisé dans la détection et l'enregistrement de jeunes talents footballistiques en République Démocratique du Congo. Engagement à trouver les futures stars du continent.</p>
            <button class="edit-profile-btn"><i class="fas fa-edit"></i> Modifier le Profil</button>
        </div>

        <!-- Professional Details Section -->
        <div class="profile-section-card">
            <h2><i class="fas fa-briefcase"></i> Détails Professionnels</h2>
            <div class="details-grid">
                <div class="detail-item-view">
                    <strong>Zone d'Opération :</strong>
                    <span><i class="fas fa-globe"></i> Région de Kinshasa</span>
                </div>
                <div class="detail-item-view">
                    <strong>Spécialisation :</strong>
                    <span><i class="fas fa-futbol"></i> Dépistage de Jeunes Talents</span>
                </div>
                <div class="detail-item-view">
                    <strong>Joueurs Enregistrés :</strong>
                    <span><i class="fas fa-user-friends"></i> <?php echo $nbr_jouers?></span>
                </div>
                <div class="detail-item-view">
                    <strong>Date d'Adhésion :</strong>
                    <span><i class="fas fa-calendar-plus"></i> <?php echo $_SESSION['date_adhesion']?></span>
                </div>
            </div>
        </div>

        <!-- Contact Preferences / Notes (Example section for future use) -->
        <div class="profile-section-card">
            <h2><i class="fas fa-address-book"></i> Informations de Contact</h2>
            <div class="details-grid">
                <div class="detail-item-view">
                    <strong>Téléphone Secondaire :</strong>
                    <span><i class="fas fa-phone-square"></i> <?php echo $_SESSION['contact'] ?></span>
                </div>
                <div class="detail-item-view">
                    <strong>Adresse :</strong>
                    <span><i class="fab fa-linkedin"></i> <a href="#" target="_blank" style="color: var(--primary-color); text-decoration: none;"><?php echo $_SESSION['adresse_physique'] ?></a></span>
                </div>
                 <div class="detail-item-view">
                    <strong>WhatsApp :</strong>
                    <span><i class="fab fa-whatsapp"></i> <?php echo $_SESSION['contact_whatsapp'] ?></span>
                </div>
                 <div class="detail-item-view">
                    <strong>Langues :</strong>
                    <span><i class="fas fa-language"></i> Français, Lingala, Anglais</span>
                </div>
            </div>
        </div>

    </main>

    <!-- Bottom fixed navigation menu - Uses global navigation styles from soccer.css -->
    <nav class="bottom-nav">
        <a href="enregistrement.php" class="nav-item">
            <i class="fas fa-user-plus"></i>
            <span>Enregistrement</span>
        </a>
        <a href="recherche_filtrer.php" class="nav-item">
            <i class="fas fa-search"></i>
            <span>Recherche</span>
        </a>
        <a href="#" class="nav-item active">
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
<?php
    }
    else {
        header('location:../login.php');
    }
}
else {
    header('location:../login.php');
}
