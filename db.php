<?php
session_start();
$connect = NULL;
$recherche = null;
try
{
	$db = new PDO('mysql:host=127.0.0.1;dbname=u911414181_yebana;charset=utf8;', 'u911414181_yebana', 'Yebana2025@');
    $connect = 'connect';
}
catch(Exception $e)
{
    ?>
    <script>
        alert("Verifié que vous disposez d'une connexion internet");
    </script>
    <?php
}
