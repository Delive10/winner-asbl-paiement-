<?php
session_start();

// Récupération des paramètres de l'URL avec vérification
$orderId = isset($_GET['orderid']) ? htmlspecialchars($_GET['orderid']) : '';
$amount = isset($_GET['amount']) ? floatval($_GET['amount']) : 0;
$resultIndicator = isset($_GET['resultIndicator']) ? htmlspecialchars($_GET['resultIndicator']) : '';

// Log du montant reçu pour debug
error_log("Amount received: " . $amount);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Paiement Réussi - Winner ASBL</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Stylesheets -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    
    <style>
        .success-icon {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 1.5rem;
        }
        .success-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
            padding: 3rem;
            margin-top: 2rem;
        }
        .transaction-details {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin: 2rem 0;
        }
        .transaction-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #dee2e6;
        }
        .transaction-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Chargement...</span>
            </div>
        </div>

        <!-- Header Start -->
        <div class="container-fluid bg-dark px-0 fixed-top">
            <div class="row gx-0">
                <div class="col-lg-3 bg-dark d-none d-lg-block">
                    <a href="index.php" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
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
                                <a href="https://wa.me/243838244225" class="mb-0">+243 811 897 218</a>
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
                        <a href="index.php" class="navbar-brand d-block d-lg-none">
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

        <!-- Page Header Start -->
        <div class="container-fluid page-header mb-5 p-0" style="background-image: url('img/room-1.jpg');">
            <div class="container-fluid page-header-inner py-5">
                <div class="container text-center">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Confirmation de Paiement</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                            <li class="breadcrumb-item"><a href="don.php">Faire un Don</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Paiement</li>
                        </ol>
                    </nav>
                </div>
            </div> 
        </div>

        <!-- Success Section -->
        <div class="container-xxl py-5" style="margin-top: 6rem;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="success-card text-center wow fadeInUp" data-wow-delay="0.1s">
                            <i class="fas fa-check-circle success-icon"></i>
                            <h2 class="mb-4">Paiement Réussi !</h2>
                            <p class="lead mb-4">Merci pour votre généreux don. Votre soutien est précieux pour notre cause.</p>

                            <div class="transaction-details">
                                <div class="transaction-item">
                                    <span>Numéro de transaction</span>
                                    <strong><?php echo $orderId; ?></strong>
                                </div>
                                <div class="transaction-item">
                                    <span>Montant du don</span>
                                    <strong>$<?php echo number_format($amount, 2, ',', ' '); ?> USD</strong>
                                </div>
                                <div class="transaction-item">
                                    <span>Statut</span>
                                    <strong class="text-success">Confirmé</strong>
                                </div>
                            </div>

                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-envelope me-2"></i>
                                Un reçu détaillé a été envoyé à votre adresse email.
                            </div>

                            <div class="mt-4">
                                <a href="index.php" class="btn btn-primary btn-lg me-3">
                                    Retour à l'accueil
                                </a>
                                <a href="don.php" class="btn btn-outline-primary btn-lg">
                                    Faire un autre don
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    
    <script>
        // Initialize WOW.js
        new WOW().init();
        
        // Handle spinner
        window.addEventListener('load', function() {
            const spinner = document.getElementById('spinner');
            if (spinner) {
                spinner.classList.remove('show');
                setTimeout(() => {
                    spinner.style.display = 'none';
                }, 500);
            }
        });
    </script>
</body>
</html>