// soccer/live.js

document.addEventListener('DOMContentLoaded', () => {
    const pageTitle = document.getElementById('pageTitle');
    const videoGrid = document.getElementById('videoGrid');
    const noContentMessage = document.getElementById('noContentMessage');

    // Éléments de la modale vidéo
    const videoModal = document.getElementById('videoModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modalVideoTitle = document.getElementById('modalVideoTitle');
    const modalVideoPlayer = document.getElementById('modalVideoPlayer');

    // Fonction pour ouvrir la modale vidéo
    function openVideoModal(videoUrl, videoTitle) {
        modalVideoTitle.textContent = videoTitle;
        // Ajoute autoplay=1 pour que la vidéo commence automatiquement
        // et rel=0 pour ne pas afficher de vidéos suggérées à la fin (YouTube)
        const embedUrl = videoUrl.includes('youtube.com/watch?v=') 
        ? videoUrl.replace('watch?v=', 'embed/') + '?autoplay=1&rel=0'
        : videoUrl; // Pour d'autres plateformes, l'URL d'embed peut être différente

        modalVideoPlayer.src = embedUrl;
        videoModal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Empêche le défilement du corps
    }

    // Fonction pour fermer la modale vidéo
    function closeVideoModal() {
        modalVideoPlayer.src = ''; // Arrête la vidéo en vidant la source de l'iframe
        videoModal.classList.remove('active');
        document.body.style.overflow = ''; // Rétablit le défilement du corps
    }

    // Écouteurs d'événements pour la modale
    closeModalBtn.addEventListener('click', closeVideoModal);
    videoModal.addEventListener('click', (event) => {
        // Ferme la modale si on clique sur l'overlay (pas sur le contenu de la modale)
        if (event.target === videoModal) {
            closeVideoModal();
        }
    });

     videoGrid.style.display = 'grid'; // Affiche la grille si du contenu est trouvé

    // --- Gérer les clics sur les boutons "Regarder la Vidéo" ---
    // Utilisation de la délégation d'événements pour les boutons existants dans le DOM
    videoGrid.addEventListener('click', (event) => {
        const targetButton = event.target.closest('.btn-watch');
        if (targetButton) {
            const videoUrl = targetButton.dataset.videoUrl;
            const videoTitle = targetButton.dataset.videoTitle;
            openVideoModal(videoUrl, videoTitle);
        }
    });

    // Mettre à jour l'état actif de la navigation inférieure
    const currentPath = window.location.pathname;
    const navItems = document.querySelectorAll('.bottom-nav .nav-item');
    navItems.forEach(item => {
        item.classList.remove('active');
        // Vérifie si le chemin actuel correspond au href de l'élément de navigation
        // Utilise .endsWith() pour les correspondances partielles dans les sous-dossiers
        if (currentPath.endsWith(item.getAttribute('href'))) {
            item.classList.add('active');
        }
    });
});
