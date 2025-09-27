<?php
include('db.php');

// Récupérer tous les utilisateurs
$sql = "SELECT id, contact FROM utilisateurs";
$stmt = $db->query($sql);

while ($row = $stmt->fetch()) {
    $id = $row['id'];
    $numero = $row['contact'];

    // Supprimer tout sauf les chiffres
    $numero = preg_replace('/\D/', '', $numero);

    // Normaliser le numéro
    if (strpos($numero, "243") === 0) {
        // Déjà au bon format
        $numeroFinal = $numero;
    } elseif (strpos($numero, "0") === 0) {
        // Commence par 0 → on enlève le 0 et on ajoute 243
        $numeroFinal = "243" . substr($numero, 1);
    } elseif (strpos($numero, "9") === 0) {
        // Commence par 9 (ex: 89xxxxxxx ou 90xxxxxxx)
        $numeroFinal = "243" . $numero;
    } else {
        // Cas particulier : si déjà formaté autrement
        $numeroFinal = $numero;
    }

    // Mettre à jour dans la base
    $update = $db->prepare("UPDATE utilisateurs SET contact = :contact WHERE id = :id");
    $update->execute([
        ':contact' => $numeroFinal,
        ':id' => $id
    ]);

    echo "ID $id → $numeroFinal\n";
}
