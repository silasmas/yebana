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
        $count   = $row['total'];

        echo "<p><b>Numéro :</b> $contact → trouvé $count fois</p>";

        // Montrer les utilisateurs concernés
        $sqlUsers = "SELECT id, nom, prenom, mail FROM utilisateurs WHERE contact='$contact'";
        $resUsers = $db->query($sqlUsers);

        echo "<ul>";
        while ($userRow = $resUsers->fetch()) {
            echo "<li>ID: ".$userRow['id']." | ".$userRow['nom']." ".$userRow['prenom']." | ".$userRow['mail']."</li>";
        }
        echo "</ul>";
    }
} else {
    echo "<p>Aucun doublon trouvé ✅</p>";
}

?>
