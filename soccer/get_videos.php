<?php
include('../db.php');

// Requête SQL
$stmt = $db->query("SELECT * FROM videos_educatives");
$donnees = $stmt->fetch();

// On renvoie les données directement sous forme de JavaScript
header("Content-Type: application/javascript");

echo json_encode($donnees);
