<?php
include('db.php');

// 1. Vérification de la méthode de requête HTTP
// S'assurer que le formulaire a été soumis via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Récupération et nettoyage des données du formulaire avec htmlspecialchars
    $email = htmlspecialchars($_POST['country-code']).''.htmlspecialchars($_POST['telephone']);
    $password = htmlspecialchars($_POST['password']);

    $verification_email_phone = $db->prepare('SELECT * FROM `utilisateurs` WHERE (`mail` = ?) OR (`contact` = ?) AND (`mot_passe` = ?)');
    $verification_email_phone->execute(array($email,$email,$password));

    if ($verification_email_phone->rowCount() === 1) {
       
        $donnees_users = $verification_email_phone->fetch();
        
        $_SESSION['nom'] = $donnees_users['nom'];
        $_SESSION['prenom'] = $donnees_users['prenom'];
        $_SESSION['mail'] = $donnees_users['mail'];
        $_SESSION['contact'] = $donnees_users['contact'];
        $_SESSION['reference'] = $donnees_users['reference'];
        $_SESSION['profil'] = $donnees_users['profil'];
        $_SESSION['fonction'] = $donnees_users['fonction'];
        $_SESSION['biographie'] = $donnees_users['biographie'];
        $_SESSION['date_adhesion'] = $donnees_users['date_adhesion'];
        $_SESSION['contact_whatsapp'] = $donnees_users['contact_whatsapp'];
        $_SESSION['adresse_physique'] = $donnees_users['adresse_physique'];
        $_SESSION['acces'] = $donnees_users['acces'];

        echo 'success';

    } else {
        echo "compte non trouver !";
    }

} else {
    // Si la requête n'est pas de type POST
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['received_data' => false, 'message' => 'Méthode de requête non autorisée.']);
}
?>