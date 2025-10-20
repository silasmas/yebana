<?php
header('Content-Type: application/json');

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'trans2524376');

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Erreur de connexion à la base de données']);
    exit;
}

$nom = $_POST['nom'] ?? '';
$email = $_POST['email'] ?? '';
$telephone = $_POST['telephone'] ?? '';
$niveau = $_POST['niveau'] ?? '';

if (empty($nom) || empty($email)) {
    echo json_encode(['status' => 'error', 'message' => 'Champs obligatoires manquants']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO reservations (nom, email, telephone) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nom, $email, $telephone);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l’enregistrement']);
}

$stmt->close();
$conn->close();
?>
