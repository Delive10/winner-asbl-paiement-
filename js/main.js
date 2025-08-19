(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Initiate the wowjs
    new WOW().init();
    
    
    // Dropdown on mouse hover
    const $dropdown = $(".dropdown");
    const $dropdownToggle = $(".dropdown-toggle");
    const $dropdownMenu = $(".dropdown-menu");
    const showClass = "show";
    
    $(window).on("load resize", function() {
        if (this.matchMedia("(min-width: 992px)").matches) {
            $dropdown.hover(
            function() {
                const $this = $(this);
                $this.addClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "true");
                $this.find($dropdownMenu).addClass(showClass);
            },
            function() {
                const $this = $(this);
                $this.removeClass(showClass);
                $this.find($dropdownToggle).attr("aria-expanded", "false");
                $this.find($dropdownMenu).removeClass(showClass);
            }
            );
        } else {
            $dropdown.off("mouseenter mouseleave");
        }
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Facts counter
    $('[data-toggle="counter-up"]').counterUp({
        delay: 10,
        time: 2000
    });


    // Modal Video - Gestion de la lecture vidéo locale
    $(document).ready(function () {
        var videoElement = document.getElementById('video');
        
        // Démarrer la lecture lorsque la modale s'ouvre
        $('#videoModal').on('shown.bs.modal', function (e) {
            if (videoElement) {
                videoElement.play().catch(function(error) {
                    console.error('Erreur de lecture vidéo:', error);
                });
            }
        });

        // Mettre en pause et réinitialiser la vidéo lorsque la modale se ferme
        $('#videoModal').on('hidden.bs.modal', function (e) {
            if (videoElement) {
                videoElement.pause();
                videoElement.currentTime = 0;
            }
        });
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 25,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            768:{
                items:2
            }
        }
    });
    
    // Partenaires carousel
    $(".partner-carousel").owlCarousel({
        loop: true,
        margin: 20,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: { 
                items: 2,
                nav: false
            },
            576: { 
                items: 3,
                nav: false
            },
            768: { 
                items: 4,
                nav: false
            },
            992: { 
                items: 5,
                nav: false
            }
        }
    });
    
})(jQuery);







document.addEventListener('DOMContentLoaded', function() {
    // Initialiser les compteurs depuis le stockage local
    initializeCounters();
    
    // Ajouter des écouteurs d'événements pour la touche Entrée dans les champs de commentaires
    document.querySelectorAll('.comment-form input').forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const projectId = this.id.split('-')[2];
                postComment('project' + projectId, this.id);
            }
        });
    });
    // Initialisation des compteurs depuis le stockage local
    initializeCounters();
    
    // Gestion des clics sur les boutons "J'aime"
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const projectId = this.getAttribute('data-project');
            likeProject(projectId);
        });
    });
    
    // Gestion des clics sur les boutons "Commentaires"
    document.querySelectorAll('.comment-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const projectId = this.getAttribute('data-project');
            toggleComments(projectId);
        });
    });
    
    // Gestion de la soumission des commentaires
    document.querySelectorAll('.post-comment').forEach(button => {
        button.addEventListener('click', function() {
            const projectId = this.getAttribute('data-project');
            const commentInput = this.closest('.input-group').querySelector('.comment-input');
            postComment(projectId, commentInput);
        });
    });
    
    // Permettre la soumission avec la touche Entrée
    document.querySelectorAll('.comment-input').forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const projectId = this.closest('.comments-section').querySelector('.post-comment').getAttribute('data-project');
                postComment(projectId, this);
            }
        });
    });
});

function initializeCounters() {
    // Initialiser les compteurs pour chaque projet
    for (let i = 1; i <= 4; i++) {
        // Initialiser les likes
        const likeCount = localStorage.getItem(`project_${i}_likes`) || 0;
        document.querySelector(`#project-${i} .like-count`).textContent = likeCount;
        
        // Initialiser les commentaires
        const comments = JSON.parse(localStorage.getItem(`project_${i}_comments`) || '[]');
        document.querySelector(`#project-${i} .comment-count`).textContent = comments.length;
        
        // Afficher les commentaires existants
        if (comments.length > 0) {
            const commentsList = document.querySelector(`#comments-${i} .comments-list`);
            commentsList.innerHTML = comments.map(comment => 
                `<div class="comment-item mb-2 p-2 bg-light rounded">
                    <strong>Utilisateur:</strong> ${comment}
                </div>`
            ).join('');
        }
    }
}

