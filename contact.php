<?php
// Démarrer la session au tout début du fichier
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Contact - Winner ASBL</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/sensibilisation.jpg" rel="icon">

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
</head>

<body>
    <div class="container-xxl bg-white p-0">
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
                            <a href="don.php" class="btn btn-primary rounded-0 py-4 px-md-5 d-none d-lg-block">Faire un Don<i class="fa fa-arrow-right ms-3"></i></a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Header End -->

        <!-- Page Header Start -->
        <!-- Page Header Start -->
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url('img/contact.jpg');">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Contactez-nous</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Contact</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header End -->

        <!-- Contact Start -->
        <div class="container-xxl ">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Contactez-nous</h6>
                    <h1 class="mb-5">Restons en <span class="text-primary">Contact</span></h1>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="bg-light p-4 h-100">
                            <div class="d-flex align-items-center mb-4">
                                <div class="btn-lg-square bg-white rounded-circle p-3">
                                    <i class="fa fa-map-marker-alt text-primary"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">Adresse</h5>
                                    <p class="mb-0">130,Blvard du 30 juin Im Flambeaux,Kin,Gombe</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <div class="btn-lg-square bg-white rounded-circle p-3">
                                    <i class="fa fa-phone-alt text-primary"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">Téléphone</h5>
                                    <p class="mb-0">+243 811 897 218</p>
                                    <p class="mb-0">+243 980 142 602</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-4">
                                <div class="btn-lg-square bg-white rounded-circle p-3">
                                    <i class="fa fa-envelope text-primary"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">Email</h5>
                                    <p class="mb-0">infos@winnerasbl.org</p>
                                    <p class="mb-0">contact@winnerasbl.org</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="btn-lg-square bg-white rounded-circle p-3">
                                    <i class="fa fa-clock text-primary"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">Heures d'ouverture</h5>
                                    <p class="mb-0">De Lundi au vendredi</p>
                                    <p class="mb-0"> 8h30 - 16h00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-8 wow fadeInUp" data-wow-delay="0.3s">
   
                        <?php
                        // Afficher les messages de confirmation/erreur pour le formulaire de contact
                        if (isset($_SESSION['message'])) {
                            $alertClass = $_SESSION['message_type'] === 'error' ? 'alert-danger' : 'alert-success';
                            echo '<div class="alert ' . $alertClass . ' alert-dismissible fade show mb-4" role="alert">';
                            echo htmlspecialchars($_SESSION['message']);
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                            
                            // Nettoyer les données de session après affichage
                            unset($_SESSION['message']);
                            unset($_SESSION['message_type']);
                            unset($_SESSION['form_data']);
                        }
                        ?>
                        <form action="php/traitement.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="nom" placeholder="Votre Nom" required value="<?php echo isset($_SESSION['form_data']['nom']) ? htmlspecialchars($_SESSION['form_data']['nom']) : ''; ?>">
                                        <label for="name">Votre Nom</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Votre Email" required value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>">
                                        <label for="email">Votre Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="subject" name="sujet" placeholder="Sujet" required value="<?php echo isset($_SESSION['form_data']['sujet']) ? htmlspecialchars($_SESSION['form_data']['sujet']) : ''; ?>">
                                        <label for="subject">Sujet</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Laissez votre message ici" id="message" name="message" style="height: 200px" required><?php echo isset($_SESSION['form_data']['message']) ? htmlspecialchars($_SESSION['form_data']['message']) : ''; ?></textarea>
                                        <label for="message">Message</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit" name="envoyer">Envoyer le message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->

        <!-- Google Map -->
        <div class="container-xxl py-5">
            <div class="w-100">
                <iframe class="w-100" 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.805999999999!2d15.2874154!3d-4.3224476!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1a6a31a7b2f1f1d5%3A0x1c0b8c9b9e7b9b9e!2sAvenue%20de%20la%20Justice%2C%20Kinshasa%2C%20R%C3%A9publique%20d%C3%A9mocratique%20du%20Congo!5e0!3m2!1sfr!2sus!4v1640000000000!5m2!1sfr!2sus"
                    width="600" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
        <!-- Google Map End -->
         
                </div>
            </div>
        </div>
        <!-- Page Header End -->

   










        
      
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
                                <a href="contact.html">Support</a>
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
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>
