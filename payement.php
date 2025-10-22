<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YEBANA Sport - Abonnement Premium</title>
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* -------------------------------------- */
        /* 1. VARIABLES ET RESET                  */
        /* -------------------------------------- */
        :root {
            --primary-color: #cc0000; /* Bleu */
            --secondary-color: #28a745; /* Vert (Money/Success) */
            --dark-color: #1a202c;
            --light-bg: #f8f9fa;
            --white: #ffffff;
            --shadow-light: rgba(0, 0, 0, 0.1);
            --shadow-medium: rgba(0, 0, 0, 0.2);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-color);
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* -------------------------------------- */
        /* 2. EN-TÊTE ET DESCRIPTION              */
        /* -------------------------------------- */
        .header-content {
            text-align: center;
            margin-bottom: 50px;
            padding-top: 20px;
        }

        .header-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .header-content p {
            font-size: 1.1rem;
            color: #6c757d;
            max-width: 700px;
            margin: 0 auto;
        }

        /* -------------------------------------- */
        /* 3. CARTES D'ABONNEMENT                 */
        /* -------------------------------------- */
        .plans-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        @media (min-width: 768px) {
            .plans-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .plan-card {
            background-color: var(--white);
            border-radius: 15px;
            box-shadow: 0 10px 30px var(--shadow-light);
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .plan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px var(--shadow-medium);
        }

        .plan-header h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .plan-price {
            margin: 20px 0;
        }

        .plan-price .price {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--dark-color);
            line-height: 1;
        }

        .plan-price .currency {
            font-size: 1.5rem;
            font-weight: 600;
            vertical-align: top;
            margin-right: 5px;
            color: #6c757d;
        }
        
        .plan-price .period {
            font-size: 1rem;
            display: block;
            color: #6c757d;
            margin-top: 5px;
        }

        /* Plan Recommandé (PRO) */
        .plan-card.recommended {
            border: 4px solid var(--primary-color);
            box-shadow: 0 10px 40px rgba(0, 123, 255, 0.3);
            transform: scale(1.03);
        }

        .plan-card.recommended:hover {
            transform: scale(1.05);
        }

        .plan-tag {
            background-color: var(--primary-color);
            color: var(--white);
            font-weight: 600;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            display: inline-block;
            margin-bottom: 15px;
        }

        /* Liste des fonctionnalités */
        .plan-features {
            text-align: left;
            margin-bottom: 30px;
            flex-grow: 1; /* Permet aux cartes d'avoir la même hauteur */
        }

        .plan-features ul {
            list-style: none;
            padding: 0;
        }

        .plan-features li {
            padding: 10px 0;
            border-bottom: 1px dashed var(--light-bg);
            font-size: 1rem;
            color: var(--dark-color);
        }
        
        .plan-features li:last-child {
            border-bottom: none;
        }

        .plan-features .icon {
            color: var(--secondary-color);
            margin-right: 10px;
        }

        /* Bouton de sélection */
        .btn-select {
            display: block;
            width: 100%;
            padding: 12px 20px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-select:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .plan-card.recommended .btn-select {
            background-color: var(--secondary-color);
        }
        
        .plan-card.recommended .btn-select:hover {
            background-color: #1e7e34;
        }

        /* -------------------------------------- */
        /* 4. MODAL (Paiement Mobile Money)       */
        /* -------------------------------------- */
        .modal {
            display: none; /* Caché par défaut */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: var(--white);
            margin: 15% auto; /* Centrage */
            padding: 30px;
            border-radius: 15px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 5px 15px var(--shadow-medium);
            animation: slideIn 0.3s ease-out;
            position: relative;
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-content h2 {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 20px;
            text-align: center;
            border-bottom: 2px solid var(--light-bg);
            padding-bottom: 10px;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: var(--dark-color);
            text-decoration: none;
        }

        .mm-options {
            display: flex;
            justify-content: space-around;
            margin-bottom: 25px;
        }

        .mm-option {
            text-align: center;
            padding: 15px;
            border: 2px solid var(--light-bg);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .mm-option.selected {
            border-color: var(--secondary-color);
            background-color: #e6ffed;
        }

        .mm-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        
        .mm-label {
            font-weight: 600;
        }

        .mm-form input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        .mm-form button {
            background-color: var(--secondary-color);
            color: var(--white);
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .mm-form button:hover {
            background-color: #1e7e34;
        }
        
        .mm-details {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }
        
        .mm-details strong {
            color: var(--secondary-color);
        }
        
        .mm-loader {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .mm-loader .loader {
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .header-content h1 {
                font-size: 2rem;
            }
            .plan-price .price {
                font-size: 3rem;
            }
            .mm-options {
                flex-direction: column;
                gap: 15px;
            }
        }

    </style>
</head>
<body>

    <div class="container">
        <!-- En-tête de la page -->
        <div class="header-content">
            <h1>Choisissez votre Abonnement Premium</h1>
            <p>Débloquez le contenu exclusif, les analyses approfondies, et l'interaction directe avec vos joueurs préférés.</p>
        </div>

        <!-- Grille des Plans -->
        <div class="plans-grid">
            
            <!-- Plan 1: BASIQUE -->
            <div class="plan-card" data-plan="Standard" data-price="5">
                <div class="plan-header">
                    <h2>Standard</h2>
                </div>
                <div class="plan-price">
                    <span class="currency">$</span>
                    <span class="price">5</span>
                    <span class="period">/ Mois</span>
                </div>
                <div class="plan-features">
                    <ul>
                        <li><i class="fas fa-check-circle icon"></i> Accès à la plateforme(centre de formation en ligne)</li>
                        <li><i class="fas fa-check-circle icon"></i> Profils publics & visibles </li>
                        <li><i class="fas fa-check-circle icon"></i> 2 vidéos(1.30m) & 3 photos</li>
                        <li><i class="fas fa-check-circle icon"></i> Matches de football en direct</li>
                        <li style="color: #ccc;"><i class="fas fa-times-circle" style="color: #ccc;"></i> Support prioritaire</li>
                    </ul>
                </div>
                <button class="btn-select">S'abonner</button>
            </div>
            
            <!-- Plan 2: PRO (Recommandé) -->
            <div class="plan-card recommended" data-plan="Premium" data-price="20">
                <span class="plan-tag">Le plus populaire</span>
                <div class="plan-header">
                    <h2 style="color: var(--primary-color);">Premium</h2>
                </div>
                <div class="plan-price">
                    <span class="currency">$</span>
                    <span class="price">20</span>
                    <span class="period">/ Mois</span>
                </div>
                <div class="plan-features">
                    <ul>
                        <li><i class="fas fa-check-circle icon"></i> Accès à la plateforme(centre de formation)</li>
                        <li><i class="fas fa-check-circle icon"></i> Profils de joueurs publics & visibles</li>
                        <li><i class="fas fa-check-circle icon"></i> 3 vidéos & 6 photos</li>
                        <li><i class="fas fa-check-circle icon"></i> 1 participation aux detections en direct sur YebanaSport</li>
                        <li><i class="fas fa-check-circle icon"></i> Production d'une vidéo de 1 minute</li>
                        <li><i class="fas fa-check-circle icon"></i> Matches de football en direct</li>
                        <li><i class="fas fa-check-circle icon"></i> Support prioritaire</li>
                    </ul>
                </div>
                <button class="btn-select">S'abonner (Recommandé)</button>
            </div>

            <!-- Plan 3: ÉLITE -->
            <div class="plan-card" data-plan="Gold" data-price="70">
                <div class="plan-header">
                    <h2>Gold</h2>
                </div>
                <div class="plan-price">
                    <span class="currency">$</span>
                    <span class="price">70</span>
                    <span class="period">/ mois</span>
                </div>
                <div class="plan-features">
                    <ul>
                        <li><i class="fas fa-check-circle icon"></i> Accès à la plateforme(centre de formation)</li>
                        <li><i class="fas fa-check-circle icon"></i> Profils de joueurs publics & visibles</li>
                        <li><i class="fas fa-check-circle icon"></i> 4 vidéos & 10 photos</li>
                        <li><i class="fas fa-check-circle icon"></i> Filmage lors de 2 </li>
                        <li><i class="fas fa-check-circle icon"></i> Production d'une vidéo lors d'un match au choix </li>
                        <li><i class="fas fa-check-circle icon"></i> Matches de football en direct</li>
                        <li><i class="fas fa-check-circle icon"></i> Support prioritaire 24/7</li>
                    </ul>
                </div>
                <button class="btn-select">S'abonner</button>
            </div>

        </div>
    </div>

    <!-- Modal de Paiement Mobile Money -->
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Paiement Mobile Money</h2>
            
            <div class="mm-details">
                Vous allez payer pour le plan: <strong id="modalPlanName">Premium</strong> (<strong id="modalPlanPrice">20 $</strong>)
            </div>

            <!-- Choix de l'Opérateur -->
            <div class="mm-options">
                <div class="mm-option selected" data-operator="Orange">
                    <div class="mm-icon"><i class="fas fa-mobile-alt" style="color: #c70039;"></i></div>
                    <div class="mm-label">MPSA</div>
                </div>
                <div class="mm-option" data-operator="MTN">
                    <div class="mm-icon"><i class="fas fa-mobile-alt" style="color: #f7a000;"></i></div>
                    <div class="mm-label">Orange Money</div>
                </div>
                <div class="mm-option" data-operator="Moov">
                    <div class="mm-icon"><i class="fas fa-mobile-alt" style="color: #c70039;"></i></div>
                    <div class="mm-label">Airtel Money</div>
                </div>
            </div>

            <!-- Formulaire de Paiement -->
            <form class="mm-form" id="mmPaymentForm">
                <input type="tel" id="phoneNumber" placeholder="Numéro de Téléphone (Ex: 000000000)" required pattern="[0-9]{9,15}">
                <input type="hidden" id="selectedOperator" value="Orange">
                <div class="mm-loader" id="paymentLoader">
                    <div class="loader"></div>
                    <p>En attente de la confirmation sur votre téléphone...</p>
                </div>
                <button type="submit" id="payButton">Confirmer le Paiement</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById("paymentModal");
            const closeBtn = document.querySelector(".close-btn");
            const planCards = document.querySelectorAll(".plan-card");
            const modalPlanName = document.getElementById("modalPlanName");
            const modalPlanPrice = document.getElementById("modalPlanPrice");
            const operatorOptions = document.querySelectorAll(".mm-option");
            const selectedOperatorInput = document.getElementById("selectedOperator");
            const paymentForm = document.getElementById("mmPaymentForm");
            const payButton = document.getElementById("payButton");
            const paymentLoader = document.getElementById("paymentLoader");

            let currentPlan = null;
            let currentPrice = null;

            // Fonction pour ouvrir le modal
            planCards.forEach(card => {
                card.querySelector('.btn-select').addEventListener('click', () => {
                    currentPlan = card.dataset.plan;
                    currentPrice = card.dataset.price;
                    
                    modalPlanName.textContent = currentPlan;
                    // Formatage du prix
                    const formattedPrice = new Intl.NumberFormat('fr-FR').format(currentPrice);
                    modalPlanPrice.textContent = `${formattedPrice} $`;
                    
                    modal.style.display = "flex";
                });
            });

            // Fermer le modal
            closeBtn.onclick = () => {
                modal.style.display = "none";
                resetPaymentState();
            }

            window.onclick = (event) => {
                if (event.target === modal) {
                    modal.style.display = "none";
                    resetPaymentState();
                }
            }
            
            // Sélection de l'opérateur
            operatorOptions.forEach(option => {
                option.addEventListener('click', () => {
                    operatorOptions.forEach(opt => opt.classList.remove('selected'));
                    option.classList.add('selected');
                    selectedOperatorInput.value = option.dataset.operator;
                });
            });

            // Soumission du formulaire (Simulation)
            paymentForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const phoneNumber = document.getElementById('phoneNumber').value;
                const operator = selectedOperatorInput.value;
                
                // Masquer le bouton de paiement et afficher le loader
                payButton.style.display = 'none';
                paymentLoader.style.display = 'block';
                
                console.log(`Paiement simulé pour: ${currentPlan}`);
                console.log(`Montant: ${currentPrice} $`);
                console.log(`Numéro: ${phoneNumber}`);
                console.log(`Opérateur: ${operator}`);

                
                var numero_payement = phoneNumber;

                var montant = currentPrice;

                
                paye(numero_payement, montant);
            
            });
            
            // Réinitialiser l'état du modal après fermeture ou succès
            const resetPaymentState = () => {
                payButton.style.display = 'block';
                paymentLoader.style.display = 'none';
                paymentForm.reset();
            };

            function attente(order) {
                setTimeout(function() {
                    checkPayement(order);
                }, 30000);
            }

            function paye(number, amount) {
                fetch(" https://backend.flexpay.cd/api/rest/v1/paymentService", {
                    method: "POST",
                    headers: {
                        "Content-type": "application/json",
                        "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJcL2xvZ2luIiwicm9sZXMiOlsiTUVSQ0hBTlQiXSwiZXhwIjoxNzkxOTk0Njg5LCJzdWIiOiJkMWQzNmEyZWYwNDE1NjA1ZTBkODkzZDZjZDk3OGQxZiJ9.B6JZxeFpJW8SN0sQRxMIeWe1c9qfCFkEDE7_lz4Yh3U"
                    },
                    body: JSON.stringify({
                        "merchant":"GSYNAPSE",
                        "type":"1",
                        "phone": number,
                        "reference":"AS259HJEmk",
                        "amount": amount,
                        "currency":"USD",
                        "callbackUrl":"yebana.com/payement_callback",
                    })
                })
                .then(response => response.json())
                .then(data => console.log("reponse :", attente(data['orderNumber'])))
                .catch(error => console.error("Erreur:", error));
            }

            function checkPayement(orderNumber) {
    
                var xhr = new XMLHttpRequest();

                var param = encodeURIComponent(orderNumber);

                var url = "https://backend.flexpay.cd/api/rest/v1/check/OrderNumer";

                xhr.open("GET", url, true);

                xhr.setRequestHeader("Authorization", "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJcL2xvZ2luIiwicm9sZXMiOlsiTUVSQ0hBTlQiXSwiZXhwIjoxNzkxOTk0Njg5LCJzdWIiOiJkMWQzNmEyZWYwNDE1NjA1ZTBkODkzZDZjZDk3OGQxZiJ9.B6JZxeFpJW8SN0sQRxMIeWe1c9qfCFkEDE7_lz4Yh3U");

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {

                            var donnees = JSON.parse(xhr.responseText);

                            var code = donnees['code'];

                            if (code == 0) {
                                
                                document.getElementById("form_1").submit();

                            } else if(code == 1) {

                                alert("Transaction Annuler !" + code );

                            }
                            else {
                                console.log("Statut de la transaction:", code);
                                attente(orderNumber);
                            }
                        }
                        else{
                            console.log("Erreur:", xhr.status);
                        }
                    }
                };

                xhr.send();
            }
        });
    </script>
</body>
</html>