function likeProject(projectId) {
    const likeCountElement = document.querySelector(`#project-${projectId} .like-count`);
    let likes = parseInt(localStorage.getItem(`project_${projectId}_likes`) || 0);
    likes++;
    localStorage.setItem(`project_${projectId}_likes`, likes);
    likeCountElement.textContent = likes;
    
    // Désactiver le bouton après avoir aimé
    const likeButton = document.querySelector(`#project-${projectId} .like-btn`);
    likeButton.disabled = true;
    likeButton.classList.remove('btn-outline-primary');
    likeButton.classList.add('btn-primary');
}

function toggleComments(projectId) {
    const commentsSection = document.getElementById(`comments-${projectId}`);
    if (commentsSection.style.display === 'none' || !commentsSection.style.display) {
        commentsSection.style.display = 'block';
    } else {
        commentsSection.style.display = 'none';
    }
}

function postComment(projectId, inputElement) {
    const comment = inputElement.value.trim();
    if (!comment) return;
    
    // Récupérer les commentaires existants
    const comments = JSON.parse(localStorage.getItem(`project_${projectId}_comments`) || '[]');
    
    // Ajouter le nouveau commentaire
    comments.push(comment);
    localStorage.setItem(`project_${projectId}_comments`, JSON.stringify(comments));
    
    // Mettre à jour l'affichage
    const commentsList = document.querySelector(`#comments-${projectId} .comments-list`);
    const commentElement = document.createElement('div');
    commentElement.className = 'comment-item mb-2 p-2 bg-light rounded';
    commentElement.innerHTML = `<strong>Utilisateur:</strong> ${comment}`;
    commentsList.appendChild(commentElement);
    
    // Mettre à jour le compteur de commentaires
    const commentCountElement = document.querySelector(`#project-${projectId} .comment-count`);
    commentCountElement.textContent = comments.length;
    
    // Réinitialiser le champ de saisie
    inputElement.value = '';
}











function initializeCounters() {
    // Initialiser les compteurs de likes
    for (let i = 1; i <= 4; i++) {
        const likes = localStorage.getItem(`project${i}-likes`) || 0;
        const comments = JSON.parse(localStorage.getItem(`project${i}-comments`) || '[]').length;
        
        document.getElementById(`like-count-${i}`).textContent ;
        document.getElementById(`comment-count-${i}`).textContent = comments;
        
        // Mettre à jour l'affichage des commentaires
        updateCommentsDisplay(`project${i}`);
        
        // Mettre à jour l'état des boutons like
        const likeBtn = document.querySelector(`button[onclick="likeProject('project${i}')"]`);
        if (likeBtn && likeBtn.classList.contains('liked')) {
            likeBtn.innerHTML = '<i class="fas fa-thumbs-up"></i> ' + likes;
        }
    }
}

function likeProject(projectId) {
    const likeBtn = document.querySelector(`button[onclick="likeProject('${projectId}')"]`);
    const likeCount = document.getElementById(`like-count-${projectId}`);
    const likeTotal = document.getElementById(`like-total-${projectId}`);
    
    // Récupérer le nombre actuel de likes depuis le stockage local ou initialiser à 0
    let currentLikes = parseInt(localStorage.getItem(`${projectId}-likes`)) || 0;
    let userLiked = localStorage.getItem(`user-liked-${projectId}`) === 'true';
    
    if (userLiked) {
        // Retirer le like
        currentLikes--;
        likeBtn.innerHTML = '<i class="far fa-thumbs-up"></i> ' + (currentLikes > 0 ? currentLikes : '');
        likeBtn.classList.remove('liked');
        localStorage.setItem(`user-liked-${projectId}`, 'false');
    } else {
        // Ajouter un like
        currentLikes++;
        likeBtn.innerHTML = '<i class="fas fa-thumbs-up"></i> ' + (currentLikes > 0 ? currentLikes : '');
        likeBtn.classList.add('liked');
        localStorage.setItem(`user-liked-${projectId}`, 'true');
    }
    
    // Mettre à jour les compteurs
    if (likeCount) likeCount.textContent = currentLikes > 0 ? currentLikes : '';
    if (likeTotal) likeTotal.textContent = currentLikes;
    
    // Sauvegarder dans le stockage local
    localStorage.setItem(`${projectId}-likes`, currentLikes);
}

