<?php
include('../db.php');
if (isset($_SESSION['nom'],$_SESSION['prenom'],$_SESSION['mail'],$_SESSION['reference'])) {
    if($_SESSION['acces'] === 'joueur'){

        if (isset($_GET['joueur']) AND !empty($_GET['joueur'])) {

            $reference = htmlspecialchars($_GET['joueur']);

        } else {
             header('location:index.php');
        }
        

        $recuperation_joueurs_enregistrer = $db->prepare('SELECT * FROM `jouers`WHERE reference = ?  LIMIT 1');
        $recuperation_joueurs_enregistrer->execute(array($reference));
        
        $nbr_jouers_enregistrer = $recuperation_joueurs_enregistrer->rowCount();

        $donnees_joueur = $recuperation_joueurs_enregistrer->fetch();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA - Profil de <?= $donnees_joueur['prenom'].' '.$donnees_joueur['nom'] ?></title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables et styles de base) -->
    <link rel="stylesheet" href="../style.css">
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour la nav et le header) -->
    <link rel="stylesheet" href="soccer.css">

    <!-- Inline styles specific to the player profile view page -->
   <style>
        /* ==================================== */
        /* Styles spécifiques pour la page d'affichage du Profil Joueur */
        /* ==================================== */

        .profile-view-main {
            flex-grow: 1;
            background-color: var(--dashboard-bg); /* Uses the soft dashboard background */
            width: 100%;
            max-width: 800px; /* Wider for profile display */
            margin: 0 auto; /* Centers content */
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            gap: 25px; /* Space between sections */
            padding-top: 80px;
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
            position: relative; /* For the contact button */
        }

        .profile-header-card .profile-pic-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 5px solid var(--primary-color);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .profile-header-card h1 {
            font-size: 2.2em;
            color: var(--dark-text-color);
            margin: 0 0 10px 0;
        }

        .profile-header-card .player-meta {
            font-size: 1.1em;
            color: var(--medium-text-color);
            margin-bottom: 20px;
        }

        .profile-header-card .player-meta span {
            margin: 0 8px;
            display: inline-flex;
            align-items: center;
        }
        .profile-header-card .player-meta i {
            margin-right: 5px;
            color: var(--primary-color);
        }

        .profile-header-card .player-bio {
            font-size: 1em;
            color: var(--dark-text-color);
            line-height: 1.6;
            margin-bottom: 25px;
            max-width: 600px;
        }

        .profile-header-card .contact-btn {
            background: linear-gradient(45deg, var(--secondary-color), #218838);
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
        .profile-header-card .contact-btn i {
            margin-right: 10px;
        }
        .profile-header-card .contact-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--secondary-shadow-color);
        }


        /* General section styling */
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

        /* Detail grid */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

        /* Videos Section */
        .video-player {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio (9 / 16 * 100%) */
            height: 0;
            overflow: hidden;
            background-color: #000;
            border-radius: 10px;
            margin-bottom: 20px; /* Space between videos */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .video-player iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .video-item {
            margin-bottom: 20px;
        }
        .video-item h3 {
            font-size: 1.3em;
            color: var(--dark-text-color);
            margin-top: 0;
            margin-bottom: 10px;
            text-align: left;
        }

        /* CV Section */
        .cv-download-btn {
            background-color: var(--primary-color);
            color: var(--white-color);
            padding: 15px 25px;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            text-decoration: none; /* For link styling */
            box-shadow: 0 5px 15px var(--primary-shadow-color);
        }
        .cv-download-btn i {
            margin-right: 10px;
            font-size: 1.2em;
        }
        .cv-download-btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--primary-shadow-color);
        }


        /* Back link general */
        .back-link {
            margin-top: 30px;
            text-align: center;
        }
        .back-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
        }
        .back-link a i {
            margin-right: 8px;
        }
        .back-link a:hover {
            color: #0056b3;
            text-decoration: underline;
        }


        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            .profile-view-main {
                padding: 15px;
                gap: 20px;
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
            .profile-header-card .player-meta {
                font-size: 0.95em;
                flex-direction: column; /* Stack details vertically */
                gap: 5px; /* Space between stacked details */
            }
            .profile-header-card .player-meta span {
                margin: 0; /* Reset horizontal margin */
            }
            .profile-header-card .player-bio {
                font-size: 0.95em;
                margin-bottom: 20px;
            }
            .profile-header-card .contact-btn {
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

            .video-item h3 {
                font-size: 1.1em;
            }

            .cv-download-btn {
                font-size: 1em;
                padding: 12px 20px;
                width: 100%; /* Full width on mobile */
                justify-content: center;
            }
        }
        @media (max-width: 480px) {
            .profile-header-card h1 {
                font-size: 1.6em;
            }
        }
        .form-section legend {
            font-size: 1.4em;
            font-weight: 600;
            color: var(--primary-color);
            padding: 0 10px;
            margin-left: -10px; /* Adjust legend position */
            background-color: var(--white-color); /* To make it "float" above the border */
            border-radius: 5px;
        }

        .form-section legend i {
            margin-right: 10px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap; /* Allow items to wrap on smaller screens */
            gap: 20px; /* Space between form groups */
            margin-bottom: 0; /* Reset default form-group margin */
        }

        .form-row .form-group {
            flex: 1; /* Allow form groups to grow */
            min-width: calc(50% - 10px); /* Two columns, considering gap */
            margin-bottom: 20px; /* Add margin back for vertical spacing */
        }
        .form-row .form-group:last-child {
            margin-bottom: 0; /* No margin after last group in a row */
        }

        /* Specific override for single column items in a row if needed */
        .form-row .form-group.full-width {
            min-width: 100%;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-text-color);
            font-size: 1em;
        }

        .form-group label i {
            margin-right: 8px;
            color: var(--primary-color);
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="tel"],
        .form-group input[type="date"],
        .form-group input[type="number"],
        .form-group input[type="url"],
        .form-group textarea,
        .form-group select {
            width: calc(100% - 24px); /* Full width minus padding/border */
            padding: 12px;
            border: 1px solid var(--input-border-color);
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1em;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group textarea {
            resize: vertical; /* Allow vertical resizing */
            min-height: 80px;
        }

        .form-group select {
            appearance: none; /* Remove default arrow */
            background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"%3e%3cpolyline points="6 9 12 15 18 9"%3e%3c/polyline%3e%3c/svg%3e');
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 1em;
            padding-right: 40px;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus,
        .form-group input[type="tel"]:focus,
        .form-group input[type="date"]:focus,
        .form-group input[type="number"]:focus,
        .form-group input[type="url"]:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
            outline: none;
        }

        /* File/Video Upload specific styles */
        .file-upload-group, .video-upload-group {
            border: 1px dashed var(--border-color);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            background-color: var(--light-bg-color);
            transition: background-color 0.3s ease;
            cursor: pointer; /* Indicate clickability */
        }

        .file-upload-group:hover, .video-upload-group:hover {
            background-color: var(--hover-bg-color);
        }

        .file-upload-group label, .video-upload-group label {
            font-weight: 500;
            color: var(--medium-text-color);
            margin-bottom: 10px;
        }

        .file-upload-group input[type="file"] {
            display: none; /* Hide default file input */
        }
        .file-upload-group i {
            font-size: 2em;
            color: var(--primary-color);
            margin-bottom: 10px;
            display: block;
        }
        .file-upload-group span.file-name,
        .video-upload-group span.video-url {
            display: block;
            font-size: 0.9em;
            color: var(--dark-text-color);
            margin-top: 5px;
            word-break: break-all; /* Break long URLs */
        }
        .video-upload-group input[type="text"] {
             width: 100%;
             margin-top: 10px;
        }


        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 25px;
        }

        .form-actions button {
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

        .form-actions button i {
            margin-right: 8px;
        }

        .form-actions .btn-submit {
            background: linear-gradient(45deg, var(--secondary-color), #218838);
            color: var(--white-color);
        }
        .form-actions .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px var(--secondary-shadow-color);
        }

        .form-actions .btn-cancel {
            background-color: var(--light-bg-color);
            color: var(--dark-text-color);
            border: 1px solid var(--border-color);
        }
        .form-actions .btn-cancel:hover {
            transform: translateY(-2px);
            background-color: var(--hover-bg-color);
        }


    </style>
</head>
<body>
    <!-- App Header - Reuses global class -->
    <header class="app-header">
        <div class="header-content">
            <div class="header-logo">
                <i class="fas fa-user"></i>
                <span>Profil </span>
            </div>
            <div class="header-user">
                <!-- Icon for options or back button -->
                <a href="explore.php" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                    <i class="fas fa-arrow-left"></i>
                    <span>Retour</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main profile content -->
    <main class="profile-view-main" style="padding-top:100px;padding-bottom:100px;">

        <!-- Profile Header Section -->
        <div class="profile-header-card">
            <img src="../profil_soccer/<?= $donnees_joueur['profil'] ?>" alt="Photo de profil de <?= $donnees_joueur['prenom'].' '.$donnees_joueur['nom'] ?>" class="profile-pic-large">
            <h1><?= $donnees_joueur['prenom'].' '.$donnees_joueur['nom'] ?></h1>
            <div class="player-meta">
                <span><i class="fas fa-crosshairs"></i> <?= $donnees_joueur['position'] ?></span>
                <span><i class="fas fa-birthday-cake"></i> 20 ans</span>
                <span><i class="fas fa-globe-africa"></i> <?= $donnees_joueur['nationalite'] ?></span>
                <span><i class="fas fa-city"></i> <?= $donnees_joueur['lieu_naissance'] ?></span>
            </div>
        </div>

        <form action="#" method="POST" enctype="multipart/form-data" id="register-soccer">
                    
        <legend><i class="fas fa-id-card"></i> Informations Personnelles</legend>
            <div class="form-row">
                <div class="form-group">
                    <label for="full_name"><i class="fas fa-user"></i> Nom :</label>
                    <input type="text" id="full_name" name="nom" value="<?= $donnees_joueur['nom'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="prenom"><i class="fas fa-user"></i> Prénom  :</label>
                    <input type="text" id="prenom" name="prenom" value="<?= $donnees_joueur['prenom'] ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="jour"><i class="fas fa-calendar-alt"></i> Jour de Naissance :</label>
                <input type="text" name="age" value="<?= $donnees_joueur['age'] ?>">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="birth_place"><i class="fas fa-map-marker-alt"></i> Lieu de Naissance :</label>
                    <input type="text" id="birth_place" name="lieu_naissance" value="<?= $donnees_joueur['lieu_naissance'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="nationality"><i class="fas fa-flag"></i> Nationalité :</label>
                    <input type="text" id="nationality" name="nationality" value="<?= $donnees_joueur['nationalite'] ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="gender"><i class="fas fa-venus-mars"></i> Genre :</label>
                    <input type="text" name="sexe" value="<?= $donnees_joueur['sexe'] ?>">
                </div>
                <div class="form-group">
                    <label for="phone"><i class="fas fa-phone"></i> Numéro de Téléphone :</label>
                    <input type="tel" id="phone" name="phone" value="<?= $donnees_joueur['contact'] ?>" required>
                </div>
            </div>
        </fieldset>

        <!-- Section: Caractéristiques Physiques -->
        <fieldset class="form-section">
            <legend><i class="fas fa-ruler-vertical"></i> Caractéristiques Physiques</legend>
            <div class="form-row">
                <div class="form-group">
                    <label for="height_cm"><i class="fas fa-text-height"></i> Taille (cm) :</label>
                    <input type="number" id="height_cm" name="taille" min="100" max="250" value="<?= $donnees_joueur['taille'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="weight_kg"><i class="fas fa-weight-hanging"></i> Poids (kg) :</label>
                    <input type="number" id="weight_kg" name="poid" min="30" max="150" value="<?= $donnees_joueur['poid'] ?>" required>
                </div>
            </div>
            <div class="form-group full-width">
                <label for="strong_foot"><i class="fas fa-shoe-prints"></i> Pied Fort :</label>
                <input type="text" name="pied" value="<?= $donnees_joueur['pied'] ?>">
            </div>
        </fieldset>

        <!-- Section: Caractéristiques Sportives -->
        <fieldset class="form-section">
            <legend><i class="fas fa-futbol"></i> Caractéristiques Sportives</legend>
            <div class="form-row">
                <div class="form-group">
                    <label for="main_position"><i class="fas fa-crosshairs"></i> Poste Principal :</label>
                    <select id="main_position" name="position" required>
                        <option value="<?= $donnees_joueur['position'] ?>"> <?= $donnees_joueur['position'] ?> </option>
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
                </div>
                <div class="form-group">
                    <label for="secondary_positions"><i class="fas fa-layer-group"></i> Postes Secondaires (séparés par virgule) :</label>
                    <input type="text" id="secondary_positions" name="position_secondaire" value="<?= $donnees_joueur['position_secondaires'] ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="current_club"><i class="fas fa-shield-alt"></i> Club Actuel :</label>
                    <input type="text" id="current_club" name="club" value="<?= $donnees_joueur['club'] ?>" required>
                </div>
            </div>
                <div class="form-group" style="margin-top:18px;">
                    <label for="mot_passe"><i class="fas fa-user"></i> Nouveau Mot de passe :</label>
                    <input type="text" id="mot_passe" name="mot_passe" placeholder="Ecrivez votre nouveau mot de passe" required>
                </div>
        </fieldset>

        <!-- Section: Documents & Médias -->
        <fieldset class="form-section">
            <legend><i class="fas fa-cloud-upload-alt"></i> Documents & Médias</legend>
            <div class="form-row">
                <div class="form-group full-width">
                    <label for="profile_picture_upload" class="file-upload-group">
                        <i class="fas fa-camera"></i>
                        <span>Télécharger Photo de Profil</span>
                        <input type="file" id="profile_picture_upload" name="fichier" accept="image/*">
                        <span class="file-name" id="profilePictureFileName">Aucun fichier choisi</span>
                    </label>
                </div>
            </div>

        </fieldset>

        
        <div id="message-patience" style="display: none; color: green; margin-top: 10px;text-align:center;">Veuillez patienter, connexion en cours...</div>
        <div id="message-erreur" style="display: none; color: red; margin-top: 10px;text-align:center;"></div>
        <div id="message-succes" style="display: none; color: green; margin-top: 10px;text-align:center;">Enregistrement fait avec succès !</div>

        <div class="form-actions">
            <button type="reset" class="btn-cancel"><i class="fas fa-times-circle"></i> Annuler</button>
            <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Enregistrer le Joueur</button>
        </div>

        </form>
    </main>

    <!-- Bottom fixed navigation menu - Reuses global class -->
    <nav class="bottom-nav">
        <a href="index.php" class="nav-item">
            <i class="fas fa-home"></i>
            <span>Accueil</span>
        </a>
        <a href="view_player_profile.php?joueur=<?= $_SESSION['reference'] ?>" class="nav-item active">
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const agentRegistrationForm = document.getElementById('register-soccer');
            const messagePatience = document.getElementById('message-patience');
            const messageErreur = document.getElementById('message-erreur');
            const messageSucces = document.getElementById('message-succes');

            // 4. Gestion de la soumission du formulaire
            agentRegistrationForm.addEventListener('submit', (event) => {

                event.preventDefault(); // Empêche l'envoi par défaut du formulaire

                messagePatience.style.display = 'block'; 

                const formData = new FormData(agentRegistrationForm);

                fetch('update_infos_joueur.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.text()) // Récupère la réponse en tant que texte
                .then(data => {
                    messagePatience.style.display = 'none'; // Cache le message de patience
                    if (data === 'success') {
                        messageSucces.style.display = 'block'; // Affiche le message de succès
                        agentRegistrationForm.reset(); // Réinitialise le formulaire
                        // Optionnel : On pourrait recharger la liste des produits ici si on voulait un affichage immédiat
                        setTimeout(() => {
                            messageSucces.style.display = 'none';
                    }, 3500); // Cache le message de succès après 3 secondes
                    } else {
                        messageErreur.textContent = 'Erreur lors de la connexion : ' + data;
                        messageErreur.style.display = 'block'; // Affiche le message d'erreur
                        setTimeout(() => {
                            messageErreur.style.display = 'none';
                        }, 4000);
                    }
                })
                .catch(error => {
                    messagePatience.style.display = 'none'; // Cache le message de patience
                    messageErreur.textContent = 'Erreur réseau : ' + error;
                    messageErreur.style.display = 'block'; // Affiche le message d'erreur en cas d'erreur réseau
                });
            });
        });
        // JavaScript for displaying selected file names
        document.getElementById('profile_picture_upload').addEventListener('change', function() {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Aucun fichier choisi';
            document.getElementById('profilePictureFileName').textContent = fileName;
        });

        document.getElementById('cv_upload').addEventListener('change', function() {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Aucun fichier choisi';
            document.getElementById('cvFileName').textContent = fileName;
        });

        // JavaScript for displaying video URL preview
        document.getElementById('video_url').addEventListener('input', function() {
            document.getElementById('videoUrlPreview').textContent = this.value;
        });
    </script>
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
