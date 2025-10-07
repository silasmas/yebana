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
     <link rel="shortcut icon" href="images/2000 2000.png" type="image/x-icon">
    <style>
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="tel"],
        .form-group input[type="date"],
        .form-group input[type="number"],
        .form-group input[type="url"],
        .form-group textarea,
        .form-group select {
            width: calc(100% - 24px); /* Full width minus padding/border */
            padding: 12px;
            border: 1px solid var(--input-border-color);
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 1em;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group textarea {
            resize: vertical; /* Allow vertical resizing */
            min-height: 80px;
        }

        .form-group select {
            appearance: none; /* Remove default arrow */
            background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"%3e%3cpolyline points="6 9 12 15 18 9"%3e%3c/polyline%3e%3c/svg%3e');
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 1em;
            padding-right: 40px;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus,
        .form-group input[type="tel"]:focus,
        .form-group input[type="date"]:focus,
        .form-group input[type="number"]:focus,
        .form-group input[type="url"]:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
            outline: none;
        }
    
        .number{
            display: flex;
        }
        .number select{
            width: 30%;
            padding:0px;
            margin-right:10px;
        }
        input[type='password']{
            width: 100%;
            padding:0px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <i class="fas fa-futbol"></i>
            <h1><a href="index.php" style="text-decoration:none;color:#cc0000;">YEBANA</a></h1>
        </div>
        <p>Connectez-vous à votre compte YEBANA.</p>

        <form method="POST" class="login-form" id="login-form">
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i> Numéro de Telephone :</label>
                <div class="number">
                    <select id="country-code" class="form-control" name="country-code">
                        <option value="213">🇩🇿 +213 (Algérie)</option>
                        <option value="244">🇦🇴 +244 (Angola)</option>
                        <option value="229">🇧🇯 +229 (Bénin)</option>
                        <option value="226">🇧🇫 +226 (Burkina Faso)</option>
                        <option value="257">🇧🇮 +257 (Burundi)</option>
                        <option value="237">🇨🇲 +237 (Cameroun)</option>
                        <option value="238">🇨🇻 +238 (Cap-Vert)</option>
                        <option value="236">🇨🇫 +236 (Centrafrique)</option>
                        <option value="235">🇹🇩 +235 (Tchad)</option>
                        <option value="269">🇰🇲 +269 (Comores)</option>
                        <option value="242">🇨🇬 +242 (Congo)</option>
                        <option value="243" selected>+243(RDC)</option>
                        <option value="225">🇨🇮 +225 (Côte d'Ivoire)</option>
                        <option value="253">🇩🇯 +253 (Djibouti)</option>
                        <option value="20">🇪🇬 +20 (Égypte)</option>
                        <option value="240">🇬🇶 +240 (Guinée équatoriale)</option>
                        <option value="291">🇪🇷 +291 (Érythrée)</option>
                        <option value="268">🇸🇿 +268 (Eswatini)</option>
                        <option value="251">🇪🇹 +251 (Éthiopie)</option>
                        <option value="241">🇬🇦 +241 (Gabon)</option>
                        <option value="220">🇬🇲 +220 (Gambie)</option>
                        <option value="233">🇬🇭 +233 (Ghana)</option>
                        <option value="224">🇬🇳 +224 (Guinée)</option>
                        <option value="245">🇬🇼 +245 (Guinée-Bissau)</option>
                        <option value="225">🇨🇮 +225 (Côte d’Ivoire)</option>
                        <option value="254">🇰🇪 +254 (Kenya)</option>
                        <option value="266">🇱🇸 +266 (Lesotho)</option>
                        <option value="231">🇱🇷 +231 (Libéria)</option>
                        <option value="218">🇱🇾 +218 (Libye)</option>
                        <option value="261">🇲🇬 +261 (Madagascar)</option>
                        <option value="265">🇲🇼 +265 (Malawi)</option>
                        <option value="223">🇲🇱 +223 (Mali)</option>
                        <option value="222">🇲🇷 +222 (Mauritanie)</option>
                        <option value="230">🇲🇺 +230 (Maurice)</option>
                        <option value="212">🇲🇦 +212 (Maroc)</option>
                        <option value="258">🇲🇿 +258 (Mozambique)</option>
                        <option value="264">🇳🇦 +264 (Namibie)</option>
                        <option value="227">🇳🇪 +227 (Niger)</option>
                        <option value="234">🇳🇬 +234 (Nigéria)</option>
                        <option value="250">🇷🇼 +250 (Rwanda)</option>
                        <option value="239">🇸🇹 +239 (Sao Tomé)</option>
                        <option value="221">🇸🇳 +221 (Sénégal)</option>
                        <option value="248">🇸🇨 +248 (Seychelles)</option>
                        <option value="232">🇸🇱 +232 (Sierra Leone)</option>
                        <option value="252">🇸🇴 +252 (Somalie)</option>
                        <option value="27">🇿🇦 +27 (Afrique du Sud)</option>
                        <option value="211">🇸🇸 +211 (Soudan du Sud)</option>
                        <option value="249">🇸🇩 +249 (Soudan)</option>
                        <option value="255">🇹🇿 +255 (Tanzanie)</option>
                        <option value="228">🇹🇬 +228 (Togo)</option>
                        <option value="216">🇹🇳 +216 (Tunisie)</option>
                        <option value="256">🇺🇬 +256 (Ouganda)</option>
                        <option value="260">🇿🇲 +260 (Zambie)</option>
                        <option value="263">🇿🇼 +263 (Zimbabwe)</option>
                        <option value="971">UAE +971 (Dubai)</option>
                    </select>
                    <input type="tel" id="telephone" name="telephone" placeholder="ex : 999999999" required>
                    
                </div>
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
            <a href="forgot_password.html">Mot de passe oublié ?</a>
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
                        messageErreur.textContent = 'Echec : ' + data;
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