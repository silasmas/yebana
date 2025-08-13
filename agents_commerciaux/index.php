<?php
include('../db.php');
if (isset($_SESSION['nom'],$_SESSION['prenom'],$_SESSION['mail'],$_SESSION['reference'])) {
    if($_SESSION['acces'] === 'Agent'){

        if (isset($_POST['annee'],$_POST['mois']) AND !empty($_POST['annee'])) {

            $annee = htmlspecialchars($_POST['annee']);
            $mois = htmlspecialchars($_POST['mois']);

            $recuperation_joueurs_attente = $db->prepare('SELECT * FROM `pre_enregistrement` WHERE (agent = ?) AND YEAR(date_enregistrement) = ? AND MONTH(date_enregistrement) = ?');
            $recuperation_joueurs_attente->execute(array($_SESSION['reference'],$annee,$mois));
            
            $recuperation_joueurs = $db->prepare('SELECT * FROM `jouers` WHERE (agent = ?) AND YEAR(date_enregistrement) = ? AND MONTH(date_enregistrement) = ?');
            $recuperation_joueurs->execute(array($_SESSION['reference'],$annee,$mois));

            $nbr_joueurs_attente = $recuperation_joueurs_attente->rowCount();
            $nbr_joueurs = $recuperation_joueurs->rowCount();

        } else {
            # code...
        }
        
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA - Rapports de Performance</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables et styles de base) -->
    <link rel="stylesheet" href="../style.css"> <!-- Adjusted path for subfolder -->
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour le header et le menu de navigation) -->
    <link rel="stylesheet" href="../soccer/soccer.css"> <!-- Adjusted path for subfolder -->

    <!-- Inline styles specific to the agent reports page -->
    <style>
        /* ==================================== */
        /* Styles spécifiques pour la page Rapports Agent Commercial */
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

        .agent-reports-main {
            flex-grow: 1; /* Allows content to expand */
            width: 100%;
            max-width: 900px; /* Max width for report display */
            margin: 25px auto; /* Center the content and add some top margin */
            padding: 0 20px; /* Side padding */
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            gap: 25px; /* Space between sections */
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

        .report-card {
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 25px;
            text-align: left;
        }

        .report-card h2 {
            font-size: 1.8em;
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-weight: 600;
        }

        .report-card h2 i {
            margin-right: 10px;
            font-size: 1em;
        }

        /* Filter Form Specific Styles */
        .filter-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .filter-form-grid .form-group {
            margin-bottom: 0; /* Reset default margin */
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

        .filter-actions .btn-generate {
            background: linear-gradient(45deg, var(--secondary-color), #218838);
            color: var(--white-color);
        }
        .filter-actions .btn-generate:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px var(--secondary-shadow-color);
        }

        .filter-actions .btn-reset {
            background-color: var(--light-bg-color);
            color: var(--dark-text-color);
            border: 1px solid var(--border-color);
        }
        .filter-actions .btn-reset:hover {
            transform: translateY(-2px);
            background-color: var(--hover-bg-color);
        }

        /* Report Metrics Display Styles (Reusing detail-grid) */
        .report-metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .metric-item {
            background-color: var(--light-bg-color);
            padding: 20px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .metric-item .icon {
            font-size: 2.5em;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .metric-item .value {
            font-size: 2em;
            font-weight: 700;
            color: var(--dark-text-color);
            margin-bottom: 5px;
        }

        .metric-item .label {
            font-size: 0.95em;
            color: var(--medium-text-color);
        }

        /* Detailed Stats/Chart Placeholder */
        .chart-placeholder {
            width: 100%;
            height: 300px;
            background-color: var(--light-bg-color);
            border: 1px dashed var(--border-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--medium-text-color);
            font-size: 1.1em;
            margin-top: 20px;
            box-shadow: inset 0 0 5px rgba(0,0,0,0.05);
        }
        .chart-placeholder i {
            margin-right: 10px;
            font-size: 1.5em;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .agent-reports-main {
                margin: 20px auto;
                padding: 0 15px;
            }
            .section-title {
                font-size: 1.8em;
            }
            .report-card {
                padding: 20px;
            }
            .report-card h2 {
                font-size: 1.5em;
            }
            .filter-form-grid {
                grid-template-columns: 1fr; /* Single column on mobile */
                gap: 15px;
            }
            .filter-form-grid input, .filter-form-grid select {
                font-size: 0.95em;
                padding: 10px;
            }
            .filter-actions {
                flex-direction: column; /* Stack buttons vertically */
                align-items: stretch; /* Stretch buttons to full width */
                gap: 10px;
            }
            .filter-actions button {
                width: 100%;
                font-size: 0.95em;
                padding: 10px 20px;
            }
            .report-metrics-grid {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); /* More compact metrics on mobile */
                gap: 15px;
            }
            .metric-item {
                padding: 15px;
            }
            .metric-item .icon {
                font-size: 2em;
            }
            .metric-item .value {
                font-size: 1.6em;
            }
            .metric-item .label {
                font-size: 0.85em;
            }
            .chart-placeholder {
                height: 200px;
                font-size: 1em;
            }
        }

        @media (max-width: 480px) {
            .section-title {
                font-size: 1.6em;
            }
            .report-card h2 {
                font-size: 1.3em;
            }
            .metric-item .icon {
                font-size: 1.8em;
            }
            .metric-item .value {
                font-size: 1.4em;
            }
            .metric-item .label {
                font-size: 0.8em;
            }
        }
    </style>
</head>
<body>
    <!-- App Header - Uses global header styles from soccer.css -->
    <header class="app-header">
        <div class="header-content">
            <div class="header-logo">
                <i class="fas fa-chart-pie"></i>
                <span>Rapports de Performance</span>
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

    <main class="agent-reports-main">
        <h2 class="section-title">Générer un Rapport de Performance</h2>

        <!-- Filter Form Card -->
        <div class="report-card">
            <h2><i class="fas fa-calendar-alt"></i> Période du Rapport</h2>
            <form action="" method="POST" id="reportFilterForm">
                <div class="filter-form-grid">
                    <div class="form-group">
                        <label for="period_select"><i class="fas fa-clock"></i> Année :</label>
                        <select id="period_select" name="annee">
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mois"><i class="fas fa-calendar-day"></i> Mois :</label>
                        <input type="number" id="mois" name="mois">
                    </div>
                </div>
                <div class="filter-actions">
                    <button type="reset" class="btn-reset"><i class="fas fa-redo-alt"></i> Réinitialiser</button>
                    <button type="submit" class="btn-generate"><i class="fas fa-chart-line"></i> Générer le Rapport</button>
                </div>
            </form>
        </div>

        <h2 class="section-title">Résumé des Performances</h2>

        <!-- Performance Summary Card -->
        <?php
            if(isset($nbr_joueurs) AND ($nbr_joueurs >= 0)){
        ?>
        <div class="report-card">
            <h2><i class="fas fa-tachometer-alt"></i> Aperçu Général</h2>
            <div class="report-metrics-grid">
                <div class="metric-item">
                    <i class="fas fa-user-plus icon"></i>
                    <span class="value"><?php echo $nbr_joueurs_attente ?></span>
                    <span class="label"> Enregistrements en Attente</span>
                </div>
                
                <div class="metric-item">
                    <i class="fas fa-handshake icon"></i>
                    <span class="value"><?php echo $nbr_joueurs ?></span>
                    <span class="label">Placements Réussis</span>
                </div>
                <!--
                <div class="metric-item">
                    <i class="fas fa-hourglass-half icon"></i>
                    <span class="value">30 Jours</span>
                    <span class="label">Délai Moyen Enregistrement-Placement</span>
                </div>
                <div class="metric-item">
                    <i class="fas fa-futbol icon"></i>
                    <span class="value">150</span>
                    <span class="label">Matchs Suivis</span>
                </div>
                -->
            </div>
        </div>
        <?php
            }
        ?>

        
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
        <a href="profil_agent.php" class="nav-item">
            <i class="fas fa-user-circle"></i>
            <span>Profil</span>
        </a>
        <a href="index.php" class="nav-item active">
            <i class="fas fa-chart-pie"></i>
            <span>Rapports</span>
        </a>
    </nav>

    <script>
        // JavaScript for enabling/disabling custom date inputs based on select value
        const periodSelect = document.getElementById('period_select');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        
    </script>
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