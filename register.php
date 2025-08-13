<?php
include('db.php');

// 1. Vérification de la méthode de requête HTTP
// S'assurer que le formulaire a été soumis via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 2. Récupération et nettoyage des données du formulaire avec htmlspecialchars
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $name = htmlspecialchars($_POST['name']);
    $prenom = htmlspecialchars($_POST['prenom']); // Pas de trim pour le mot de passe avant le hachage réel
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $role = htmlspecialchars($_POST['role']);

    $verification_email_phone = $db->prepare('SELECT * FROM `utilisateurs` WHERE (`mail` = ?) OR (`contact` = ?)');
    $verification_email_phone->execute(array($email,$phone_number));

    if ($verification_email_phone->rowCount() === 0) {
        
        switch ($role) {
            case 'player':
                $acces = 'joueur';
                break;
            case 'manager':
                $acces = 'manager';
                break;
            case 'recruiter':
                $acces = 'recruteur';
                break;
            
            default:
                $acces = "simple_users";
                break;
        }
       
        $sql = "INSERT INTO `utilisateurs`(`nom`, `prenom`, `reference`, `acces`, `mot_passe`, `mail`, `contact`, `profil`, `valeur`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        if ($stmt->execute(array($name,$prenom,uniqid(),$acces,$password,$email,$phone_number,'user.jpg',4))) {
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