<?php
include('../db.php');
$ligne_trouver = 0;

    if(isset($_POST['year'],$_POST['month'],$_POST['day']) AND !empty($_POST['year'])){
        
        $year = strip_tags($_POST['year']);
        $month = strip_tags($_POST['month']);
        $day = strip_tags($_POST['day']);

        $query = "SELECT * FROM utilisateurs WHERE acces = 'Agent' ORDER BY equipe ASC";
        
        $recuperation_performances = $db->query($query);

        $ligne_trouver = $recuperation_performances->rowCount();
        
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
        <form id="performanceSearchForm" method="POST" class="search-form">
            <div class="form-group-inline">
                <div class="form-group">
                    <label for="searchDay">Jour :</label>
                    <select id="searchDay" name="day">
                        <?php for ($i = 0; $i <= 31; $i++){
                            if($i === 0){
                            ?>
                            <option value=""></option>
                            <?php
                            }else{
                            ?>
                            <option value="<?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>" >
                                <?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?>
                            </option>
                        <?php 
                            }
                        } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="searchMonth">Mois :</label>
                    <select id="searchMonth" name="month" required>
                        <?php
                        $months = [
                            '01' => 'Janvier', '02' => 'Février', '03' => 'Mars', '04' => 'Avril',
                            '05' => 'Mai', '06' => 'Juin', '07' => 'Juillet', '08' => 'Août',
                            '09' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre'
                        ];
                        foreach ($months as $num => $name):
                        ?>
                            <option value="<?php echo $num; ?>" <?php echo (date('m') == $num) ? 'selected' : ''; ?>>
                                <?php echo $name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="searchYear">Année :</label>
                    <select id="searchYear" name="year" required>
                        <?php
                        $currentYear = date('Y');
                        for ($i = $currentYear; $i >= $currentYear - 5; $i--): // 5 dernières années
                        ?>
                            <option value="<?php echo $i; ?>" <?php echo ($currentYear == $i) ? 'selected' : ''; ?>>
                                <?php echo $i; ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn-submit"><i class="fas fa-chart-line"></i> Afficher les Performances</button>
            <div id="searchMessage" class="message"></div>
        </form>

        <?php
        if ($ligne_trouver >= 0) {
            
        ?>
        <div id="performanceResults" class="agent-performance" style="">
            <h2>Performances des Agents du <span id="selectedDate"><?php echo $day.'/'.$month.'/'.$year ?></span></h2>
            <table>
                <thead>
                    <tr>
                        <th> Agent</th>
                        <th>Équipe</th>
                        <th>Nombres des Enregistrements </th>
                        </tr>
                </thead>
                <tbody id="agentDailyPerformanceBody">
                    <?php
                    if ($ligne_trouver >= 1) {
                        while($donnees = $recuperation_performances->fetch()){

                            $reference = $donnees['reference'];
                            
                            $query = "SELECT * FROM `jouers` WHERE 1";

                            if (!empty($year)) {
            
                                $query .= " AND  YEAR(date_enregistrement) = '$year' AND agent = '$reference' ";

                            }
                            if (!empty($month)) {
                                
                                $query .= " AND  MONTH(date_enregistrement) = '$month'";

                            }
                            if (!empty($day)) {
                                
                                $query .= " AND  DAY(date_enregistrement) = '$day'";

                            }
                            $recuperation_joueurs_enregistrer_par_agent_mois = $db->query($query);

                            $nbr_jouers_enregistrer_mois = $recuperation_joueurs_enregistrer_par_agent_mois->rowCount();

                            $donnes_agents = $recuperation_joueurs_enregistrer_par_agent_mois->fetch();

                            $nbr_enregistrements = $recuperation_joueurs_enregistrer_par_agent_mois->rowCount();

                        ?>
                        <tr>
                            <td><?php echo $donnees['nom'].' '.$donnees['prenom'] ?></td>
                            <td data-today="12"><?php echo $donnees['equipe']?></td>
                            <td data-total="150"><?php echo $nbr_enregistrements?></td>
                        </tr>
                        <?php
                        }
                    }
                    else{
                    ?>
                    <tr><td colspan="3">Aucun résulat trouver sur la date selectionner</td></tr>
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
        <a href="recherche.php" class="nav-item active">
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