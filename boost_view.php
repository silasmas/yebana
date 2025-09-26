<?php
include('db.php');

$recuperation_infos_joueurs = $db->prepare('SELECT * FROM `jouers` ORDER BY RAND()');
$recuperation_infos_joueurs->execute(array());

while($donnes_joueurs = $recuperation_infos_joueurs->fetch()){

    $ajout_vues = $db->prepare('INSERT INTO `nombre_vues`( `reference_jouers`, `nombre`) VALUES ( ?, ?)');
    $ajout_vues->execute(array($donnes_joueurs['reference'], 22));

}