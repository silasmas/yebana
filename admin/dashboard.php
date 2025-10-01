<?php
include('../db.php');
if (isset($_SESSION['nom'],$_SESSION['prenom'],$_SESSION['mail'],$_SESSION['reference'])) {
    if($_SESSION['acces'] == 'admin'){

        $recuperation_joueurs_enregistrer = $db->prepare('SELECT * FROM `jouers`WHERE date_enregistrement = ?  ORDER BY id DESC');
        $recuperation_joueurs_enregistrer->execute(array(date('Y-m-d')));
        $nbr_jouers_enregistrer = $recuperation_joueurs_enregistrer->rowCount();

        $recuperation_manager_enregistrer = $db->prepare('SELECT * FROM `utilisateurs` WHERE date_adhesion = ? AND (acces = ? OR acces = ?)  ORDER BY id DESC');
        $recuperation_manager_enregistrer->execute(array(date('Y-m-d'),'recruteur','manager'));
        $nbr_manager_enregistrer = $recuperation_manager_enregistrer->rowCount();

        $recuperation_nbr_joueurs = $db->prepare('SELECT * FROM `jouers`  ORDER BY id DESC');
        $recuperation_nbr_joueurs->execute(array());
        $nbr_global_joueurs = $recuperation_nbr_joueurs->rowCount();

        $recuperation_utilisateurs_agents = $db->prepare('SELECT * FROM `utilisateurs` WHERE acces = ?  ORDER BY id DESC');
        $recuperation_utilisateurs_agents->execute(array('Agent'));
        $nbr_utilisateurs_enregistrer = $recuperation_utilisateurs_agents->rowCount();

        ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin YEBANA</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="header">
        <h1>Dashboard Admin YEBANA</h1>
    </div>

    <div class="container">
        <h2>Statistiques Clés Aujourd'hui</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-user-plus icon-player"></i>
                <h3>Joueurs Enregistrés Aujourd'hui</h3>
                <p class="stat-value" id="playersToday"><?php echo $nbr_jouers_enregistrer ?></p>
            </div>
            <div class="stat-card">
                <i class="fas fa-users-cog icon-manager"></i>
                <h3>Managers Enregistrés Aujourd'hui</h3>
                <p class="stat-value" id="managersToday"><?php echo $nbr_manager_enregistrer ?></p>
            </div>
            <div class="stat-card">
                <i class="fas fa-handshake icon-recruiter"></i>
                <h3>Nombre Total des Joueurs</h3>
                <p class="stat-value" id="recruitersToday"><?php echo $nbr_global_joueurs ?></p>
            </div>
        </div>

        <h2>Enregistrements Journalier</h2>
        <div class="pending-registrations">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom Complet</th>
                        <th>Telephone</th>
                        <th>Date d'Enregistrement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="pendingRegistrationsBody">
                    <?php
                    while ($donnes_enregistrements_attente = $recuperation_joueurs_enregistrer->fetch()) {
                        
                    ?>
                    <tr>
                        <td><?php echo $donnes_enregistrements_attente['id'] ?></td>
                        <td><?php echo $donnes_enregistrements_attente['nom'].' '.$donnes_enregistrements_attente['prenom'] ?></td>
                        <td> <a href="https://wa.me/<?= $donnes_enregistrements_attente['contact']?>?text=Bonjour,<?= $donnes_enregistrements_attente['nom'].' '.$donnes_enregistrements_attente['prenom'] ?>.Votre compte est bien créer.votre telephone est : <?= $donnes_enregistrements_attente['contact']?> et mot de passe : 000000. Connectez-vous via https://yebana.cd/login.php" target="_black"><?php echo $donnes_enregistrements_attente['contact'] ?></a></td>
                        <td><?php echo $donnes_enregistrements_attente['date_enregistrement'].' '.$donnes_enregistrements_attente['heure_enregistrement'] ?></td>
                        
                        
                        <td>
                            <button class="btn-action approve"><i class="fas fa-check"></i> Approuver</button>
                            <button class="btn-action reject"><i class="fas fa-times"></i> Rejeter</button>
                            <button class="btn-action view"><i class="fas fa-eye"></i> Voir</button>
                        </td>
                        
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
            </table>

            <!--
            <div class="pagination">
                <a href="#">&laquo; Précédent</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">Suivant &raquo;</a>
            </div>
            -->
        </div>

        <!--
        <h2>Performance des Agents sur le Terrain</h2>
        <div class="agent-performance">
            <table>
                <thead>
                    <tr>
                        <th> Agent</th>
                        <th>Équipe</th>
                        <th>Enregistrements Aujourd'hui</th>
                        <th>Total Enregistrements du Mois</th>
                    </tr>
                </thead>
                <tbody id="agentPerformanceBody">
                    <?php
                    while ($donnes_agents = $recuperation_utilisateurs_agents->fetch()) {

                        $recuperation_joueurs_enregistrer_par_agent = $db->prepare('SELECT * FROM `jouers`WHERE date_enregistrement = ? AND agent = ?  ORDER BY id DESC');
                        $recuperation_joueurs_enregistrer_par_agent->execute(array(date('Y-m-d'),$donnes_agents['reference']));
                        $nbr_jouers_enregistrer = $recuperation_joueurs_enregistrer_par_agent->rowCount();

                        $recuperation_joueurs_enregistrer_par_agent_mois = $db->prepare('SELECT * FROM `jouers`WHERE YEAR(date_enregistrement) = ? AND MONTH(date_enregistrement) = ? AND agent = ?  ORDER BY id DESC');
                        $recuperation_joueurs_enregistrer_par_agent_mois->execute(array(date('Y'),date('m'),$donnes_agents['reference']));
                        $nbr_jouers_enregistrer_mois = $recuperation_joueurs_enregistrer_par_agent_mois->rowCount();

                    ?>
                    <tr>
                        <td><?php echo $donnes_agents['nom'].' '.$donnes_agents['prenom'] ?></td>
                        <td data-today="12"><?php echo $donnes_agents['equipe']?></td>
                        <td data-total="150"><?php echo $nbr_jouers_enregistrer?></td>
                        <td><?php echo $nbr_jouers_enregistrer_mois?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        -->
    </div>

    <nav class="footer-nav">
        <a href="dashboard.php" class="nav-item active">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="enregistrement.php" class="nav-item">
            <i class="fas fa-user-check"></i>
            <span>Enregistrement</span>
        </a>
        <a href="recherche.php" class="nav-item">
            <i class="fas fa-search"></i>
            <span>Recherche</span>
        </a>
        <a href="check.php" class="nav-item">
            <i class="fas fa-envelope-open-text"></i>
            <span>Check</span>
        </a>
    </nav>

    <script src="js/dashboard.js"></script>
</body>
</html>
<?php
    }else {
        header('location:../');
    }
}
else {
    header('location:../');
}