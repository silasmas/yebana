<?php
include('../db.php');
$error_sub_form = null;

if (isset($_GET['ref']) AND !empty($_GET['ref'])) {
    $reference_lecon = htmlspecialchars($_GET['ref']);
}
else {
    header('location:upload_lecons.html');
}

if (isset($_FILES['image_couverture'])) {
            
    $dossier = "../videos_educatives/";
    $check = getimagesize($_FILES['image_couverture']['tmp_name']);
    
    if($check ==! false){
    
        $uploadirFile = $dossier . basename($_FILES['image_couverture']['name']);
        
        if (move_uploaded_file($_FILES['image_couverture']['tmp_name'], $uploadirFile)) {
            
            $mise_jour = $db->prepare('UPDATE `videos_educatives` SET `url_couverture`= ? WHERE (reference = ?)');
            $mise_jour->execute(array($_FILES['image_couverture']['name'],$reference_lecon));


            $error_sub_form =" Succès !";

            if ($error_sub_form === " Succès !") {

                //header('location:enregistrement.php?message=succèss');

            }

        } else {
            echo  $error_sub_form =" Echec de televersement photo couverture !";
        }
    }
    else {
       
        $error_sub_form = "Choisissez une image couverture svp ! ";
        
    }
} else {
    $error_sub_form =" Recomencer !";
}