// Initialiser les compteurs de likes au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Pour chaque projet, initialiser le nombre de likes
    const projectIds = ['sante-1', 'sante-2', 'education-1', 'formation-1', 'plaidoyer-1'];
    
    projectIds.forEach(projectId => {
        const likeCount = document.getElementById(`like-count-${projectId}`);
        const likeTotal = document.getElementById(`like-total-${projectId}`);
        const likeBtn = document.querySelector(`button[onclick="likeProject('${projectId}')"]`);
        
        if (likeCount && likeTotal && likeBtn) {
            // Récupérer le nombre de likes depuis le stockage local
            const savedLikes = parseInt(localStorage.getItem(`${projectId}-likes`)) || 0;
            const userLiked = localStorage.getItem(`user-liked-${projectId}`) === 'true';
            
            // Mettre à jour l'interface utilisateur
            likeCount.textContent = savedLikes > 0 ? savedLikes : '';
            likeTotal.textContent = savedLikes;
            
            // Mettre à jour l'état du bouton
            if (userLiked) {
                likeBtn.innerHTML = `<i class="fas fa-thumbs-up"></i> ${savedLikes > 0 ? savedLikes : ''}`;
                likeBtn.classList.add('liked');
            } else {
                likeBtn.innerHTML = `<i class="far fa-thumbs-up"></i> ${savedLikes > 0 ? savedLikes : ''}`;
                likeBtn.classList.remove('liked');
            }
        }
    });
});

function toggleComments(projectId) {
    const commentsSection = document.getElementById(`comments-${projectId}`);
    const commentBtn = document.querySelector(`button[onclick="toggleComments('${projectId}')"]`);
    
    if (commentsSection.style.display === 'none' || !commentsSection.style.display) {
        commentsSection.style.display = 'block';
        commentBtn.classList.add('active');
        // Mettre à jour l'affichage des commentaires
        updateCommentsDisplay(projectId);
        // Faire défiler jusqu'à la section des commentaires
        commentsSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    } else {
        commentsSection.style.display = 'none';
        commentBtn.classList.remove('active');
    }
}

function postComment(projectId, inputId) {
    const inputElement = document.getElementById(inputId);
    const commentText = inputElement.value.trim();
    
    if (!commentText) return;
    
    // Récupérer les commentaires existants
    const comments = JSON.parse(localStorage.getItem(`${projectId}-comments`) || '[]');
    
    // Ajouter le nouveau commentaire
    const newComment = {
        id: Date.now(),
        text: commentText,
        timestamp: new Date().toISOString(),
        user: 'Utilisateur ' // Pourrait être remplacé par le nom de l'utilisateur connecté
    };
    
    comments.unshift(newComment); // Ajouter au début du tableau pour afficher les plus récents en premier
    
    // Sauvegarder les commentaires
    localStorage.setItem(`${projectId}-comments`, JSON.stringify(comments));
    
    // Mettre à jour l'affichage
    updateCommentsDisplay(projectId);
    
    // Mettre à jour le compteur de commentaires
    const commentCount = document.getElementById(`comment-count-${projectId.slice(-1)}`);
    commentCount.textContent = comments.length;
    
    // Réinitialiser le champ de saisie
    inputElement.value = '';
    
    // Remettre le focus sur le champ de saisie
    inputElement.focus();
}

