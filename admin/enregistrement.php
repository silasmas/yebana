<?php
include('../db.php');
if (isset($_SESSION['nom'],$_SESSION['prenom'],$_SESSION['mail'],$_SESSION['reference'])) {
    if($_SESSION['acces'] === 'admin'){
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer un Agent - Admin YEBANA</title>
    <link rel="stylesheet" href="css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .container{
            width: 60%;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Enregistrer un Nouvel Agent de Terrain</h1>
    </div>

    <div class="container">
        <h2>Informations de l'Agent</h2>
        <form id="agentRegistrationForm" class="registration-form">
            <div class="form-group">
                <label for="agentNom">Nom :</label>
                <input type="text" id="agentNom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="agentPrenom">Prénom :</label>
                <input type="text" id="agentPrenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="agentEmail">Email :</label>
                <input type="email" id="agentEmail" name="email" required>
            </div>
            <div class="form-group">
                <label for="agentTelephone">Téléphone :</label>
                <input type="tel" id="agentTelephone" name="telephone" required>
            </div>
            <div class="form-group">
                <label for="agentEquipe">Équipe (si applicable) :</label>
                <input type="text" id="agentEquipe" name="equipe">
            </div>
            <div class="form-group">
                <label for="agentLocalisation">Zone d'Opération / Ville :</label>
                <input type="text" id="agentLocalisation" name="localisation" required>
            </div>
            <div class="form-group">
                <label for="whatsapp">Contact Whatsapp :</label>
                <input type="text" id="whatsapp" name="whatsapp">
            </div>
            <div class="form-group">
                <label for="adresse">Commune/Quartier/Avenue/N° :</label>
                <input type="text" id="adresse" name="adresse" required>
            </div>
            
            <div id="message-patience" style="display: none; color: green; margin-top: 10px;">Veuillez patienter, connexion en cours...</div>
            <div id="message-erreur" style="display: none; color: red; margin-top: 10px;"></div>
            <div id="message-succes" style="display: none; color: green; margin-top: 10px;">Connexion établie avec succès !</div>

            <button type="submit" class="btn-submit"><i class="fas fa-user-plus"></i> Enregistrer l'Agent</button>
            <div id="formMessage" class="message"></div>
        </form>
    </div>
 
    <nav class="footer-nav">
        <a href="dashboard.php" class="nav-item">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <a href="enregistrement.php" class="nav-item active">
            <i class="fas fa-user-check"></i>
            <span>Enregistrement</span>
        </a>
        <a href="recherche.php" class="nav-item">
            <i class="fas fa-search"></i>
            <span>Recherche</span>
        </a>
        <a href="check.php" class="nav-item">
            <i class="fas fa-envelope-open-text"></i>
            <span>Sollicitation</span>
        </a>
    </nav>

    <script src="js/enregistrement.js"></script> </body>
</html>
<?php
    }else {
        header('location:../');
    }
}
else {
    header('location:../');
}