<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA - Modifier Joueur</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables et styles de base) -->
    <link rel="stylesheet" href="../style.css"> <!-- Chemin ajusté pour le sous-dossier -->
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour le header et le menu de navigation) -->
    <link rel="stylesheet" href="../soccer/soccer.css"> <!-- Chemin ajusté pour le sous-dossier -->

    <!-- Styles en ligne spécifiques à la page de modification de joueur -->
    <style>
        /* ==================================== */
        /* Styles spécifiques pour la page Modifier Joueur */
        /* ==================================== */

        /* Surcharge des styles du corps provenant du CSS global */
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text-color);
            margin: 0;
            padding-top: var(--header-height); /* Espace pour l'en-tête fixe */
            padding-bottom: var(--bottom-nav-height); /* Espace pour la barre de navigation fixe en bas */
            background-color: var(--dashboard-bg); /* Arrière-plan clair cohérent */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            box-sizing: border-box;
            overflow-x: hidden;
        }

        .player-edit-main {
            flex-grow: 1; /* Permet au contenu de s'étendre */
            width: 100%;
            max-width: 800px; /* Largeur maximale pour le conteneur du formulaire */
            margin: 25px auto; /* Centre le contenu et ajoute une marge supérieure */
            padding: 0 20px; /* Rembourrage latéral */
            box-sizing: border-box;
        }

        .edit-card {
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            text-align: left;
        }

        .edit-card h1 {
            font-size: 2.2em;
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 700;
        }

        /* Réutilisation des styles de section de formulaire globaux pour la cohérence */
        .form-section {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px; /* Espace entre les sections */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .form-section legend {
            font-size: 1.4em;
            font-weight: 600;
            color: var(--primary-color);
            padding: 0 10px;
            margin-left: -10px; /* Ajuste la position de la légende */
            background-color: var(--white-color); /* Pour qu'elle "flotte" au-dessus de la bordure */
            border-radius: 5px;
        }

        .form-section legend i {
            margin-right: 10px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap; /* Permet aux éléments de s'enrouler sur les petits écrans */
            gap: 20px; /* Espace entre les groupes de formulaires */
            margin-bottom: 0; /* Réinitialise la marge inférieure par défaut du groupe de formulaires */
        }

        .form-row .form-group {
            flex: 1; /* Permet aux groupes de formulaires de s'agrandir */
            min-width: calc(50% - 10px); /* Deux colonnes, en tenant compte de l'espace */
            margin-bottom: 20px; /* Ajoute la marge arrière pour l'espacement vertical */
        }
        .form-row .form-group:last-child {
            margin-bottom: 0; /* Pas de marge après le dernier groupe d'une ligne */
        }

        /* Surcharge spécifique pour les éléments à colonne unique dans une ligne si nécessaire */
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
            width: calc(100% - 24px); /* Toute la largeur moins le rembourrage/bordure */
            padding: 12px;
            border: 1px solid var(--input-border-color);
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1em;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group textarea {
            resize: vertical; /* Permet le redimensionnement vertical */
            min-height: 80px;
        }

        .form-group select {
            appearance: none; /* Supprime la flèche par défaut */
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

        /* Styles spécifiques de téléchargement de fichier/vidéo */
        .file-upload-group, .video-upload-group {
            border: 1px dashed var(--border-color);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            background-color: var(--light-bg-color);
            transition: background-color 0.3s ease;
            cursor: pointer; /* Indique qu'on peut cliquer */
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
            display: none; /* Masque l'entrée de fichier par défaut */
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
            word-break: break-all; /* Coupe les longues URL */
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


        /* Requêtes média pour la réactivité */
        @media (max-width: 768px) {
            .player-edit-main {
                margin: 20px auto;
                padding: 0 15px;
            }
            .edit-card {
                padding: 20px;
            }
            .edit-card h1 {
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
                flex-direction: column; /* Empile toutes les groupes de formulaires verticalement sur mobile */
                gap: 0; /* Supprime l'espace lorsque empilé */
            }
            .form-row .form-group {
                min-width: 100%; /* Assure la pleine largeur lorsque empilé */
                margin-bottom: 15px; /* Ajoute un espacement vertical cohérent */
            }
            .form-row .form-group:last-child {
                margin-bottom: 15px; /* Le dernier groupe a également besoin d'espacement lorsqu'il est empilé */
            }
            /* Ajustement spécifique pour le dernier groupe de formulaires dans la ligne de formulaire */
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
                flex-direction: column; /* Empile les boutons verticalement */
                align-items: stretch; /* Étire les boutons sur toute la largeur */
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
    <!-- En-tête de l'application - Utilise les styles d'en-tête globaux de soccer.css -->
    <header class="app-header">
        <div class="header-content">
            <div class="header-logo">
                <i class="fas fa-edit"></i>
                <span>Modifier un Profil Joueur</span>
            </div>
            <div class="header-user">
                <!-- Bouton de retour pour les agents -->
                <a href="../logout.php" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </div>
    </header>

    <main class="player-edit-main">
        <div class="edit-card">
            <h1>Modifier les Informations du Joueur</h1>
            <form action="process_player_edit.php" method="POST" enctype="multipart/form-data">
                <!-- Champ caché pour l'ID du joueur, qui serait pré-rempli par le backend -->
                <input type="hidden" name="player_id" value="[PLAYER_ID_HERE]">
                
                <!-- Section: Informations Personnelles -->
                <fieldset class="form-section">
                    <legend><i class="fas fa-id-card"></i> Informations Personnelles</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="full_name"><i class="fas fa-user"></i> Nom Complet :</label>
                            <input type="text" id="full_name" name="full_name" placeholder="Nom Prénom" value="[Nom Prénom du joueur]" required>
                        </div>
                        <div class="form-group">
                            <label for="birth_date"><i class="fas fa-calendar-alt"></i> Date de Naissance :</label>
                            <input type="date" id="birth_date" name="birth_date" value="[Date de naissance du joueur]" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="birth_place"><i class="fas fa-map-marker-alt"></i> Lieu de Naissance :</label>
                            <input type="text" id="birth_place" name="birth_place" placeholder="Ex: Kinshasa" value="[Lieu de naissance du joueur]" required>
                        </div>
                        <div class="form-group">
                            <label for="nationality"><i class="fas fa-flag"></i> Nationalité :</label>
                            <input type="text" id="nationality" name="nationality" placeholder="Ex: Congolaise" value="[Nationalité du joueur]" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="gender"><i class="fas fa-venus-mars"></i> Genre :</label>
                            <select id="gender" name="gender" required>
                                <option value="">Sélectionner</option>
                                <option value="Male" [Selected si Masculin]>Masculin</option>
                                <option value="Female" [Selected si Féminin]>Féminin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="phone"><i class="fas fa-phone"></i> Numéro de Téléphone :</label>
                            <input type="tel" id="phone" name="phone" placeholder="Ex: +243812345678" value="[Numéro de téléphone du joueur]" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label for="email"><i class="fas fa-at"></i> Adresse E-mail :</label>
                            <input type="email" id="email" name="email" placeholder="Ex: joueur@example.com" value="[Email du joueur]">
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label for="address"><i class="fas fa-home"></i> Adresse Complète (Ville, Pays) :</label>
                        <textarea id="address" name="address" rows="3" placeholder="Ex: Av. du Stade, N°123, Kinshasa, RDC">[Adresse du joueur]</textarea>
                    </div>
                </fieldset>

                <!-- Section: Caractéristiques Physiques -->
                <fieldset class="form-section">
                    <legend><i class="fas fa-ruler-vertical"></i> Caractéristiques Physiques</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="height_cm"><i class="fas fa-text-height"></i> Taille (cm) :</label>
                            <input type="number" id="height_cm" name="height_cm" min="100" max="250" placeholder="Ex: 175" value="[Taille du joueur]" required>
                        </div>
                        <div class="form-group">
                            <label for="weight_kg"><i class="fas fa-weight-hanging"></i> Poids (kg) :</label>
                            <input type="number" id="weight_kg" name="weight_kg" min="30" max="150" placeholder="Ex: 70" value="[Poids du joueur]" required>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label for="strong_foot"><i class="fas fa-shoe-prints"></i> Pied Fort :</label>
                        <select id="strong_foot" name="strong_foot" required>
                            <option value="">Sélectionner</option>
                            <option value="Droit" [Selected si Droit]>Droit</option>
                            <option value="Gauche" [Selected si Gauche]>Gauche</option>
                            <option value="Ambidextre" [Selected si Ambidextre]>Ambidextre</option>
                        </select>
                    </div>
                </fieldset>

                <!-- Section: Caractéristiques Sportives -->
                <fieldset class="form-section">
                    <legend><i class="fas fa-futbol"></i> Caractéristiques Sportives</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="main_position"><i class="fas fa-crosshairs"></i> Poste Principal :</label>
                            <select id="main_position" name="main_position" required>
                                <option value="">Sélectionner</option>
                                <option value="Gardien" [Selected si Gardien]>Gardien de But</option>
                                <option value="Defenseur Central" [Selected si Defenseur Central]>Défenseur Central</option>
                                <option value="Lateral Droit" [Selected si Lateral Droit]>Latéral Droit</option>
                                <option value="Lateral Gauche" [Selected si Lateral Gauche]>Latéral Gauche</option>
                                <option value="Milieu Defensif" [Selected si Milieu Defensif]>Milieu Défensif</option>
                                <option value="Milieu Central" [Selected si Milieu Central]>Milieu Central</option>
                                <option value="Milieu Offensif" [Selected si Milieu Offensif]>Milieu Offensif</option>
                                <option value="Ailier Droit" [Selected si Ailier Droit]>Ailier Droit</option>
                                <option value="Ailier Gauche" [Selected si Ailier Gauche]>Ailier Gauche</option>
                                <option value="Avant Centre" [Selected si Avant Centre]>Avant-Centre</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="secondary_positions"><i class="fas fa-layer-group"></i> Postes Secondaires (séparés par virgule) :</label>
                            <input type="text" id="secondary_positions" name="secondary_positions" placeholder="Ex: Ailier Gauche, Milieu Offensif" value="[Postes secondaires du joueur]">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="current_club"><i class="fas fa-shield-alt"></i> Club Actuel :</label>
                            <input type="text" id="current_club" name="current_club" placeholder="Ex: TP Mazembe" value="[Club actuel du joueur]" required>
                        </div>
                        <div class="form-group">
                            <label for="license_number"><i class="fas fa-id-badge"></i> Numéro de Licence :</label>
                            <input type="text" id="license_number" name="license_number" placeholder="Ex: FECOFA12345" value="[Numéro de licence du joueur]">
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label for="club_history"><i class="fas fa-history"></i> Historique des Clubs (années/clubs) :</label>
                        <textarea id="club_history" name="club_history" rows="4" placeholder="Ex: 2020-2022 : AS Dragons, 2022-Présent : AS Vita Club">[Historique des clubs du joueur]</textarea>
                    </div>
                </fieldset>

                <!-- Section: Statistiques Clés (Saison Actuelle) -->
                <fieldset class="form-section">
                    <legend><i class="fas fa-chart-line"></i> Statistiques Clés (Saison Actuelle)</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="matches_played"><i class="fas fa-calendar-check"></i> Matchs Joués :</label>
                            <input type="number" id="matches_played" name="matches_played" min="0" placeholder="Ex: 25" value="[Matchs joués]">
                        </div>
                        <div class="form-group">
                            <label for="goals_scored"><i class="fas fa-futbol"></i> Buts Marqués :</label>
                            <input type="number" id="goals_scored" name="goals_scored" min="0" placeholder="Ex: 18" value="[Buts marqués]">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="assists"><i class="fas fa-handshake"></i> Passes Décisives :</label>
                            <input type="number" id="assists" name="assists" min="0" placeholder="Ex: 7" value="[Passes décisives]">
                        </div>
                        <div class="form-group">
                            <label for="yellow_cards"><i class="fas fa-square"></i> Cartons Jaunes :</label>
                            <input type="number" id="yellow_cards" name="yellow_cards" min="0" placeholder="Ex: 3" value="[Cartons jaunes]">
                        </div>
                    </div>
                    <div class="form-row">
                         <div class="form-group">
                            <label for="red_cards"><i class="fas fa-times-circle"></i> Cartons Rouges :</label>
                            <input type="number" id="red_cards" name="red_cards" min="0" placeholder="Ex: 0" value="[Cartons rouges]">
                        </div>
                        <div class="form-group">
                            <label for="minutes_played"><i class="fas fa-stopwatch"></i> Minutes Jouées :</label>
                            <input type="number" id="minutes_played" name="minutes_played" min="0" placeholder="Ex: 2050" value="[Minutes jouées]">
                        </div>
                    </div>
                </fieldset>

                <!-- Section: Documents & Médias -->
                <fieldset class="form-section">
                    <legend><i class="fas fa-cloud-upload-alt"></i> Documents & Médias</legend>
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label for="profile_picture_upload" class="file-upload-group">
                                <i class="fas fa-camera"></i>
                                <span>Mettre à jour Photo de Profil</span>
                                <input type="file" id="profile_picture_upload" name="profile_picture" accept="image/*">
                                <span class="file-name" id="profilePictureFileName">[Nom du fichier photo actuel]</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label for="video_url" class="video-upload-group">
                            <i class="fas fa-video"></i>
                            <span>Lien Vidéo de Performance (YouTube/Vimeo) :</span>
                            <input type="url" id="video_url" name="video_url" placeholder="Ex: https://www.youtube.com/watch?v=VIDEO_ID" value="https://www.youtube.com/shorts/CsO50kpgtus">
                            <span class="video-url" id="videoUrlPreview"></span>
                        </label>
                    </div>
                    <div class="form-group full-width">
                        <label for="cv_upload" class="file-upload-group">
                            <i class="fas fa-file-pdf"></i>
                            <span>Mettre à jour CV Sportif (PDF recommandé)</span>
                            <input type="file" id="cv_upload" name="cv_file" accept=".pdf,.doc,.docx">
                            <span class="file-name" id="cvFileName">[Nom du fichier CV actuel]</span>
                        </label>
                    </div>
                </fieldset>

                <div class="form-actions">
                    <button type="reset" class="btn-cancel"><i class="fas fa-times-circle"></i> Annuler</button>
                    <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Enregistrer les Modifications</button>
                </div>
            </form>
        </div>
    </main>

    <!-- Menu de navigation fixe en bas - Utilise les styles de navigation globaux de soccer.css -->
    <nav class="bottom-nav">
        <a href="enregistrement.php" class="nav-item">
            <i class="fas fa-user-plus"></i>
            <span>Enregistrement</span>
        </a>
        <a href="recherche_agent.html" class="nav-item active">
            <i class="fas fa-search"></i>
            <span>Recherche</span>
        </a>
        <a href="agent_profile.html" class="nav-item">
            <i class="fas fa-user-circle"></i>
            <span>Profil</span>
        </a>
        <a href="index.php" class="nav-item">
            <i class="fas fa-chart-pie"></i>
            <span>Rapports</span>
        </a>
    </nav>

    <script>
        // JavaScript pour afficher les noms de fichiers sélectionnés
        document.getElementById('profile_picture_upload').addEventListener('change', function() {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Aucun fichier choisi';
            document.getElementById('profilePictureFileName').textContent = fileName;
        });

        document.getElementById('cv_upload').addEventListener('change', function() {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Aucun fichier choisi';
            document.getElementById('cvFileName').textContent = fileName;
        });

        // JavaScript pour afficher l'aperçu de l'URL vidéo
        document.getElementById('video_url').addEventListener('input', function() {
            document.getElementById('videoUrlPreview').textContent = this.value;
        });

        // Simuler le pré-remplissage des champs pour démonstration (serait géré par le backend)
        document.addEventListener('DOMContentLoaded', () => {
            // Exemple de données à pré-remplir
            const playerData = {
                id: 'playerA',
                fullName: 'Abel Kasa',
                birthDate: '2004-03-15',
                birthPlace: 'Kinshasa',
                nationality: 'Congolaise',
                gender: 'Male',
                phone: '+243812345678',
                email: 'abel.kasa@example.com',
                address: '123 Avenue Lumumba, Kinshasa, RDC',
                heightCm: 175,
                weightKg: 70,
                strongFoot: 'Droit',
                mainPosition: 'Attaquant',
                secondaryPositions: 'Ailier Gauche',
                currentClub: 'AS Dragons',
                licenseNumber: 'FECOFA98765',
                clubHistory: '2020-2023 : Club Local\n2023-Présent : AS Dragons',
                matchesPlayed: 25,
                goalsScored: 18,
                assists: 7,
                yellowCards: 3,
                redCards: 0,
                minutesPlayed: 2050,
                profilePictureName: 'abel_kasa_profil.jpg',
                videoUrl: 'https://www.youtube.com/watch?v=VIDEO_ID_EXAMPLE',
                cvFileName: 'abel_kasa_cv.pdf'
            };

            // Pré-remplir les champs si les données sont disponibles (simulé ici)
            document.querySelector('input[name="player_id"]').value = playerData.id;
            document.getElementById('full_name').value = playerData.fullName;
            document.getElementById('birth_date').value = playerData.birthDate;
            document.getElementById('birth_place').value = playerData.birthPlace;
            document.getElementById('nationality').value = playerData.nationality;
            document.getElementById('gender').value = playerData.gender;
            document.getElementById('phone').value = playerData.phone;
            document.getElementById('email').value = playerData.email;
            document.getElementById('address').value = playerData.address;
            document.getElementById('height_cm').value = playerData.heightCm;
            document.getElementById('weight_kg').value = playerData.weightKg;
            document.getElementById('strong_foot').value = playerData.strongFoot;
            document.getElementById('main_position').value = playerData.mainPosition;
            document.getElementById('secondary_positions').value = playerData.secondaryPositions;
            document.getElementById('current_club').value = playerData.currentClub;
            document.getElementById('license_number').value = playerData.licenseNumber;
            document.getElementById('club_history').value = playerData.clubHistory;
            document.getElementById('matches_played').value = playerData.matchesPlayed;
            document.getElementById('goals_scored').value = playerData.goalsScored;
            document.getElementById('assists').value = playerData.assists;
            document.getElementById('yellow_cards').value = playerData.yellowCards;
            document.getElementById('red_cards').value = playerData.redCards;
            document.getElementById('minutes_played').value = playerData.minutesPlayed;
            
            // Afficher les noms de fichiers et URL vidéo (simulés)
            document.getElementById('profilePictureFileName').textContent = playerData.profilePictureName;
            document.getElementById('video_url').value = playerData.videoUrl;
            document.getElementById('videoUrlPreview').textContent = playerData.videoUrl;
            document.getElementById('cvFileName').textContent = playerData.cvFileName;
        });
    </script>
</body>
</html>
