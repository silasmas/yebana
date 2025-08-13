<?php
include('../db.php');

// 1. Vérification de la méthode de requête HTTP
// S'assurer que le formulaire a été soumis via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Récupération et nettoyage des données du formulaire avec htmlspecialchars
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']); // Pas de trim pour le mot de passe avant le hachage réel
    $equipe = htmlspecialchars($_POST['equipe']);
    $localisation = htmlspecialchars($_POST['localisation']);
    $whatsapp = htmlspecialchars($_POST['whatsapp']);
    $adresse = htmlspecialchars($_POST['adresse']);

    $verification_email_phone = $db->prepare('SELECT * FROM `utilisateurs` WHERE (`mail` = ?) OR (`contact` = ?)');
    $verification_email_phone->execute(array($email,$telephone));

    if ($verification_email_phone->rowCount() === 0) {
       
        $sql = "INSERT INTO `utilisateurs`(`nom`, `prenom`, `reference`, `acces`, `mot_passe`, `mail`, `contact`, contact_whatsapp, adresse_physique, `profil`, `valeur`, `equipe`, `zone_operationnelle`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        if ($stmt->execute(array($nom,$prenom,uniqid(),'Agent','000000',$email,$telephone,$whatsapp,$adresse,'user.jpg',4,$equipe,$localisation))) {
            echo 'success';
        }
        else {
            echo $stmt->error; // Envoie le message d'erreur en cas d'échec
        }

    } else {
        echo "adresse email ou numéro de telephone déjà utiliser !";
    }

} else {
    // Si la requête n'est pas de type POST
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['received_data' => false, 'message' => 'Méthode de requête non autorisée.']);
}
?>