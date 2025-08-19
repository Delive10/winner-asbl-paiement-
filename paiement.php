<?php
session_start();

// Fonction de logging
function logPaymentError($message, $data = []) {
    $logFile = __DIR__ . '/logs/payment_errors.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] {$message}\n";
    if (!empty($data)) {
        $logMessage .= "Data: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
    }
    $logMessage .= "----------------------------------------\n";
    
    // Créer le dossier logs s'il n'existe pas
    if (!is_dir(__DIR__ . '/logs')) {
        mkdir(__DIR__ . '/logs', 0777, true); 
    }
    
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

function genRandomID($min = 2000000, $max = 8000000) {
    return rand($min, $max);
}

// Vérification que le montant a été posté
if (!isset($_POST['don_montant']) || !is_numeric($_POST['don_montant']) || $_POST['don_montant'] <= 0) {
    die("Montant invalide.");
}

$prenom = htmlspecialchars($_POST['prenom']);
$nom = htmlspecialchars($_POST['nom']);
$amount = number_format($_POST['don_montant'], 2, '.', '');
$orderid = genRandomID();
$merchant = "WINNERR";
$apipassword = "55c071e2c1322dad47f29708981439f5";
$currency = "USD";
$returnUrl = "https://winnerasbl.org"; // À adapter à ton domaine

$sessionEndpoint = "https://ap-gateway.mastercard.com/api/rest/version/59/merchant/$merchant/session";

// Création de la session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $sessionEndpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);    
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 2);

$data = array(
    "apiOperation" => "CREATE_CHECKOUT_SESSION",
    "interaction" => array (
        "operation" => "PURCHASE",
        "returnUrl" => $returnUrl
     ),
     "order" => array (
        "id" => $orderid,
        "amount" => $amount,
        "currency" => $currency,
     )
);

$jsonData = json_encode($data);

$headers = [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode("merchant.$merchant:$apipassword")
];
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

// Log de la requête
logPaymentError("Request to Mastercard API", [
    'endpoint' => $sessionEndpoint,
    'data' => $data,
    'headers' => $headers
]);

$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    logPaymentError("CURL Error", [
        'error' => curl_error($ch),
        'errno' => curl_errno($ch)
    ]);
    die("Erreur de connexion au serveur de paiement. Veuillez réessayer.");
}

$responseData = json_decode($result);

// Log de la réponse
logPaymentError("Mastercard API Response", [
    'httpCode' => $httpCode,
    'response' => $responseData
]);

if (!$responseData || !isset($responseData->session->id)) {
    logPaymentError("Invalid Response", [
        'rawResponse' => $result
    ]);
    die("Erreur lors de la création de la session de paiement. Veuillez réessayer.");
}

$sessionId = $responseData->session->id;
$sessionVersion = $responseData->session->version;