if (isset($_FILES['video_file'])) {
            
    $dossier = "../videos_educatives/";

    $extension = pathinfo($_FILES['video_file']['name'], PATHINFO_EXTENSION);
    $extensions_video = ['mp4', 'avi', 'mov', 'webm', 'mkv'];
    
    if(in_array($extension, $extensions_video)){
    
        $uploadirFile = $dossier . basename($_FILES['video_file']['name']);
        
        if (move_uploaded_file($_FILES['video_file']['tmp_name'], $uploadirFile)) {
            
            $mise_jour = $db->prepare('UPDATE `videos_educatives` SET `url`= ? WHERE (reference = ?)');
            $mise_jour->execute(array($_FILES['video_file']['name'],$reference_lecon));


            $error_sub_form =" Leçon sauvergarder avec succès !";

            if ($error_sub_form === " Succès !") {

                //header('location:enregistrement.php?message=succèss');

            }

        } else {
            echo  $error_sub_form =" Echec de televersement vidéo !";
        }
    }
    else {
       
        $error_sub_form = "Choisissez une vidéo svp ! ";
        
    }
} else {
    $error_sub_form =" Recomencer !";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA - Uploader Vidéo Éducative</title>
    <!-- Lien vers Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Lien vers le fichier CSS principal global (pour les variables et styles de base) -->
    <link rel="stylesheet" href="../style.css"> <!-- Chemin ajusté pour le sous-dossier admin -->
    <!-- Lien vers le fichier CSS spécifique à la section soccer (pour le header, si réutilisé) -->
    <link rel="stylesheet" href="../soccer/soccer.css"> <!-- Chemin ajusté pour le sous-dossier admin -->

    <!-- Styles en ligne spécifiques à la page d'upload de vidéo -->
    <style>
        /* ==================================== */
        /* Styles spécifiques pour la page Upload Vidéo Éducative */
        /* ==================================== */

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark-text-color);
            margin: 0;
            padding-top: var(--header-height); /* Espace pour l'en-tête fixe */
            padding-bottom: 20px; /* Un peu de rembourrage en bas */
            background-color: var(--dashboard-bg); /* Arrière-plan clair cohérent */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            box-sizing: border-box;
            overflow-x: hidden;
        }

        .upload-main {
            flex-grow: 1; /* Permet au contenu de s'étendre */
            width: 100%;
            max-width: 700px; /* Largeur maximale pour le formulaire */
            margin: 25px auto; /* Centre le formulaire et ajoute une marge supérieure */
            padding: 0 20px; /* Rembourrage latéral */
            box-sizing: border-box;
        }

        .upload-card {
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            text-align: left;
        }

        .upload-card h1 {
            font-size: 2.2em;
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 20px;
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
        .form-group input[type="url"],
        .form-group input[type="number"],
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
        .form-group input[type="url"]:focus,
        .form-group input[type="number"]:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
            outline: none;
        }

        /* Styles spécifiques de téléchargement de fichier/vidéo */
        .file-upload-group {
            border: 1px dashed var(--border-color);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            background-color: var(--light-bg-color);
            transition: background-color 0.3s ease;
            cursor: pointer; /* Indique qu'on peut cliquer */
            display: block; /* S'assure que c'est un bloc pour le padding */
        }

        .file-upload-group:hover {
            background-color: var(--hover-bg-color);
        }

        .file-upload-group label {
            font-weight: 500;
            color: var(--medium-text-color);
            margin-bottom: 10px;
            cursor: pointer; /* Pour que le label soit cliquable */
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
        .file-upload-group span.file-name {
            display: block;
            font-size: 0.9em;
            color: var(--dark-text-color);
            margin-top: 5px;
            word-break: break-all; /* Coupe les longs noms de fichiers */
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
            .upload-main {
                margin: 20px auto;
                padding: 0 15px;
            }
            .upload-card {
                padding: 20px;
            }
            .upload-card h1 {
                font-size: 1.8em;
                margin-bottom: 20px;
            }
            .form-group {
                margin-bottom: 15px;
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
    <!-- En-tête de l'application - Utilise les styles globaux -->
    <header class="app-header">
        <div class="header-content">
            <div class="header-logo">
                <i class="fas fa-upload"></i>
                <span>Uploader Vidéo Éducative</span>
            </div>
            <div class="header-user">
                <!-- Bouton de retour (vers un tableau de bord admin, ou index.html pour l'instant) -->
                <a href="upload_lecons.html" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                    <i class="fas fa-arrow-left"></i>
                    <span>Retour</span>
                </a>
            </div>
        </div>
    </header>

    <main class="upload-main">
        <div class="upload-card">
            <h1>Ajouter une Nouvelle Leçon Vidéo</h1>
            <form action="" method="POST" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="video_file" class="file-upload-group">
                        <i class="fas fa-video"></i>
                        <span>Sélectionnez le fichier vidéo</span>
                        <input type="file" id="video_file" name="video_file" accept="video/*" required>
                        <span class="file-name" id="videoFileName">Aucun fichier choisi</span>
                    </label>
                </div>

                <div class="form-group">
                    <label for="thumbnail_file" class="file-upload-group">
                        <i class="fas fa-image"></i>
                        <span>Sélectionnez la miniature (image)</span>
                        <input type="file" id="thumbnail_file" name="image_couverture" accept="image/*">
                        <span class="file-name" id="thumbnailFileName">Aucun fichier choisi</span>
                    </label>
                </div>

                <div class="form-group">
                    <label for="video_duration"><i class="fas fa-clock"></i> Durée de la Vidéo (Ex: 05:30 ou 12 min) :</label>
                    <input type="text" id="video_duration" name="video_duration" placeholder="Ex: 05:30 ou 12 min">
                </div>

                <div>
                    <p style="text-align: center;color:green;"><?= $error_sub_form ?></p>
                </div>

                <div class="form-actions">
                    <button type="reset" class="btn-cancel"><i class="fas fa-times-circle"></i> Annuler</button>
                    <button type="submit" class="btn-submit"><i class="fas fa-cloud-upload-alt"></i> Uploader la Vidéo</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        // JavaScript pour afficher les noms de fichiers sélectionnés
        document.getElementById('video_file').addEventListener('change', function() {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Aucun fichier choisi';
            document.getElementById('videoFileName').textContent = fileName;
        });

        document.getElementById('thumbnail_file').addEventListener('change', function() {
            const fileName = this.files.length > 0 ? this.files[0].name : 'Aucun fichier choisi';
            document.getElementById('thumbnailFileName').textContent = fileName;
        });
    </script>
</body>
</html>
