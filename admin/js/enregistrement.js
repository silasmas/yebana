document.addEventListener('DOMContentLoaded', () => {

    const agentRegistrationForm = document.getElementById('agentRegistrationForm');
    const messagePatience = document.getElementById('message-patience');
    const messageErreur = document.getElementById('message-erreur');
    const messageSucces = document.getElementById('message-succes');

    // 4. Gestion de la soumission du formulaire
    agentRegistrationForm.addEventListener('submit', (event) => {

        event.preventDefault(); // Empêche l'envoi par défaut du formulaire

        messagePatience.style.display = 'block'; 

        const formData = new FormData(agentRegistrationForm);

        fetch('register_agent.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text()) // Récupère la réponse en tant que texte
        .then(data => {
            messagePatience.style.display = 'none'; // Cache le message de patience
            if (data === 'success') {
                messageSucces.style.display = 'block'; // Affiche le message de succès
                agentRegistrationForm.reset(); // Réinitialise le formulaire
                // Optionnel : On pourrait recharger la liste des produits ici si on voulait un affichage immédiat
                setTimeout(() => {
                    messageSucces.style.display = 'none';
            }, 3500); // Cache le message de succès après 3 secondes
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