<?php
include('db.php');

// Requête pour repérer les doublons dans la colonne contact
$sql = "
    SELECT contact, COUNT(*) as total
    FROM utilisateurs
    GROUP BY contact
    HAVING total > 1
    ORDER BY total DESC
";

$result = $db->query($sql);

echo "<h2>Liste des doublons (même numéro de téléphone)</h2>";

if ($result->rowCount() > 0) {
    while ($row = $result->fetch()) {
        $contact = $row['contact'];

        // Étape 2 : sélectionner tous les utilisateurs ayant ce numéro
        $sqlUsers = "SELECT id FROM utilisateurs WHERE contact='$contact' ORDER BY id ASC";
        $resUsers = $db->query($sqlUsers);

        $first = true; // pour garder le premier compte
        while ($userRow = $resUsers->fetch()) {
            $id = $userRow['id'];

            if ($first) {
                // On garde ce premier utilisateur
                $first = false;
            } else {
                // Supprimer les autres
                $delete = "DELETE FROM utilisateurs WHERE id=$id";
                $db->query($delete);
                
                echo "Doublon supprimé : utilisateur ID $id avec numéro $contact <br>";
            }
        }
    }
} else {
    echo "<p>Aucun doublon trouvé ✅</p>";
}

?>
