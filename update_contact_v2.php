<?php
include('db.php');

echo "<h3>🚀 Correction des numéros commençant par 2430...</h3>";

// --------------------------
// RÉCUPÉRATION DES NUMÉROS
// --------------------------
$sql = "SELECT id, contact FROM utilisateurs WHERE contact LIKE '2430%'";
$result = $db->query($sql);

$count = 0;

if ($result->rowCount() > 0) {
    while ($row = $result->fetch()) {
        $id = $row['id'];
        $contact = trim($row['contact']);

        // Supprimer tout sauf chiffres
        $contact = preg_replace('/\D/', '', $contact);

        // Vérifie si le numéro commence bien par 2430
        if (strpos($contact, '2430') === 0) {
            // Supprimer le 0 après 243
            $new_contact = '243' . substr($contact, 4);

            // Mettre à jour la base
            $update = $db->prepare("UPDATE utilisateurs SET contact=? WHERE id=?");
            $update->execute([$new_contact, $id]);

            echo "✅ Numéro ID $id corrigé : $contact → <b>$new_contact</b><br>";
            $count++;
        }
    }
}

if ($count > 0) {
    echo "<hr><b>✔️ Correction terminée.</b> $count numéros modifiés.";
} else {
    echo "<p style='color:blue;'>Aucun numéro commençant par 2430 trouvé ✅</p>";
}

?>
