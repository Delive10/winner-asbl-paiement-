<!DOCTYPE html>
<html lang="en">
<head>
 <head>
    <meta charset="utf-8">
    <title>Projet de construction Ecole - Winner ASBL</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/ecole-header2.jpg" rel="icon">
    

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    
    <!-- Gallery Custom Styles -->
    <style>
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            padding: 20px 0;
        }
        
        .gallery-item {
            position: relative;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            group: gallery;
        }
        
        .gallery-item.hidden {
            display: none;
        }
        
        .gallery-item.show {
            display: block;
            animation: fadeInUp 0.5s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .gallery-item:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .gallery-item img,
        .gallery-item video {
            width: 100%;
            height: 400px;
            object-fit: cover;
            transition: all 0.4s ease;
            display: block;
        }
        
        .gallery-item:hover img,
        .gallery-item:hover video {
            transform: scale(1.1);
            filter: brightness(0.9);
        }
        
        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(13, 110, 253, 0.95), transparent);
            color: white;
            padding: 20px;
            transform: translateY(100%);
            transition: transform 0.4s ease;
        }
        
        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }
        
        .gallery-overlay h3 {
            margin: 0 0 8px 0;
            font-size: 1.3rem;
            font-weight: 600;
        }
        
        .gallery-overlay p {
            margin: 0;
            font-size: 0.95rem;
            opacity: 0.9;
        }
        
        .gallery-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.95);
            color: #0d6efd;
            padding: 8px 15px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover .gallery-badge {
            background: #0d6efd;
            color: white;
            transform: scale(1.05);
        }
        
        .gallery-video-controls {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.9);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
            pointer-events: none;
        }
        
        .gallery-item:hover .gallery-video-controls {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1.1);
        }
        
        .gallery-video-controls i {
            color: #0d6efd;
            font-size: 1.5rem;
        }
        
        /* Lightbox Modal */
        .gallery-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.95);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
        }
        
        .gallery-modal.active {
            display: flex;
        }
        
        .modal-content {
            max-width: 90%;
            max-height: 90%;
            position: relative;
            animation: modalFadeIn 0.3s ease;
        }
        
        .modal-content img,
        .modal-content video {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        
        .modal-close {
            position: absolute;
            top: -40px;
            right: 0;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .modal-close:hover {
            transform: scale(1.2);
            color: #0d6efd;
        }
        
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        .modal-dialog {
            max-width: 90vw;
            max-height: 90vh;
        }
        
        .modal-body {
            padding: 0;
            max-height: 80vh;
            overflow: auto;
        }
        
        .modal-body img,
        .modal-body video {
            max-width: 100%;
            max-height: 80vh;
            object-fit: contain;
        }
        
        .ratio {
            position: relative;
            width: 100%;
            height: 0;
            overflow: hidden;
        }
        
        .ratio-16x9 {
            padding-bottom: 56.25%;
        }
        
        .ratio > div {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
        }
        
        .ratio > div img,
        .ratio > div video {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        
            
            .gallery-item img,
            .gallery-item video {
                height: 300px;
            }
            
            .gallery-overlay {
                padding: 15px;
            }
            
            .gallery-overlay h3 {
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 20px;
            }
            
            .gallery-item img,
            .gallery-item video {
                height: 300px;
            }
            
            .gallery-overlay {
                padding: 15px;
            }
            
            .gallery-overlay h3 {
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 576px) {
            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 15px;
                padding: 10px 0;
            }
            
            .gallery-item img,
            .gallery-item video {
                height: 250px;
            }
            
            .gallery-badge {
                top: 10px;
                right: 10px;
                padding: 6px 12px;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
</head>
<body>
      
 <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

   
        <!-- Header Start -->
        <div class="container-fluid bg-dark px-0 fixed-top">
            <div class="row gx-0">
                <div class="col-lg-3 bg-dark d-none d-lg-block">
                    <a href="index.html" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                        <h1 class="m-0 text-primary  header-logo">Winner ASBL</h1>
                    </a>
                </div>
                <div class="col-lg-9">
                    <div class="row gx-0 bg-white d-none d-lg-flex">
                        <div class="col-lg-7 px-5 text-start">
                            <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                                <i class="fa fa-envelope text-primary me-2"></i>
                                <a href="mailto:infos@winnerasbl.org" class="mb-0">infos@winnerasbl.org</a>
                            </div>
                            <div class="h-100 d-inline-flex align-items-center py-2">
                                <i class="fab fa-whatsapp text-primary me-2"></i>
                                <a   href="https://wa.me/243838244225"  class="mb-0">+243 811 897 218</a>
                            </div>
                        </div>
                        <div class="col-lg-5 px-5 text-end">
                            <div class="d-inline-flex align-items-center py-2">
                                <a class="me-3" href="https://web.facebook.com/profile.php?id=100079774445676"><i class="fab fa-facebook-f"></i></a>
                                <a class="me-3" href="#"><i class="fab fa-tiktok"></i></a>
                                <a class="me-3" href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a class="me-3" href="#"><i class="fab fa-instagram"></i></a>
                                <a class="" href="#"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                    <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                        <a href="index.html" class="navbar-brand d-block d-lg-none">
                            <h1 class="m-0 text-primary  header-logo">Winner ASBL</h1>
                        </a>
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <a href="index.php" class="nav-item nav-link">Accueil</a>
                                <a href="about.php" class="nav-item nav-link">À Propos</a>
                                <a href="service.php" class="nav-item nav-link">Services</a>
                                <a href="portfolio.php" class="nav-item nav-link">Portfolio</a>
                                <a href="blog.php" class="nav-item nav-link">Blog</a>
                                <a href="contact.php" class="nav-item nav-link">Contact</a>
                            </div>
                            <a href="https://ap-gateway.mastercard.com/checkout/pay/SESSION0002267100723J8213059K55?checkoutVersion=1.0.0" class="btn btn-primary rounded-0 py-4 px-md-5 d-none d-lg-block">Faire un Don<i class="fa fa-arrow-right ms-3"></i></a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Header End -->


        <!-- Page Header Start -->
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url('img/ecole-header2.jpg');">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Projet Éducatif à Kinshasa</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Projet Éducatif</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header End -->

        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <h6 class="section-title text-start text-primary text-uppercase">Notre Projet</h6>
                        <h1 class="mb-4">Construction d'une <span class="text-primary">École Inclusive</span></h1>
                        <p class="mb-4">Notre projet de construction d'école vise à offrir un environnement éducatif adapté et inclusif pour les enfants atteints d'hydrocéphalie et d'autres handicaps. Cette école sera un lieu d'apprentissage, d'épanouissement et d'intégration sociale.</p>
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-check text-primary me-3"></i>
                                    <h6 class="mb-0">Salles de classe adaptées</h6>
                                </div>
                                <span>Des espaces conçus spécialement pour répondre aux besoins spécifiques des enfants.</span>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-check text-primary me-3"></i>
                                    <h6 class="mb-0">Équipements spécialisés</h6>
                                </div>
                                <span>Matériel pédagogique et équipements adaptés pour un apprentissage optimal.</span>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-check text-primary me-3"></i>
                                    <h6 class="mb-0">Personnel qualifié</h6>
                                </div>
                                <span>Des éducateurs formés à l'accompagnement des enfants à besoins spécifiques.</span>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-check text-primary me-3"></i>
                                    <h6 class="mb-0">Accès pour tous</h6>
                                </div>
                                <span>Une école ouverte à tous les enfants, sans discrimination.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row g-3">
                            <div class="col-12">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.1s" src="img/ecole-construction.jpg">
                            </div>
                            <div class="col-6">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.3s" src="img/ecole2.jpg">
                            </div>
                            <div class="col-6">
                                <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.5s" src="img/ecole3.jpg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- Features Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Nos Objectifs</h6>
                    <h1 class="mb-5">Pourquoi ce <span class="text-primary">Projet</span> ?</h1>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="room-item shadow rounded overflow-hidden">
                            <div class="position-relative">
                                <img class="img-fluid" src="img/img-ecole2.jpg" alt="">
                            </div>
                            <div class="p-4 mt-2">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-0">Éducation Inclusive</h5>
                                </div>
                                <p class="text-body mb-3">Offrir une éducation de qualité adaptée aux besoins spécifiques de chaque enfant, favorisant ainsi leur épanouissement intellectuel et social.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="room-item shadow rounded overflow-hidden">
                            <div class="position-relative">
                                <img class="img-fluid" src="img/img-ecole1.jpg" alt="">
                            </div>
                            <div class="p-4 mt-2">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-0">Insertion Sociale</h5>
                                </div>
                                <p class="text-body mb-3">Créer un environnement où les enfants peuvent interagir, se faire des amis et développer des compétences sociales essentielles.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="room-item shadow rounded overflow-hidden">
                            <div class="position-relative">
                                <img class="img-fluid" src="img/img-ecole3.jpg" alt="">
                            </div>
                            <div class="p-4 mt-2">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-0">Autonomie</h5>
                                </div>
                                <p class="text-body mb-3">Aider les enfants à acquérir les compétences nécessaires pour mener une vie aussi indépendante que possible.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Features End -->

        <!-- Gallery Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Galerie</h6>
                    <h1 class="mb-5">Avancement des <span class="text-primary">Travaux</span></h1>
                </div>
                <div class="gallery-grid wow fadeInUp" data-wow-delay="0.3s">
                    <div class="gallery-item" onclick="openModal('img/construction/construction1.jpeg', 'image')">
                        <img src="img/construction/construction1.jpeg" alt="Construction de l'école - Vue 1">
                        <div class="gallery-badge">Photo</div>
                        <div class="gallery-overlay">
                            <h3>Début des travaux</h3>
                            <p>Vue initiale du chantier de construction</p>
                        </div>
                    </div>
                    <div class="gallery-item" onclick="openModal('img/construction/construction2.jpeg', 'image')">
                        <img src="img/construction/construction2.jpeg" alt="Construction de l'école - Vue 2">
                        <div class="gallery-badge">Photo</div>
                        <div class="gallery-overlay">
                            <h3>Avancement</h3>
                            <p>Progression des fondations et structure</p>
                        </div>
                    </div>
                    <div class="gallery-item" onclick="openModal('img/construction/construction3.mp4', 'video')">
                        <video muted loop>
                            <source src="img/construction/construction3.mp4" type="video/mp4">
                            Votre navigateur ne supporte pas les vidéos HTML5.
                        </video>
                        <div class="gallery-badge">Vidéo</div>
                        <div class="gallery-video-controls">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="gallery-overlay">
                            <h3>Présentation du projet</h3>
                            <p>Découvrez le projet en vidéo</p>
                        </div>
                    </div>
                    <div class="gallery-item" onclick="openModal('img/construction/construction4.mp4', 'video')">
                        <video muted loop>
                            <source src="img/construction/construction4.mp4" type="video/mp4">
                            Votre navigateur ne supporte pas les vidéos HTML5.
                        </video>
                        <div class="gallery-badge">Vidéo</div>
                        <div class="gallery-video-controls">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="gallery-overlay">
                            <h3>Phase de construction</h3>
                            <p>Avancement des travaux sur le terrain</p>
                        </div>
                    </div>
                    <div class="gallery-item" onclick="openModal('img/construction/construction5.mp4', 'video')">
                        <video muted loop>
                            <source src="img/construction/construction5.mp4" type="video/mp4">
                            Votre navigateur ne supporte pas les vidéos HTML5.
                        </video>
                        <div class="gallery-badge">Vidéo</div>
                        <div class="gallery-video-controls">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="gallery-overlay">
                            <h3>Démonstration</h3>
                            <p>Visite guidée du chantier</p>
                        </div>
                    </div>
                    <div class="gallery-item" onclick="openModal('img/construction/construction6.jpeg', 'image')">
                        <img src="img/construction/construction6.jpeg" alt="Construction de l'école - Vue 6">
                        <div class="gallery-badge">Photo</div>
                        <div class="gallery-overlay">
                            <h3>Structure principale</h3>
                            <p>Élévation des murs et toiture</p>
                        </div>
                    </div>
                    <div class="gallery-item hidden" onclick="openModal('img/construction/construction7.jpeg', 'image')">
                        <img src="img/construction/construction7.jpeg" alt="Construction de l'école - Vue 7">
                        <div class="gallery-badge">Photo</div>
                        <div class="gallery-overlay">
                            <h3>Finitions</h3>
                            <p>Travaux de finition et aménagement</p>
                        </div>
                    </div>
                    <div class="gallery-item hidden" onclick="openModal('img/construction/construction8.mp4', 'video')">
                        <video muted loop>
                            <source src="img/construction/construction8.mp4" type="video/mp4">
                            Votre navigateur ne supporte pas les vidéos HTML5.
                        </video>
                        <div class="gallery-badge">Vidéo</div>
                        <div class="gallery-video-controls">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="gallery-overlay">
                            <h3>Phase finale</h3>
                            <p>Dernières étapes de la construction</p>
                        </div>
                    </div>
                    <div class="gallery-item hidden" onclick="openModal('img/construction/construction9.mp4', 'video')">
                        <video muted loop>
                            <source src="img/construction/construction9.mp4" type="video/mp4">
                            Votre navigateur ne supporte pas les vidéos HTML5.
                        </video>
                        <div class="gallery-badge">Vidéo</div>
                        <div class="gallery-video-controls">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="gallery-overlay">
                            <h3>Visite complète</h3>
                            <p>Tour complet du projet terminé</p>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5">
                    <button id="viewAllBtn" class="btn btn-primary py-3 px-5" onclick="toggleGallery()">
                        <i class="fas fa-images me-2"></i>
                        <span id="btnText">Voir tout</span>
                    </button>
                </div>
                
                <script>
                    function toggleGallery() {
                        var hiddenItems = document.querySelectorAll('.gallery-item.hidden');
                        var viewAllBtn = document.getElementById('viewAllBtn');
                        var btnText = document.getElementById('btnText');
                        
                        if (hiddenItems.length > 0) {
                            // Show all hidden items
                            hiddenItems.forEach(function(item) {
                                item.classList.remove('hidden');
                                item.classList.add('show');
                            });
                            btnText.textContent = 'Afficher moins';
                        } else {
                            // Hide items 7, 8, and 9 (index 6, 7, 8)
                            var galleryItems = document.querySelectorAll('.gallery-item');
                            if (galleryItems.length > 6) {
                                for (var i = 6; i < galleryItems.length; i++) {
                                    galleryItems[i].classList.add('hidden');
                                    galleryItems[i].classList.remove('show');
                                }
                            }
                            btnText.textContent = 'Voir tout';
                        }
                    }
                </script>
            </div>
        </div>
        <!-- Gallery End -->
        <!-- Gallery Modal -->
        <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="galleryModalLabel">Média de la Galerie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <div class="ratio ratio-16x9">
                            <div id="modalMedia"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-xxl py-5" id="document-projet">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <h1 class="display-6 mb-5">Téléchargez le Dossier Complet du Projet</h1>
                        <p class="mb-4">Découvrez en détail notre projet éducatif à travers le document complet qui présente nos objectifs, notre méthodologie, notre plan d'action et notre budget détaillé.</p>
                        <div class="bg-light p-4 rounded">
                            <h5 class="mb-3">Contenu du document :</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>Analyse des besoins éducatifs</li>
                                <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>Plans architecturaux détaillés</li>
                                <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>Programme pédagogique</li>
                                <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>Budget et financement</li>
                                <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>Calendrier de réalisation</li>
                                <li class="mb-0"><i class="fa fa-check text-primary me-2"></i>Impact social et éducatif</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="bg-light p-5 text-center" style="border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
                            <i class="fa fa-file-pdf fa-5x text-primary mb-4"></i>
                            <h3 class="mb-4">Dossier du Projet Éducatif</h3>
                            <p class="mb-4">Téléchargez le document complet de présentation de notre projet de construction d'école à Kinshasa.</p>
                            <a href="img/Projet construction winner.pdf" class="btn btn-primary py-3 px-5" download>
                                <i class="fa fa-download me-2"></i>Télécharger le PDF (5.2 Mo)
                            </a>
                            <p class="small text-muted mt-3">Format: PDF | Taille: 5.2 Mo | Dernière mise à jour: 10/01/2025</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Document Téléchargement End -->

        <!-- Call to Action -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="bg-primary rounded p-5">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-8">
                            <h2 class="text-white mb-0">Soutenez Notre Projet Éducatif</h2>
                            <p class="text-white mb-0">Votre contribution aidera à construire un avenir meilleur pour les enfants de Kinshasa.</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <a class="btn btn-light py-3 px-5" href="don.php">Faire un Don</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter Start -->
          <div class="container newsletter mt-5 wow fadeIn" data-wow-delay="0.1s" id="newsletter">
            <div class="row justify-content-center">
                <div class="col-lg-10 border rounded p-1">
                    <div class="border rounded text-center p-1">
                        <div class="bg-white rounded text-center p-5">
                            <?php
                            // Afficher les messages de confirmation/erreur pour la newsletter
                            if (isset($_SESSION['newsletter_message'])) {
                                $alertClass = (isset($_SESSION['newsletter_message_type']) && $_SESSION['newsletter_message_type'] === 'error') ? 'alert-danger' : 'alert-success';
                                echo '<div class="alert ' . $alertClass . ' alert-dismissible fade show mb-4" role="alert" style="max-width: 500px; margin: 0 auto;">';
                                echo htmlspecialchars($_SESSION['newsletter_message']);
                                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                                echo '</div>';
                                
                                // Nettoyer les données de session après affichage
                                unset($_SESSION['newsletter_message']);
                                unset($_SESSION['newsletter_message_type']);
                            }
                            ?>
                            <h4 class="mb-4">Abonnez-vous à notre <span class="text-primary text-uppercase">Newsletter</span></h4>
                            <form action="php/traitement.php" method="POST" class="d-flex justify-content-center">
                                <div class="position-relative" style="max-width: 400px; width: 100%;">
                                    <input type="email" class="form-control py-3 ps-4 pe-5" name="newsletter_email" placeholder="Votre adresse email" required>
                                    <button type="submit" class="btn btn-primary py-2 px-3 position-absolute top-0 end-0 mt-2 me-2">Soumettre</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Newsletter End -->
    

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer wow fadeIn" data-wow-delay="0.1s">
        <div class="container pb-5">
            <div class="row g-5">
                <div class="col-md-6 col-lg-4">
                    <div class="bg-primary rounded p-4">
                        <a href="index.html"><h1 class="text-white mb-3 footer-logo">Winner ASBL</h1></a>
                        <p class="text-white mb-0">
                            Association à but non lucratif dédiée à l'amélioration de la qualité de vie des enfants atteints d'hydrocéphalie et de spina-bifida. Ensemble, construisons un avenir meilleur pour ces enfants extraordinaires et leurs familles.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <h6 class="section-title text-start text-primary text-uppercase mb-4">Contact</h6>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>130,boulevard du 30juin; Immeuble flameaux,Kin, Gombe</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i> +243 838 244 225</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>infos@winnerasbl.org</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social me-2" href="https://www.facebook.com/profile.php?id=100093737370746"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social me-2" href="#"><i class="fab fa-tiktok"></i></a>
                        <a class="btn btn-outline-light btn-social me-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a class="btn btn-outline-light btn-social me-2" href="#"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="row gy-5 g-4">
                        <div class="col-md-6">
                            <h6 class="section-title text-start text-primary text-uppercase mb-4">Notre Association</h6>
                            <a class="btn btn-link" href="about.php">À propos de nous</a>
                            <a class="btn btn-link" href="contact.php">Contactez-nous</a>
                            <a class="btn btn-link" href="portfolio.php">Nos actions</a>
                            <a class="btn btn-link" href="#">Rapports annuels</a>
                            <a class="btn btn-link" href="contact.php">Devenir bénévole</a>
                        </div>
                        <div class="col-md-6">
                            <h6 class="section-title text-start text-primary text-uppercase mb-4">Nos Domaines</h6>
                            <a class="btn btn-link" href="service.php#soins-medicaux">Soins médicaux</a>
                            <a class="btn btn-link" href="service.php#accompagnement">Aide aux familles</a>
                            <a class="btn btn-link" href="service.php#sensibilisation">Sensibilisation</a>
                            <a class="btn btn-link" href="service.php#plaidoyer">Plaidoyer</a>
                            <a class="btn btn-link" href="don.php">Faire un don</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="index.html">Winner ASBL</a>, Tous droits réservés.
                        
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="index.html">Accueil</a>
                            <a href="#">Plan du site</a>
                            <a href="#">FAQ</a>
                            <a href="contact.php">Support</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

        <!-- Back to Top -->
     <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>




      
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    
    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    <!-- Gallery Modal Script -->
    <script>
        function openModal(src, type) {
            const modalMedia = document.getElementById('modalMedia');
            
            if (type === 'image') {
                modalMedia.innerHTML = `<img src="${src}" alt="Gallery Image" class="img-fluid">`;
            } else if (type === 'video') {
                modalMedia.innerHTML = `
                    <video controls autoplay class="embed-responsive-item">
                        <source src="${src}" type="video/mp4">
                        Votre navigateur ne supporte pas les vidéos HTML5.
                    </video>
                `;
            }
            
            // Use Bootstrap modal
            const modal = new bootstrap.Modal(document.getElementById('galleryModal'));
            modal.show();
        }
        
        // Add hover effect for video items
        document.addEventListener('DOMContentLoaded', function() {
            const videoItems = document.querySelectorAll('.gallery-item video');
            videoItems.forEach(video => {
                video.addEventListener('mouseenter', function() {
                    this.play();
                });
                video.addEventListener('mouseleave', function() {
                    this.pause();
                    this.currentTime = 0;
                });
            });
        });
    </script>
    
    </body>
    </html>