// Ajouter ces en-têtes AVANT toute sortie HTML
header('Content-Security-Policy: default-src * data: blob: filesystem: about: ws: wss: \'unsafe-inline\' \'unsafe-eval\' \'unsafe-dynamic\'; frame-src * data: blob: \'unsafe-inline\' \'unsafe-eval\'; frame-ancestors \'none\';');
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Confirmation de Paiement - Winner ASBL</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    
    <!-- Stylesheets -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    
    <style>
        .payment-details {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }
        .payment-detail-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        .amount-highlight {
            font-size: 2rem;
            color: #0d6efd;
            font-weight: 700;
            margin: 1.5rem 0;
            text-align: center;
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
                    <a href="../index.php" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                        <h1 class="m-0 text-primary header-logo">Winner ASBL</h1>
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
                        <a href="../index.php" class="navbar-brand d-block d-lg-none">
                            <h1 class="m-0 text-primary header-logo">Winner ASBL</h1>
                        </a>
                        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                            <div class="navbar-nav mr-auto py-0">
                                <a href="../index.php" class="nav-item nav-link">Accueil</a>
                                <a href="../about.php" class="nav-item nav-link">À Propos</a>
                                <a href="../service.php" class="nav-item nav-link">Services</a>
                                <a href="../portfolio.php" class="nav-item nav-link">Portfolio</a>
                                <a href="../blog.php" class="nav-item nav-link">Blog</a>
                                <a href="../contact.php" class="nav-item nav-link">Contact</a>
                            </div>
                            <a href="../don.php" class="btn btn-primary rounded-0 py-4 px-md-5 d-none d-lg-block">Faire un Don<i class="fa fa-arrow-right ms-3"></i></a>
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

        <!-- Payment Section -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="section-title text-center text-primary text-uppercase">Validation du Paiement</h6>
                    <h1 class="mb-5">Finalisez Votre <span class="text-primary">Don</span></h1>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="wow fadeInUp" data-wow-delay="0.2s">
                            <div class="bg-light rounded p-4">
                                <div class="payment-details">
                                    <div class="text-center mb-4">
                                        <i class="fa fa-heart text-primary" style="font-size: 4rem; margin-bottom: 1rem;"></i>
                                        <h3 class="mb-3">Merci <?php echo htmlspecialchars($prenom . ' ' . $nom); ?> pour votre générosité !</h3>
                                        <p class="mb-4">Vous êtes sur le point de faire un don sécurisé.</p>
                                    </div>
                                    
                                    <div class="amount-highlight">
                                        $<?php echo number_format($amount, 2, ',', ' '); ?> USD
                                    </div>

                                    <div class="alert alert-primary" role="alert">
                                        <i class="fa fa-lock me-2"></i> Votre paiement est sécurisé et crypté par Mastercard.
                                    </div>
                                    
                                    <div class="d-md-flex flex-column flex-md-row justify-content-between align-items-center mt-4 gap-3">
                                        <a href="don.php" class="btn btn-outline-secondary btn-lg w-100 w-md-auto mb-3 mb-md-0">
                                            <i class="fa fa-arrow-left me-2"></i>Retour
                                        </a>
                                        <button class="btn btn-primary btn-lg w-100 w-md-auto" onclick="Checkout.showPaymentPage();">
                                            Faire un don <i class="fa fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>

                                    <div class="text-center mt-4">
                                        <img src="img/paiement.png" alt="Méthodes de paiement" class="img-fluid" style="max-height: 30px;">
                                        <p class="small text-muted mt-2">Transaction sécurisée par Mastercard</p>
                                    </div>
                                </div>
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
    <script src="https://ap-gateway.mastercard.com/checkout/version/59/checkout.js" 
            data-error="errorCallback" data-cancel="cancelCallback"></script>
    
    <script type="text/javascript">
        function errorCallback(error) {
            console.error("Payment Error:", error);
            
            // Log l'erreur côté serveur
            fetch('log_payment_error.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    error: error,
                    sessionId: '<?php echo $sessionId; ?>',
                    orderId: '<?php echo $orderid; ?>'
                })
            });
            
            alert("Erreur de paiement : " + error.explanation);
            window.location = "<?php echo $returnUrl; ?>";
        }

        function cancelCallback(){
            alert("Paiement annulé.");
            window.location = "<?php echo $returnUrl; ?>";
        }

        Checkout.configure({
            session: { 
                id: '<?php echo $sessionId; ?>',
                version: '<?php echo $sessionVersion; ?>'
            },
            interaction: {
                merchant: {
                    name: 'Winner ASBL',
                    address: {
                        line1: 'Kinshasa',
                        line2: 'RDC'
                    }
                },
                displayControl: {
                    billingAddress: 'HIDE',
                    customerEmail: 'HIDE',
                    orderSummary: 'SHOW',
                    shipping: 'HIDE'
                },
                locale: 'fr_FR',
                theme: 'default'
            }
        });

        // Ajout des animations et spinner
        new WOW().init();
        
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
