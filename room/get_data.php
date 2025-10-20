<?php
// get_data.php

$servername = "localhost";
$username = "root"; // ton utilisateur MySQL
$password = "";     // ton mot de passe
$dbname = "audis"; // nom de ta base

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Ici, récupère les infos que tu veux utiliser pour répondre
$sql = "SELECT contenu FROM infos_formation";
$result = $conn->query($sql);

$contextData = "";
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $contextData .= $row['contenu'] . "\n"; // concatène toutes les infos
    }
}

$conn->close();

// On renvoie le contexte en JSON pour le récupérer en JS
echo json_encode(["context" => $contextData]);
?>
