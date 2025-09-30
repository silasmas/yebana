<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de Recruteurs - Admin YEBANA</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="header">
        <h1>Demandes de Recruteurs</h1>
    </div>

    <div class="container">
        <h2>Liste des Sollicitations</h2>
        <div class="sollicitations-table">
            <table>
                <thead>
                    <tr>
                        <th>ID Demande</th>
                        <th>Recruteur / Club</th>
                        <th>Email Recruteur</th>
                        <th>Joueur Sollicité (ID)</th>
                        <th>Date de la Demande</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="sollicitationsBody">
                    <tr>
                        <td>S001</td>
                        <td>Paris FC</td>
                        <td>contact@paris-fc.fr</td>
                        <td>JOU005 (Moussa Diallo)</td>
                        <td>24/06/2025 10:15</td>
                        <td><span class="status pending">En attente</span></td>
                        <td>
                            <button class="btn-action view" data-id="S001"><i class="fas fa-eye"></i> Voir</button>
                            <button class="btn-action resolve" data-id="S001"><i class="fas fa-check-double"></i> Résolue</button>
                        </td>
                    </tr>
                    <tr>
                        <td>S002</td>
                        <td>OGC Nice (Scout)</td>
                        <td>scout@ogcnice.com</td>
                        <td>JOU012 (Koffi Kouassi)</td>
                        <td>23/06/2025 18:40</td>
                        <td><span class="status resolved">Résolue</span></td>
                        <td>
                            <button class="btn-action view" data-id="S002"><i class="fas fa-eye"></i> Voir</button>
                            <button class="btn-action resolve" data-id="S002" disabled><i class="fas fa-check-double"></i> Résolue</button>
                        </td>
                    </tr>
                    <tr>
                        <td>S003</td>
                        <td>Olympique Marseille</td>
                        <td>recrutement@om.fr</td>
                        <td>JOU007 (Fati Coulibaly)</td>
                        <td>22/06/2025 09:00</td>
                        <td><span class="status pending">En attente</span></td>
                        <td>
                            <button class="btn-action view" data-id="S003"><i class="fas fa-eye"></i> Voir</button>
                            <button class="btn-action resolve" data-id="S003"><i class="fas fa-check-double"></i> Résolue</button>
                        </td>
                    </tr>
                    </tbody>
            </table>
            <div class="pagination">
                <a href="#">&laquo; Précédent</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">Suivant &raquo;</a>
            </div>
        </div>
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
        <a href="check.php" class="nav-item active">
            <i class="fas fa-envelope-open-text"></i>
            <span>Sollicitation</span>
        </a>
    </nav>

    <script src="js/sollicitation.js"></script>
</body>
</html>