<?php
include('db.php');
if (isset($_SESSION['acces']) AND !empty($_SESSION['acces'])) {
    switch ($_SESSION['acces']) {

        case 'Agent':

            header('location:agents_commerciaux/');

        break;

        case 'admin':

            header('location:admin/');

        break;

        case 'Analyste':

            header('location:analyste/');

        break;

        case 'manager':

            header('location:manager/');

        break;
        
        case 'joueur':

            header('location:soccer/');

        break;
        
        default:
            $error = '*accès refusé !';
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA - Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <i class="fas fa-futbol"></i>
            <h1>YEBANA</h1>
        </div>
        <p>Connectez-vous à votre compte YEBANA.</p>

        <form method="POST" class="login-form" id="login-form">
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Email  ou Telephone :</label>
                <input type="text" id="email" name="email" placeholder="Ex : email@example.com ou 243 XXX XXX XXX" required>
            </div>

            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i> Mot de passe :</label>
                <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
            </div>
            
            <div id="message-patience" style="display: none; color: green; margin-top: 10px;">Veuillez patienter, connexion en cours...</div>
            <div id="message-erreur" style="display: none; color: red; margin-top: 10px;"></div>
            <div id="message-succes" style="display: none; color: green; margin-top: 10px;">Connexion établie avec succès !</div>

            <button type="submit">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>

        <div class="signup-link">
            Pas encore de compte ? <a href="inscription.html">Inscrivez-vous ici</a>
        </div>
        <div class="forgot-password-link">
            <a href="forgot_password.php">Mot de passe oublié ?</a>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const loginForm = document.getElementById('login-form');
            const messagePatience = document.getElementById('message-patience');
            const messageErreur = document.getElementById('message-erreur');
            const messageSucces = document.getElementById('message-succes');

            // 4. Gestion de la soumission du formulaire
            loginForm.addEventListener('submit', (event) => {

                event.preventDefault(); // Empêche l'envoi par défaut du formulaire

                messagePatience.style.display = 'block'; 

                const formData = new FormData(loginForm);

                fetch('auth.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.text()) // Récupère la réponse en tant que texte
                .then(data => {
                    messagePatience.style.display = 'none'; // Cache le message de patience
                    if (data === 'success') {
                        messageSucces.style.display = 'block'; // Affiche le message de succès
                        loginForm.reset(); // Réinitialise le formulaire
                        // Optionnel : On pourrait recharger la liste des produits ici si on voulait un affichage immédiat
                        setTimeout(() => {
                            messageSucces.style.display = 'none';
                            window.location.href = "login.php";
                    }, 1500); // Cache le message de succès après 3 secondes
                    } else {
                        messageErreur.textContent = 'Erreur lors de la connexion : ' + data;
                        messageErreur.style.display = 'block'; // Affiche le message d'erreur
                        setTimeout(() => {
                            messageErreur.style.display = 'none';
                        }, 4000);
                    }
                })
                .catch(error => {
                    messagePatience.style.display = 'none'; // Cache le message de patience
                    messageErreur.textContent = 'Erreur réseau : ' + error;
                    messageErreur.style.display = 'block'; // Affiche le message d'erreur en cas d'erreur réseau
                });
            });
        });
    </script>
</body>
</html>