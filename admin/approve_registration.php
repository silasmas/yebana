<?php
header('Content-Type: application/json'); // Indique que la réponse sera du JSON

include('../db.php');


$response = ['success' => false, 'message' => ''];

// Vérifiez si la requête est bien de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez le corps de la requête (qui devrait être du JSON)
    $input = file_get_contents('php://input');
    $data = json_decode($input, true); // Décode le JSON en tableau associatif

    // Vérifiez si les données nécessaires sont présentes
    $recordId = $data['id'] ?? null;
    $userType = $data['type'] ?? null;

    if ($recordId && $userType) {

        $recuperation_jouer = $db->prepare('SELECT * FROM `pre_enregistrement` WHERE (id = ?)');
        $recuperation_jouer->execute(array($recordId));

        if ($ligne = $recuperation_jouer->rowCount() === 1) {

            $donnees = $recuperation_jouer->fetch();

            $enregistrement_joueur = $db->prepare('INSERT INTO `jouers`(`nom`, `prenom`, `age`, `lieu_naissance`, `taille`, `poid`, `position`, `position_secondaires`, `club`, `numero_licence`, `historique_club`, `pied`, `agent`, `sexe`, `manager`, `contact_manager`, `contact`, `reference`, `profil`, `nationalite`, `heure_enregistrement`) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $enregistrement_joueur->execute(array($donnees['nom'],$donnees['prenom'],$donnees['age'],$donnees['lieu_naissance'],$donnees['taille'],$donnees['poid'],$donnees['position'],$donnees['position_secondaires'],$donnees['club'],$donnees['numero_licence'],$donnees['historique_club'],$donnees['pied'],$donnees['agent'],$donnees['sexe'],$donnees['manager'],$donnees['contact_manager'],$donnees['contact'],$donnees['reference'],$donnees['profil'],$donnees['nationalite'],$donnees['heure_enregistrement']));

            $delete = $db->prepare('DELETE FROM `pre_enregistrement` WHERE (reference = ?)');
            $delete->execute(array($donnees['reference']));
               
            $response['success'] = true;
        }

        
    } else {
        $response['message'] = "ID d'enregistrement ou type d'utilisateur manquant.";
    }
} else {
    $response['message'] = "Méthode de requête non autorisée.";
}

echo json_encode($response); // Renvoyez la réponse JSON
?>