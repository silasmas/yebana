<?php
include('../db.php');
if (isset($_SESSION['nom'],$_SESSION['prenom'],$_SESSION['mail'],$_SESSION['reference'])) {
    if($_SESSION['acces'] === 'joueur'){

        $recuperation_joueurs_enregistrer = $db->prepare('SELECT * FROM `jouers`WHERE reference = ?  LIMIT 1');
        $recuperation_joueurs_enregistrer->execute(array($_SESSION['reference']));
        
        $nbr_jouers_enregistrer = $recuperation_joueurs_enregistrer->rowCount();

        $donnees_joueur = $recuperation_joueurs_enregistrer->fetch();

        
        $recuperation_vues = $db->prepare('SELECT SUM(nombre) as nbr_views FROM `nombre_vues` WHERE (reference_jouers = ?)');
        $recuperation_vues->execute(array($donnees_joueur['reference']));
        $nbr_vues = $recuperation_vues->fetch();

        if ($nbr_jouers_enregistrer === 0) {
            
            header('location:complete_profile.php');

        }
       $_SESSION['id'] = $donnees_joueur['id']; 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA - Tableau de Bord Joueur</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (remonter d'un niveau) -->
    <link rel="stylesheet" href="../style.css">
    <!-- Lien vers le fichier CSS spécifique à la section soccer (dans le même dossier) -->
    <link rel="stylesheet" href="soccer.css">
</head>
<body>
    <!-- En-tête de la page -->
    <header class="app-header">
        <div class="header-content">
            <div class="header-logo">
                <i class="fas fa-futbol"></i>
                <span>YEBANA</span>
            </div>
            <div class="header-user">
                <!-- Image de profil ou icône utilisateur -->
                <i class="fas fa-user-circle"></i>
                <!-- Nom de l'utilisateur ou lien vers le profil -->
                <span>Mon Espace</span>
            </div>
        </div>
    </header>

    <!-- Contenu principal du tableau de bord -->
    <main class="dashboard-main" style="padding-bottom:100px;padding-top:100px;">
        <div class="dashboard-section profile-summary">
            <h2><span class="player-name"><?php echo $donnees_joueur['nom'].' '.$donnees_joueur['prenom']?></span> </h2>
            <div class="profile-stats-grid">
                <div class="stat-card">
                    <i class="fas fa-ruler-vertical"></i>
                    <h3><?php echo $donnees_joueur['taille']?></h3>
                    <p>178 cm</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-weight-hanging"></i>
                    <h3>Poids</h3>
                    <p><?php echo $donnees_joueur['poid']?> kg</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-crosshairs"></i>
                    <h3>Poste</h3>
                    <p><?php echo $donnees_joueur['position']?></p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Club</h3>
                    <p><?php echo $donnees_joueur['club']?></p>
                </div>
            </div>
        </div>

        <div class="dashboard-section recent-activity">
            <h2><i class="fas fa-chart-line"></i> Mes Activités Récentes</h2>
            <ul class="activity-list">
                <li><i class="fas fa-video"></i> Vidéo "Mes meilleurs buts" publiée.</li>
                <li><i class="fas fa-eye"></i> Profil consulté 15 fois cette semaine.</li>
                <li><i class="fas fa-envelope"></i> Nouveau solutation en cours.</li>
                <li><i class="fas fa-check-circle"></i> Statut "Vérifié" obtenu !</li>
            </ul>
        </div>

        <div class="dashboard-section quick-links">
            <h2><i class="fas fa-external-link-alt"></i> Accès Rapide</h2>
            <div class="links-grid">
                <a href="player_videos.php" class="quick-link-card">
                    <i class="fas fa-video"></i>
                    <span>Mes Vidéos</span>
                </a>
                <a href="player_photos.php" class="quick-link-card">
                    <i class="fas fa-chart-bar"></i>
                    <span>Mes Photos</span>
                </a>
                <a href="#" class="quick-link-card">
                    <i class="fas fa-users"></i>
                    <span>Vues <?= $nbr_vues['nbr_views'] ?></span>
                </a>
                <a href="#" class="quick-link-card">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Événements</span>
                </a>
            </div>
        </div>

        <!-- Section pour les "Talents du mois" - Exemple de contenu dynamique 
         
        <div class="dashboard-section featured-talents">
            <h2><i class="fas fa-star"></i> Talents à la Une</h2>
            <div class="talent-card">
                <img src="https://placehold.co/100x100/A0E7E5/000000?text=Joueur1" alt="Joueur 1" class="talent-img">
                <div class="talent-info"> Nouvelle div pour regrouper le nom et le club/poste 
                    <h3>Mbote Kalonji</h3>
                    <p>Attaquant - 18 ans - AS Vita Club</p>
                </div>
                <a href="#" class="btn btn-secondary">Voir profil</a>
            </div>
            <div class="talent-card">
                <img src="https://placehold.co/100x100/F0B27A/000000?text=Joueur2" alt="Joueur 2" class="talent-img">
                <div class="talent-info">
                    <h3>Fiston Ngoma</h3>
                    <p>Défenseur - 17 ans - Académie Espoir</p>
                </div>
                <a href="#" class="btn btn-secondary">Voir profil</a>
            </div>
        </div>
        ... (reste du code) ... 
        -->
    </main>

    <!-- Menu de navigation collé en bas -->
    <nav class="bottom-nav">
        <a href="index.php" class="nav-item active">
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
        <a href="explore.php" class="nav-item">
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
