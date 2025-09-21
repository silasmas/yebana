<?php
include('../db.php');
$error_sub_form = null;

// 1. Vérification de la méthode de requête HTTP
// S'assurer que le formulaire a été soumis via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['nom'],$_POST['prenom'],$_POST['lieu_naissance'],$_POST['nationality'],$_POST['sexe'],$_POST['phone'],$_POST['taille'],$_POST['poid'],$_POST['pied'],$_POST['position'],$_POST['position_secondaire'],$_POST['club']) AND !empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['taille']) ) {
        
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $age = htmlspecialchars($_POST['age']);
        $lieu_naissance = htmlspecialchars($_POST['lieu_naissance']);
        $nationality = htmlspecialchars($_POST['nationality']);
        $sexe = htmlspecialchars($_POST['sexe']);
        $phone = htmlspecialchars($_POST['phone']);

        $taille = htmlspecialchars($_POST['taille']);
        $poid = htmlspecialchars($_POST['poid']);
        $pied = htmlspecialchars($_POST['pied']);

        $position = htmlspecialchars($_POST['position']);
        $position_secondaire = htmlspecialchars($_POST['position_secondaire']);
        $club = htmlspecialchars($_POST['club']);
        $mot_passe = htmlspecialchars($_POST['mot_passe']);

        
        $verification = $db->prepare('SELECT * FROM `jouers` WHERE (contact = ?)');
        $verification->execute(array($phone));
        
        $nbr_verification = $verification->rowCount();

        if ($nbr_verification === 1) {
            
            $reference = uniqid();
            
            $enregistrement_joueur = $db->prepare('UPDATE `jouers` SET `nom`= ?,`prenom`= ?,`age`= ?,`lieu_naissance`= ?,`taille`= ?,`poid`= ?,`position`= ?,`position_secondaires`= ?,`club`= ?,`pied`= ?,`sexe`= ?,`contact`= ? WHERE reference = ?');
            
            if ($enregistrement_joueur->execute(array($nom,$prenom,$age,$lieu_naissance,$taille,$poid,$position,$position_secondaire,$club,$pied,$sexe,$phone,$_SESSION['reference']))) {
                
                $enregistrement_joueur_comme_utilisateur = $db->prepare('UPDATE `utilisateurs` SET `nom`= ?,`prenom`= ?,`mot_passe`= ?,`contact`= ? WHERE reference = ?');
                
                if ($enregistrement_joueur_comme_utilisateur->execute(array($nom,$prenom,$mot_passe,$phone,$_SESSION['reference']))) {
                    
                    
                    if (isset($_FILES['fichier']) AND !empty($_FILES['fichier'])) {
                    
                        $dossier = "../profil_soccer/";
                        $check = getimagesize($_FILES['fichier']['tmp_name']);
                        
                        if($check ==! false){
                        
                            $uploadirFile = $dossier . basename($_FILES['fichier']['name']);
                            
                            if (move_uploaded_file($_FILES['fichier']['tmp_name'], $uploadirFile)) {
                                
                                $mise_jour = $db->prepare('UPDATE `jouers` SET `profil`= ? WHERE (reference = ?)');
                                $mise_jour->execute(array($_FILES['fichier']['name'],$_SESSION['reference']));

                                echo 'success';

                            } else {
                                echo $error_sub_form =" Echec de televersement !";
                            }
                        }
                        else {
                            echo 'Choisissez une image svp ! '; 
                        }
                    } else {
                        echo $error_sub_form =" selectionner une photo de profil !";
                    }

                    
                } else {
                    echo 'error 501';
                }
                
            } else {
                echo 'error 500';
            }
            
        } else {
            echo 'telephone déjà enregister déjà ';
        }

    }
    else {
        echo 'veuillez remplir toutes les champs du formulaire ';
    }
}
else {
    // Si la requête n'est pas de type POST
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['received_data' => false, 'message' => 'Méthode de requête non autorisée.']);
}