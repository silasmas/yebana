<?php
header('Content-Type: application/json'); // Indique que la réponse sera du JSON

include('../db.php');


$response = ['success' => false, 'message' => ''];

// Vérifiez si la requête est bien de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérez le corps de la requête (qui devrait être du JSON)
    $input = file_get_contents('php://input');
    $data = json_decode($input, true); // Décode le JSON en tableau associatif

    $response['success'] = true;
        
} else {
    $response['message'] = "Méthode de requête non autorisée.";
}

echo json_encode($response); // Renvoyez la réponse JSON
?>