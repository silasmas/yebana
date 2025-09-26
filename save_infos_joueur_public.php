<?php
include('db.php');
$error_sub_form = null;

// 1. Vérification de la méthode de requête HTTP
// S'assurer que le formulaire a été soumis via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['nom'],$_POST['prenom'],$_POST['lieu_naissance'],$_POST['nationality'],$_POST['sexe'],$_POST['adresse'],$_POST['taille'],$_POST['poid'],$_POST['pied'],$_POST['position'],$_POST['position_secondaire'],$_POST['club'],$_POST['manager'],$_POST['contact_manager']) AND !empty($_POST['nom']) AND !empty($_POST['prenom'])) {
        
        
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $age = htmlspecialchars($_POST['annee']).'-'.htmlspecialchars($_POST['mois']).'-'.htmlspecialchars($_POST['jour']);
        $postnom = htmlspecialchars($_POST['lieu_naissance']);
        $lieu_naissance = htmlspecialchars($_POST['taille']);
        $nationality = htmlspecialchars($_POST['nationality']);
        $sexe = htmlspecialchars($_POST['sexe']);
        $phone = htmlspecialchars($_POST['country-code']).''.htmlspecialchars($_POST['telephone']);
        $adresse = htmlspecialchars($_POST['adresse']);

        $taille = htmlspecialchars($_POST['taille']);
        $poid = htmlspecialchars($_POST['poid']);
        $pied = htmlspecialchars($_POST['pied']);

        $position = htmlspecialchars($_POST['position']);
        $position_secondaire = htmlspecialchars($_POST['position_secondaire']);
        $club = htmlspecialchars($_POST['club']);
        $manager = htmlspecialchars($_POST['manager']);
        $contact_manager = htmlspecialchars($_POST['contact_manager']);
        
        $heure = date('H');
        $heure = $heure.date(':i');

        
        $verification = $db->prepare('SELECT * FROM `pre_enregistrement` WHERE (contact = ?)');
        $verification->execute(array($phone));
        
        $nbr_verification = $verification->rowCount();

        if ($nbr_verification === 0) {
            
            $reference = uniqid();
            
            $enregistrement_joueur = $db->prepare('INSERT INTO `pre_enregistrement`(`nom`, `prenom`, `age`, `lieu_naissance`, `taille`, `poid`, `position`, `position_secondaires`, `club`, `pied`, `agent`, `sexe`, `manager`, `contact_manager`, `contact`, `reference`, `profil`, `nationalite`, `heure_enregistrement`) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            
            if ($enregistrement_joueur->execute(array($nom,$prenom,$age,$lieu_naissance,$taille,$poid,$position,$position_secondaire,$club,$pied,'enligne',$sexe,$manager,$contact_manager,$phone,$reference,'user.jpg',$nationality,$heure))) {
                
                $enregistrement_joueur_comme_utilisateur = $db->prepare('INSERT INTO `utilisateurs`(`nom`, `prenom`, `reference`, `acces`, `mot_passe`, `contact`, `profil`, valeur) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)');
                
                if ($enregistrement_joueur_comme_utilisateur->execute(array($nom,$prenom,$reference,'joueur','000000',$phone,'user.jpg',2))) {
                    
                    
                    if (isset($_FILES['fichier'])) {
                    
                        $dossier = "profil_soccer/";
                        $check = getimagesize($_FILES['fichier']['tmp_name']);
                        
                        if($check ==! false){
                        
                            $uploadirFile = $dossier . basename($_FILES['fichier']['name']);
                            
                            if (move_uploaded_file($_FILES['fichier']['tmp_name'], $uploadirFile)) {
                                
                                $mise_jour = $db->prepare('UPDATE `pre_enregistrement` SET `profil`= ? WHERE (reference = ?)');
                                $mise_jour->execute(array($_FILES['fichier']['name'],$reference));

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