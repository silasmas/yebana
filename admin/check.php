<?php
include('../db.php');
$ligne_trouver = 0;
$nbr_recuperation = 0;


   if (isset($_POST['recherche'])) {
        $recherche = htmlspecialchars($_POST['recherche']);

        $recuperation = $db->prepare('SELECT * FROM `jouers` WHERE `nom` LIKE :recherche OR `position` LIKE :recherche OR `club` LIKE :recherche OR `pied` LIKE :recherche OR `contact` LIKE :recherche OR `date_enregistrement` LIKE :recherche');
        $recuperation->bindValue(':recherche',"%$recherche%");
        $recuperation->bindValue(':position',"%$recherche%");

        $recuperation->bindValue(':club',"%$recherche%");
        $recuperation->bindValue(':pied',"%$recherche%");
        $recuperation->bindValue(':contact',"%$recherche%");
        $recuperation->bindValue(':date_enregistrement',"%$recherche%");
        $recuperation->execute();
        
        $nbr_recuperation = $recuperation->rowCount();

    }else {
        $recherche = null;
    }
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de Performance Agents - Admin YEBANA</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="header">
        <h1>Recherche de Performance des Agents</h1>
    </div>

    <div class="container">
        <h2>Sélectionner une Date</h2>
        <form id="performanceSearchForm" method="POST">
            <div class="form-group" style="width:100%;">

                <input type="text" name="recherche" required placeholder="Entrez un numéro, nom, poste ou une equipe " id="search" style="width:100%;">
                
            </div>
            <button type="submit" class="btn-submit"><i class="fas fa-chart-line"></i> Afficher les Performances</button>
            <div id="searchMessage" class="message"></div>
        </form>

        <?php
        if ($ligne_trouver >= 0) {
            
        ?>
        <div id="performanceResults" class="agent-performance" style="">
            <h2>Liste des Joueurs conrespondant au <span id="selectedDate"> <?= $recherche ?> </span></h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th> Joueurs</th>
                        <th>Age</th>
                        <th>Equipe</th>
                        <th>Telephone</th>
                        <th>Mot de Passe </th>
                        </tr>
                </thead>
                <tbody id="agentDailyPerformanceBody">
                    <?php
                    $i = 1;
                    if ($nbr_recuperation > 0) {
                        while($donnees_joueurs = $recuperation->fetch()){

                        $date_naissance = $donnees_joueurs['age'];
                        $date_info = date_parse($date_naissance);
                        $naissance = $date_info['year'];
                        $date_actuel = date('Y');

                        $recuperation_user = $db->prepare('SELECT * FROM `utilisateurs` WHERE  (reference = ?) ');
                        $recuperation_user->execute(array($donnees_joueurs['reference']));
                        $users = $recuperation_user->fetch();


                        
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?php echo $donnees_joueurs['nom'].' '.$donnees_joueurs['prenom'] ?></td>
                            <td> <?php echo $date_actuel - $naissance.' ans' ?></td>
                            <td> <?php echo $donnees_joueurs['club'] ?> </td>
                            <td data-today="12"><?php echo $donnees_joueurs['contact']?></td>
                            <td data-total="150"><?php echo $users['mot_passe']?></td>
                        </tr>
                        <?php
                        $i = $i + 1;
                        }
                    }
                    else{
                    ?>
                    <tr><td colspan="6" style="text-align: center;">Aucun résulat trouver sur la date selectionner</td></tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        }
        ?>
    </div>

    <nav class="footer-nav">
        <a href="dashboard.php" class="nav-item">
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
        <a href="sollicitation.php" class="nav-item">
            <i class="fas fa-envelope-open-text"></i>
            <span>Sollicitation</span>
        </a>
    </nav>

    <script src="js/recherche.js"></script>
</body>
</html>