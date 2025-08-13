<?php
session_start();            // 1. Démarre la session
session_unset();            // 2. Vide toutes les variables de session
session_destroy();          // 3. Détruit complètement la session
header('location:login.php');
exit();