function updateCommentsDisplay(projectId) {
    const commentsContainer = document.querySelector(`#comments-${projectId} .comments-list`);
    const noCommentsMsg = commentsContainer.querySelector('.no-comments');
    const comments = JSON.parse(localStorage.getItem(`${projectId}-comments`) || '[]');
    
    // Vider le conteneur
    commentsContainer.innerHTML = '';
    
    if (comments.length === 0) {
        // Afficher le message "Aucun commentaire"
        const msg = document.createElement('div');
        msg.className = 'no-comments text-muted text-center py-3';
        msg.textContent = 'Aucun Feedback pour le moment';
        commentsContainer.appendChild(msg);
    } else {
        // Afficher les commentaires (du plus récent au plus ancien)
        comments.forEach(comment => {
            const commentElement = document.createElement('div');
            commentElement.className = 'comment-item p-3 border-bottom';
            commentElement.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <strong class="text-primary">${comment.user}</strong>
        
                </div>
                <div class="comment-text">${escapeHtml(comment.text)}</div>
            `;
            commentsContainer.appendChild(commentElement);
        });
        
        // Faire défiler vers le bas pour voir le nouveau commentaire
        commentsContainer.scrollTop = 0;
    }
}

function formatDate(timestamp) {
    const date = new Date(timestamp);
    return date.toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Fonction pour copier le lien de l'article dans le presse-papiers
function copyArticleLink(articleId) {
    // Construire l'URL complète avec l'ancre
    const articleUrl = window.location.href.split('#')[0] + '#' + articleId;
    
    // Copier dans le presse-papiers
    navigator.clipboard.writeText(articleUrl).then(function() {
        // Afficher un message de succès
        const tooltip = document.createElement('div');
        tooltip.className = 'position-fixed bg-success text-white px-3 py-2 rounded';
        tooltip.textContent = 'Lien copié !';
        tooltip.style.top = '20px';
        tooltip.style.right = '20px';
        tooltip.style.zIndex = '9999';
        document.body.appendChild(tooltip);
        
        // Supprimer le message après 2 secondes
        setTimeout(function() {
            tooltip.remove();
        }, 2000);
    }).catch(function(err) {
        console.error('Erreur lors de la copie du lien: ', err);
    });
}

// Fonction pour effectuer la recherche dans les articles
function performSearch(searchTerm) {
    // Convertir le terme de recherche en minuscules pour une recherche insensible à la casse
    const searchTermLower = searchTerm.toLowerCase().trim();
    
    // Sélectionner tous les articles
    const articles = document.querySelectorAll('.blog-item');
    let hasResults = false;
    
    // Parcourir tous les articles
    articles.forEach(article => {
        // Trouver le titre de l'article
        const titleElement = article.querySelector('h4');
        const title = titleElement ? titleElement.textContent.toLowerCase() : '';
        
        // Vérifier si le titre contient le terme de recherche
        if (title.includes(searchTermLower)) {
            article.style.display = ''; // Afficher l'article
            hasResults = true;
        } else {
            article.style.display = 'none'; // Masquer l'article
        }
    });
    
    // Afficher un message si aucun résultat n'est trouvé
    const noResultsMessage = document.getElementById('no-results-message');
    if (!hasResults) {
        if (!noResultsMessage) {
            const container = document.querySelector('.col-lg-7');
            const message = document.createElement('div');
            message.id = 'no-results-message';
            message.className = 'alert alert-warning';
            message.textContent = 'Aucun article ne correspond à votre recherche.';
            container.appendChild(message);
        }
    } else if (noResultsMessage) {
        noResultsMessage.remove();
    }
}

// Fonction pour filtrer les articles par catégorie
function filterByCategory(category) {
    const articles = document.querySelectorAll('.blog-item');
    let visibleCount = 0;
    
    articles.forEach(article => {
        const articleCategory = article.getAttribute('data-category');
        if (category === 'Tous' || articleCategory === category) {
            article.style.display = '';
            visibleCount++;
        } else {
            article.style.display = 'none';
        }
    });
    
    // Mettre à jour le compteur de résultats
    updateResultsCount(visibleCount);
    
    // Mettre à jour l'élément actif dans la liste des catégories
    updateActiveCategory(category);
}

// Fonction pour mettre à jour le compteur de résultats
function updateResultsCount(count) {

    if (!resultsCount) {
        const container = document.querySelector('.col-lg-7');
        const countElement = document.createElement('div');
        countElement.id = 'results-count';
        countElement.className = 'mb-4 text-muted';
        countElement.textContent = `${count} article${count > 1 ? 's' : ''} trouvé${count > 1 ? 's' : ''}`;
        container.insertBefore(countElement, container.firstChild);
    } else {
        resultsCount.textContent = `${count} article${count > 1 ? 's' : ''} trouvé${count > 1 ? 's' : ''}`;
    }
}

// Fonction pour mettre à jour la catégorie active
function updateActiveCategory(activeCategory) {
    const categoryLinks = document.querySelectorAll('.category-link');
    categoryLinks.forEach(link => {
        const linkCategory = link.getAttribute('data-category');
        if (linkCategory === activeCategory) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

// Gestion de l'affichage complet des articles
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation du filtrage par catégorie
    const categoryLinks = document.querySelectorAll('.category-link');
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const category = this.getAttribute('data-category');
            filterByCategory(category);
            
            // Faire défiler vers le haut des résultats
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            
            // Mettre à jour l'URL avec la catégorie
            history.pushState({ category }, '', `?category=${encodeURIComponent(category)}`);
        });
    });
    
    // Vérifier si une catégorie est spécifiée dans l'URL au chargement
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('category');
    if (categoryParam) {
        // Trouver et déclencher le clic sur la catégorie correspondante
        const categoryToSelect = Array.from(categoryLinks).find(
            link => link.getAttribute('data-category') === categoryParam
        );
        if (categoryToSelect) {
            categoryToSelect.click();
        }
    }
    // Gestion de la recherche
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    
    // Fonction pour exécuter la recherche
    function executeSearch() {
        const searchTerm = searchInput.value;
        if (searchTerm.length > 0) {
            performSearch(searchTerm);
        } else {
            // Si le champ est vide, afficher tous les articles
            document.querySelectorAll('.blog-item').forEach(article => {
                article.style.display = '';
            });
            const noResultsMessage = document.getElementById('no-results-message');
            if (noResultsMessage) noResultsMessage.remove();
        }
    }
    
    // Écouter le clic sur le bouton de recherche
    if (searchButton) {
        searchButton.addEventListener('click', executeSearch);
    }
    
    // Écouter la touche Entrée dans le champ de recherche
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                executeSearch();
            }
        });
        
        // Réinitialiser l'affichage si l'utilisateur efface le champ
        searchInput.addEventListener('input', function() {
            if (this.value === '') {
                document.querySelectorAll('.blog-item').forEach(article => {
                    article.style.display = '';
                });
                const noResultsMessage = document.getElementById('no-results-message');
                if (noResultsMessage) noResultsMessage.remove();
            }
        });
    }
    // Gestion du clic sur les boutons de copie de lien
    document.addEventListener('click', function(e) {
        if (e.target.closest('.copy-link')) {
            e.preventDefault();
            const button = e.target.closest('.copy-link');
            const articleId = button.getAttribute('data-article-id');
            if (articleId) {
                copyArticleLink(articleId);
            }
        }
    });

    // Vérifier si l'URL contient une ancre et faire défiler jusqu'à l'article correspondant
    if (window.location.hash) {
        const articleId = window.location.hash.substring(1);
        const article = document.getElementById(articleId);
        if (article) {
            setTimeout(() => {
                article.scrollIntoView({ behavior: 'smooth' });
            }, 100);
        }
    }
    // Délégation d'événement pour gérer les clics sur les boutons "Lire Plus"
    document.addEventListener('click', function(e) {
        if (e.target.closest('.read-more-btn')) {
            e.preventDefault();
            const btn = e.target.closest('.read-more-btn');
            const articleId = btn.getAttribute('data-article');
            const articlePreview = btn.previousElementSibling.previousElementSibling; // .article-preview
            const articleFull = btn.previousElementSibling; // .article-full
            const icon = btn.querySelector('i');
            
            if (articleFull.classList.contains('d-none')) {
                // Afficher l'article complet
                articlePreview.style.display = 'none';
                articleFull.classList.remove('d-none');
                btn.innerHTML = 'Lire Moins <i class="fa fa-arrow-up ms-2"></i>';
                
                // Faire défiler doucement jusqu'au bouton
                btn.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                // Revenir à l'aperçu
                articlePreview.style.display = 'block';
                articleFull.classList.add('d-none');
                btn.innerHTML = 'Lire Plus <i class="fa fa-arrow-down ms-2"></i>';
            }
        }
    });
});


const fs = require('fs');
const path = require('path');

const filePath = path.join(__dirname, 'portfolio.html');

// Lire le contenu du fichier
fs.readFile(filePath, 'utf8', (err, data) => {
  if (err) {
    console.error('Erreur lors de la lecture du fichier:', err);
    return;
  }

  // Remplacer toutes les occurrences de la classe
  const updatedContent = data.replace(
    /<div class="mt-auto d-flex align-items-center">/g,
    '<div class="mt-auto d-flex align-items-center justify-content-between w-100">'
  );

  // Écrire les modifications dans le fichier
  fs.writeFile(filePath, updatedContent, 'utf8', (err) => {
    if (err) {
      console.error('Erreur lors de l\'écriture du fichier:', err);
      return;
    }
    console.log('Mise à jour terminée avec succès !');
  });
});