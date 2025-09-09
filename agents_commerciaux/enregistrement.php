<?php
include('../db.php');
if (isset($_GET['message']) AND !empty($_GET['message'])) {

    $message = htmlspecialchars($_GET['message']);

} else {

    $message = null;

}
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
    <title>YEBANA - Enregistrement Joueur</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables et styles de base) -->
    <link rel="stylesheet" href="../style.css"> <!-- Note: Adjusted path for subfolder -->
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour le header et le menu de navigation) -->
    <link rel="stylesheet" href="../soccer/soccer.css"> <!-- Note: Adjusted path for subfolder -->

    <!-- Inline styles specific to the player registration page for commercial agents -->
    <style>
        /* ==================================== */
        /* Styles spécifiques pour la page d'Enregistrement Joueur */
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

        .player-registration-main {
            flex-grow: 1; /* Allows content to expand */
            width: 100%;
            max-width: 800px; /* Max width for the form container */
            margin: 25px auto; /* Center the form and add some top margin */
            padding: 0 20px; /* Side padding */
            box-sizing: border-box;
        }

        .registration-card {
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            text-align: left;
        }

        .registration-card h1 {
            font-size: 2.2em;
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 700;
        }

        /* Reusing global form-section styles but ensuring consistency */
        .form-section {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px; /* Space between sections */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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


        /* Media queries for responsiveness */
        @media (max-width: 768px) {
            .player-registration-main {
                margin: 20px auto;
                padding: 0 15px;
            }
            .registration-card {
                padding: 20px;
            }
            .registration-card h1 {
                font-size: 1.8em;
                margin-bottom: 20px;
            }
            .form-section {
                padding: 15px;
                margin-bottom: 20px;
            }
            .form-section legend {
                font-size: 1.2em;
            }
            .form-row {
                flex-direction: column; /* Stack all form groups vertically on mobile */
                gap: 0; /* Remove gap when stacked */
            }
            .form-row .form-group {
                min-width: 100%; /* Ensure full width when stacked */
                margin-bottom: 15px; /* Add consistent vertical spacing */
            }
            .form-row .form-group:last-child {
                margin-bottom: 15px; /* Last group also needs spacing when stacked */
            }
            /* Specific adjustment for the last form-group in the form-row */
            .form-row:last-of-type .form-group:last-child {
                margin-bottom: 0;
            }

            .form-group label {
                font-size: 0.95em;
            }
            .form-group input,
            .form-group textarea,
            .form-group select {
                padding: 10px;
                font-size: 0.95em;
            }
            .file-upload-group, .video-upload-group {
                padding: 10px;
            }
            .file-upload-group i {
                font-size: 1.8em;
            }

            .form-actions {
                flex-direction: column; /* Stack buttons vertically */
                align-items: stretch; /* Stretch buttons to full width */
                gap: 10px;
            }
            .form-actions button {
                width: 100%;
                font-size: 0.95em;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- App Header - Uses global header styles from soccer.css -->
    <header class="app-header">
        <div class="header-content">
            <div class="header-logo">
                <i class="fas fa-user-plus"></i>
                <span>Enregistrer un Joueur</span>
            </div>
            <div class="header-user">
                <!-- Retour button for agents -->
                <a href="../logout.php" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </div>
    </header>

    <main class="player-registration-main">
        <div class="registration-card">
            <h1>Formulaire d'Enregistrement de Joueur</h1>
            <form action="save_infos_joueur.php" method="POST" enctype="multipart/form-data">
                
                <!-- Section: Informations Personnelles -->
                <fieldset class="form-section">
                    <legend><i class="fas fa-id-card"></i> Informations Personnelles</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="full_name"><i class="fas fa-user"></i> Nom :</label>
                            <input type="text" id="full_name" name="nom" placeholder="Nom" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom"><i class="fas fa-user"></i> Prénom  :</label>
                            <input type="text" id="prenom" name="prenom" placeholder="Nom Prénom" required>
                        </div>
                        <div class="form-group">
                            <label for="birth_date"><i class="fas fa-calendar-alt"></i> Date de Naissance :</label>
                            <input type="date" id="birth_date" name="age" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="birth_place"><i class="fas fa-map-marker-alt"></i> Lieu de Naissance :</label>
                            <input type="text" id="birth_place" name="lieu_naissance" placeholder="Ex: Kinshasa" required>
                        </div>
                        <div class="form-group">
                            <label for="nationality"><i class="fas fa-flag"></i> Nationalité :</label>
                            <input type="text" id="nationality" name="nationality" placeholder="Ex: Congolaise" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="gender"><i class="fas fa-venus-mars"></i> Genre :</label>
                            <select id="gender" name="sexe" required>
                                <option value="">Sélectionner</option>
                                <option value="Male">Masculin</option>
                                <option value="Female">Féminin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="phone"><i class="fas fa-phone"></i> Numéro de Téléphone :</label>
                            <input type="tel" id="phone" name="phone" placeholder="Ex: +243812345678" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label for="email"><i class="fas fa-at"></i> Adresse E-mail :</label>
                            <input type="email" id="email" name="email" placeholder="Ex: joueur@example.com">
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label for="address"><i class="fas fa-home"></i> Adresse Complète (Ville, Pays) :</label>
                        <textarea id="address" name="adresse" rows="3" placeholder="Ex: Av. du Stade, N°123, Kinshasa, RDC"></textarea>
                    </div>
                </fieldset>

                <!-- Section: Caractéristiques Physiques -->
                <fieldset class="form-section">
                    <legend><i class="fas fa-ruler-vertical"></i> Caractéristiques Physiques</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="height_cm"><i class="fas fa-text-height"></i> Taille (cm) :</label>
                            <input type="number" id="height_cm" name="taille" min="100" max="250" placeholder="Ex: 175" required>
                        </div>
                        <div class="form-group">
                            <label for="weight_kg"><i class="fas fa-weight-hanging"></i> Poids (kg) :</label>
                            <input type="number" id="weight_kg" name="poid" min="30" max="150" placeholder="Ex: 70" required>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label for="strong_foot"><i class="fas fa-shoe-prints"></i> Pied Fort :</label>
                        <select id="strong_foot" name="pied" required>
                            <option value="">Sélectionner</option>
                            <option value="Droit">Droit</option>
                            <option value="Gauche">Gauche</option>
                            <option value="Ambidextre">Ambidextre</option>
                        </select>
                    </div>
                </fieldset>

                <!-- Section: Caractéristiques Sportives -->
                <fieldset class="form-section">
                    <legend><i class="fas fa-futbol"></i> Caractéristiques Sportives</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="main_position"><i class="fas fa-crosshairs"></i> Poste Principal :</label>
                            <select id="main_position" name="position" required>
                                <option value="">Sélectionner</option>
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
                            <input type="text" id="secondary_positions" name="position_secondaire" placeholder="Ex: Ailier Gauche, Milieu Offensif">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="current_club"><i class="fas fa-shield-alt"></i> Club Actuel :</label>
                            <input type="text" id="current_club" name="club" placeholder="Ex: TP Mazembe" required>
                        </div>
                        <div class="form-group">
                            <label for="license_number"><i class="fas fa-id-badge"></i> Numéro de Licence :</label>
                            <input type="text" id="license_number" name="numero_license" placeholder="Ex: FECOFA12345">
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label for="club_history"><i class="fas fa-history"></i> Historique des Clubs (années/clubs) :</label>
                        <textarea id="club_history" name="historique_clubs" rows="4" placeholder="Ex: 2020-2022 : AS Dragons, 2022-Présent : AS Vita Club"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="manager"><i class="fas fa-user"></i> Manager ou Agent :</label>
                            <input type="text" id="manager" name="manager" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="contact_manager"><i class="fas fa-user"></i> Contact Manager :</label>
                            <input type="text" id="contact_manager" name="contact_manager" placeholder="">
                        </div>
                        
                <div id="message-erreur" style=" color: green; margin-bottom: 10px;text-align:center;"> <?php echo $message; ?></div>
                    </div>
                </fieldset>

                <!-- Section: Statistiques Clés (Saison Actuelle) 
                <fieldset class="form-section">
                    <legend><i class="fas fa-chart-line"></i> Statistiques Clés (Saison Actuelle)</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="matches_played"><i class="fas fa-calendar-check"></i> Matchs Joués :</label>
                            <input type="number" id="matches_played" name="matches_played" min="0" placeholder="Ex: 25">
                        </div>
                        <div class="form-group">
                            <label for="goals_scored"><i class="fas fa-futbol"></i> Buts Marqués :</label>
                            <input type="number" id="goals_scored" name="goals_scored" min="0" placeholder="Ex: 18">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="assists"><i class="fas fa-handshake"></i> Passes Décisives :</label>
                            <input type="number" id="assists" name="assists" min="0" placeholder="Ex: 7">
                        </div>
                        <div class="form-group">
                            <label for="yellow_cards"><i class="fas fa-square"></i> Cartons Jaunes :</label>
                            <input type="number" id="yellow_cards" name="yellow_cards" min="0" placeholder="Ex: 3">
                        </div>
                    </div>
                    <div class="form-row">
                         <div class="form-group">
                            <label for="red_cards"><i class="fas fa-times-circle"></i> Cartons Rouges :</label>
                            <input type="number" id="red_cards" name="red_cards" min="0" placeholder="Ex: 0">
                        </div>
                        <div class="form-group">
                            <label for="minutes_played"><i class="fas fa-stopwatch"></i> Minutes Jouées :</label>
                            <input type="number" id="minutes_played" name="minutes_played" min="0" placeholder="Ex: 2050">
                        </div>
                    </div>
                </fieldset>
                -->

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

                <div class="form-actions">
                    <button type="reset" class="btn-cancel"><i class="fas fa-times-circle"></i> Annuler</button>
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Enregistrer le Joueur</button>
                </div>
            </form>
        </div>
    </main>

    <!-- Bottom fixed navigation menu - Uses global navigation styles from soccer.css -->
    <nav class="bottom-nav">
        <a href="#" class="nav-item active">
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
        <a href="index.php" class="nav-item">
            <i class="fas fa-chart-pie"></i>
            <span>Rapports</span>
        </a>
    </nav>

    <script>
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
        header('location:../login.php');
    }
}
else {
    header('location:../login.php');
}
