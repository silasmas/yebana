document.addEventListener('DOMContentLoaded', function() {
    const playersTodayElement = document.getElementById('playersToday');
    const managersTodayElement = document.getElementById('managersToday');
    const recruitersTodayElement = document.getElementById('recruitersToday');
    const agentPerformanceBody = document.getElementById('agentPerformanceBody');
    const pendingRegistrationsBody = document.getElementById('pendingRegistrationsBody'); // Nouveau : pour le tableau des enregistrements en attente

    // --- Fonctions de Simulation (pour la démo) ---
    function updateStats() {
        
    }

    // --- Nouvelle Fonction : Gérer l'approbation ---
    function handleApproval(event) {
        // Vérifie si le clic est sur un bouton "Approuver"
        if (event.target.classList.contains('approve') || event.target.closest('.approve')) {
            // Trouve le bouton parent si l'icône a été cliquée
            const approveButton = event.target.classList.contains('approve') ? event.target : event.target.closest('.approve');

            // Trouve la ligne (<tr>) parente du bouton
            const row = approveButton.closest('tr');
            if (!row) {
                console.error("Impossible de trouver la ligne parente du bouton d'approbation.");
                return;
            }

            // Récupère l'ID de l'enregistrement depuis la première colonne de la ligne
            const recordId = row.cells[0].textContent.trim(); // cells[0] est la première colonne (ID)
            const userType = row.cells[1].textContent.trim(); // cells[1] est la deuxième colonne (Type d'utilisateur)

            if (!recordId) {
                console.error("ID d'enregistrement introuvable.");
                return;
            }

            // Confirmation par l'administrateur
            if (!confirm(`Voulez-vous vraiment approuver l'enregistrement de ${userType} ID: ${recordId} ?`)) {
                return; // Annule si l'admin clique sur "Annuler"
            }

            console.log(`Tentative d'approbation pour l'enregistrement ID: ${recordId}, Type: ${userType}`);

            // Effectue la requête Fetch vers la page PHP d'approbation
            // Note: Le chemin vers approve_registration.php doit être correct.
            // Si approve_registration.php est dans un dossier 'api' à la racine, ce serait '/api/approve_registration.php'
            // Si c'est dans le même dossier admin, ce serait 'approve_registration.php'
            fetch('approve_registration.php', {
                method: 'POST', // Utiliser POST pour envoyer des données
                headers: {
                    'Content-Type': 'application/json' // Indique que nous envoyons du JSON
                },
                body: JSON.stringify({
                    id: recordId,
                    type: userType // Il peut être utile d'envoyer le type d'utilisateur
                })
            })
            .then(response => {
                // Vérifie si la réponse est OK (statut 200)
                if (!response.ok) {
                    // Si la réponse n'est pas OK, lance une erreur
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Erreur réseau ou du serveur.');
                    });
                }
                return response.json(); // Parse la réponse JSON
            })
            .then(data => {
                if (data.success) {
                    alert(`Enregistrement ID: ${recordId} (${userType}) approuvé avec succès !`);
                    // Supprimer la ligne du tableau après l'approbation réussie
                    row.remove();
                    // Optionnel: rafraîchir les statistiques 'joueursToday' si c'est un joueur
                    if (userType === 'Joueur') {
                        playersTodayElement.textContent = parseInt(playersTodayElement.textContent) + 1;
                    }
                    // Vous pouvez aussi rafraîchir le tableau des enregistrements en attente via une nouvelle requête AJAX
                    // Ou simplement supprimer la ligne côté client.
                } else {
                    alert(`Échec de l'approbation pour ID: ${recordId}. ${data.message || 'Une erreur inconnue est survenue.'}`);
                }
            })
            .catch(error => {
                console.error('Erreur lors de la requête Fetch:', error);
                alert('Une erreur est survenue lors de l\'approbation : ' + error.message);
            });
        }
    }

    // Attacher l'écouteur d'événements au tableau des enregistrements en attente
    // Utiliser la délégation d'événements sur le tbody pour capturer les clics sur les boutons ajoutés dynamiquement
    pendingRegistrationsBody.addEventListener('click', handleApproval);
});