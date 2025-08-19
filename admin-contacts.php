<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login-admin.php");
    exit();
}

// Configuration de la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "winner-asbl";

try {
    // Connexion à la base de données
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
    
    // Récupérer les contacts
    $contacts_stmt = $conn->query("SELECT * FROM contact ORDER BY date_creation DESC");
    $contacts = $contacts_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Récupérer les abonnés à la newsletter
    $newsletter_stmt = $conn->query("SELECT * FROM newsletter ORDER BY date_inscription DESC");
    $subscribers = $newsletter_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Initialiser les variables comme tableaux vides
    $rendez_vous = [];
    $dons = [];
    
    // Vérifier si la table dons existe
    try {
        $tableExists = $conn->query("SHOW TABLES LIKE 'dons'")->rowCount() > 0;
        
        if ($tableExists) {
            // Vérifier si la table contient des colonnes
            $columns = $conn->query("SHOW COLUMNS FROM dons")->fetchAll(PDO::FETCH_COLUMN);
            error_log("Colonnes de la table dons: " . print_r($columns, true));
            
            // Récupérer les dons
            $dons_stmt = $conn->query("SELECT * FROM dons ORDER BY date_creation DESC");
            
            if ($dons_stmt !== false) {
                $dons = $dons_stmt->fetchAll(PDO::FETCH_ASSOC);
                error_log("Nombre de dons récupérés: " . count($dons));
            } else {
                $errorInfo = $conn->errorInfo();
                $errorMessage = "Erreur lors de la récupération des dons: " . ($errorInfo[2] ?? 'Erreur inconnue');
                error_log($errorMessage);
                $_SESSION['error'] = $errorMessage;
            }
        } else {
            $errorMessage = "La table 'dons' n'existe pas dans la base de données";
            error_log($errorMessage);
            $_SESSION['error'] = $errorMessage;
        }
    } catch (PDOException $e) {
        error_log("Erreur PDO lors de la récupération des dons: " . $e->getMessage());
    }
    
    // Vérifier si la table rendez_vous existe
    try {
        $tableExists = $conn->query("SHOW TABLES LIKE 'rendez_vous'")->rowCount() > 0;
        
        if ($tableExists) {
            // Récupérer les rendez-vous
            $rdv_stmt = $conn->query("SELECT * FROM rendez_vous ORDER BY date_rdv DESC, heure_rdv DESC");
            if ($rdv_stmt) {
                $rendez_vous = $rdv_stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                error_log("Erreur lors de la récupération des rendez-vous: " . implode(" ", $conn->errorInfo()));
            }
        } else {
            error_log("La table 'rendez_vous' n'existe pas dans la base de données");
        }
    } catch (PDOException $e) {
        error_log("Erreur PDO: " . $e->getMessage());
        $error = "Une erreur est survenue lors de la récupération des rendez-vous.";
    }
    
} catch(PDOException $e) {
    $error = "Erreur de connexion à la base de données: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des contacts - WINNER ASBL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            margin: 5px 0;
            border-radius: 5px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .main-content {
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
            font-weight: 600;
        }
        .message-preview {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 250px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="d-flex flex-column p-3">
                    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-4">WINNER ASBL</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="#contacts" class="nav-link active" data-bs-toggle="tab">
                                <i class="fas fa-envelope"></i>
                                Contacts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#newsletter" class="nav-link" data-bs-toggle="tab">
                                <i class="fas fa-envelope-open-text"></i>
                                Newsletter
                                <span class="badge bg-danger rounded-pill ms-1"><?php echo count($subscribers); ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#rendezvous" class="nav-link" data-bs-toggle="tab">
                                <i class="fas fa-calendar-check"></i>
                                Rendez-vous
                                <span class="badge bg-primary rounded-pill ms-1"><?php echo count($rendez_vous); ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#dons" class="nav-link" data-bs-toggle="tab">
                                <i class="fas fa-donate"></i>
                                Dons
                                <span class="badge bg-primary rounded-pill ms-1"><?php echo count($dons); ?></span>
                            </a>
                        </li>
                        <li class="mt-4">
                            <a href="logout.php" class="nav-link text-danger">
                                <i class="fas fa-sign-out-alt"></i>
                                Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-4 py-4">
                <h2 class="mb-4">Tableau de bord - Administration</h2>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?php 
                        echo htmlspecialchars($_SESSION['error']); 
                        unset($_SESSION['error']); // Supprimer le message après l'avoir affiché
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-subtitle mb-2 text-muted">Messages reçus</h6>
                                        <h2 class="mb-0"><?php echo count($contacts); ?></h2>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                        <i class="fas fa-envelope fa-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-subtitle mb-2 text-muted">Abonnés newsletter</h6>
                                        <h2 class="mb-0"><?php echo count($subscribers); ?></h2>
                                    </div>
                                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                                        <i class="fas fa-envelope-open-text fa-2x text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-subtitle mb-2 text-muted">Rendez-vous</h6>
                                        <h2 class="mb-0"><?php echo count($rendez_vous); ?></h2>
                                    </div>
                                    <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                                        <i class="fas fa-calendar-check fa-2x text-info"></i>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <?php 
                                        $en_attente = array_filter($rendez_vous, function($rdv) { 
                                            return isset($rdv['statut']) && $rdv['statut'] === 'en_attente'; 
                                        });
                                        echo count($en_attente) . ' en attente';
                                        ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-subtitle mb-2 text-muted">Dons reçus</h6>
                                        <h2 class="mb-0"><?php echo count($dons); ?></h2>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                                        <i class="fas fa-donate fa-2x text-warning"></i>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <?php 
                                        $total_dons = array_sum(array_column($dons, 'montant'));
                                        echo number_format($total_dons, 2, ',', ' ') . ' €';
                                        ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab content -->
                <div class="tab-content">
                    <!-- Contacts Tab -->
                    <div class="tab-pane fade show active" id="contacts">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Messages de contact</span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="contactsTable" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Nom</th>
                                                <th>Email</th>
                                                <th>Sujet</th>
                                                <th>Message</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($contacts as $contact): ?>
                                            <tr>
                                                <td><?php echo date('d/m/Y H:i', strtotime($contact['date_creation'])); ?></td>
                                                <td><?php echo htmlspecialchars($contact['nom']); ?></td>
                                                <td><a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>"><?php echo htmlspecialchars($contact['email']); ?></a></td>
                                                <td><?php echo htmlspecialchars($contact['sujet']); ?></td>
                                                <td class="message-preview" title="<?php echo htmlspecialchars($contact['message']); ?>">
                                                    <?php echo htmlspecialchars(substr($contact['message'], 0, 100) . (strlen($contact['message']) > 100 ? '...' : '')); ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info view-message" data-bs-toggle="modal" data-bs-target="#messageModal" 
                                                            data-message="<?php echo htmlspecialchars($contact['message']); ?>"
                                                            data-subject="<?php echo htmlspecialchars($contact['sujet']); ?>"
                                                            data-email="<?php echo htmlspecialchars($contact['email']); ?>">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <a href="mailto:<?php echo htmlspecialchars($contact['email']); ?>" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-reply"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Newsletter Tab -->
                    <div class="tab-pane fade" id="newsletter">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Abonnés à la newsletter</span>
                                <a href="export-newsletter.php" class="btn btn-sm btn-success">
                                    <i class="fas fa-download me-1"></i> Exporter en CSV
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="newsletterTable" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Email</th>
                                                <th>Date d'inscription</th>
                                                <th>Statut</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($subscribers as $subscriber): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($subscriber['email']); ?></td>
                                                <td><?php echo date('d/m/Y H:i', strtotime($subscriber['date_inscription'])); ?></td>
                                                <td>
                                                    <span class="badge bg-<?php echo $subscriber['actif'] ? 'success' : 'secondary'; ?>">
                                                        <?php echo $subscriber['actif'] ? 'Actif' : 'Inactif'; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dons Tab -->
                    <div class="tab-pane fade" id="dons">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Dons reçus</span>
                                <div>
                                    <button class="btn btn-sm btn-success" onclick="exportToExcel('donsTable', 'dons')">
                                        <i class="fas fa-download me-1"></i> Exporter en Excel
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="donsTable" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Donateur</th>
                                                <th>Email</th>
                                                <th>Montant</th>
                                                <th>Type</th>
                                                <th>Statut</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($dons)): ?>
                                                <?php foreach ($dons as $don): ?>
                                                    <tr>
                                                        <td><?php echo date('d/m/Y H:i', strtotime($don['date_creation'])); ?></td>
                                                        <td><?php echo htmlspecialchars($don['prenom'] . ' ' . $don['nom']); ?></td>
                                                        <td><?php echo htmlspecialchars($don['email']); ?></td>
                                                        <td><?php echo number_format($don['montant'], 2, ',', ' '); ?> €</td>
                                                        <td>
                                                            <?php if ($don['don_mensuel']): ?>
                                                                <span class="badge bg-primary">Mensuel</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-secondary">Ponctuel</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            $badgeClass = '';
                                                            switch(strtolower($don['statut'])) {
                                                                case 'en_attente':
                                                                    $badgeClass = 'bg-warning';
                                                                    break;
                                                                case 'confirme':
                                                                    $badgeClass = 'bg-success';
                                                                    break;
                                                                case 'annule':
                                                                    $badgeClass = 'bg-danger';
                                                                    break;
                                                                default:
                                                                    $badgeClass = 'bg-secondary';
                                                            }
                                                            ?>
                                                            <span class="badge <?php echo $badgeClass; ?>">
                                                                <?php echo ucfirst(str_replace('_', ' ', $don['statut'])); ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">Aucun don enregistré pour le moment</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Rendez-vous Tab -->
                    <div class="tab-pane fade" id="rendezvous">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Demandes de rendez-vous</span>
                                <div>
                                    <button class="btn btn-sm btn-outline-secondary me-2" onclick="exportToExcel('rdvTable', 'rendez_vous')">
                                        <i class="fas fa-file-excel"></i> Exporter
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="rdvTable" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Heure</th>
                                                <th>Nom</th>
                                                <th>Type</th>
                                                <th>Téléphone</th>
                                                <th>Email</th>
                                                <th>Statut</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($rendez_vous as $rdv): ?>
                                            <tr>
                                                <td><?php echo date('d/m/Y', strtotime($rdv['date_rdv'])); ?></td>
                                                <td><?php echo htmlspecialchars($rdv['heure_rdv']); ?></td>
                                                <td><?php echo htmlspecialchars($rdv['nom']); ?></td>
                                                <td><?php echo htmlspecialchars($rdv['type_rdv']); ?></td>
                                                <td><?php echo htmlspecialchars($rdv['telephone']); ?></td>
                                                <td><?php echo htmlspecialchars($rdv['email']); ?></td>
                                                <td>
                                                    <span class="badge 
                                                        <?php 
                                                        switch($rdv['statut']) {
                                                            case 'confirme':
                                                                echo 'bg-success';
                                                                break;
                                                            case 'annule':
                                                                echo 'bg-danger';
                                                                break;
                                                            default:
                                                                echo 'bg-warning text-dark';
                                                        }
                                                        ?>">
                                                        <?php 
                                                        switch($rdv['statut']) {
                                                            case 'en_attente':
                                                                echo 'En attente';
                                                                break;
                                                            case 'confirme':
                                                                echo 'Confirmé';
                                                                break;
                                                            case 'annule':
                                                                echo 'Annulé';
                                                                break;
                                                        }
                                                        ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-info text-white" onclick="viewRendezVous(<?php echo htmlspecialchars(json_encode($rdv)); ?>)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <a href="mailto:<?php echo htmlspecialchars($rdv['email']); ?>?subject=RE: Rendez-vous du <?php echo date('d/m/Y', strtotime($rdv['date_rdv'])); ?> à <?php echo htmlspecialchars($rdv['heure_rdv']); ?>" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-reply"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-success" onclick="updateStatus(<?php echo $rdv['id']; ?>, 'confirme')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" onclick="updateStatus(<?php echo $rdv['id']; ?>, 'annule')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Détails du message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <p><strong>De :</strong> <span id="modal-email"></span></p>
                    <p><strong>Sujet :</strong> <span id="modal-subject"></span></p>
                    <hr>
                    <div class="p-3 bg-light rounded">
                        <p id="modal-message" style="white-space: pre-wrap;"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <a href="#" id="modal-reply-btn" class="btn btn-primary">
                        <i class="fas fa-reply me-1"></i> Répondre
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialisation des DataTables
            $('#contactsTable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json'
                },
                order: [[0, 'desc']] // Trier par date décroissante par défaut
            });
            
            $('#newsletterTable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json'
                },
                order: [[1, 'desc']] // Trier par date d'inscription décroissante par défaut
            });

            // Gestion de l'affichage des messages dans la modale
            $('.view-message').on('click', function() {
                var message = $(this).data('message');
                var subject = $(this).data('subject');
                var email = $(this).data('email');
                
                $('#modal-email').text(email);
                $('#modal-subject').text(subject);
                $('#modal-message').text(message);
                $('#modal-reply-btn').attr('href', 'mailto:' + email + '?subject=RE: ' + encodeURIComponent(subject));
            });

            // Gestion des onglets pour conserver l'onglet actif après rechargement
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });

            // Récupérer l'onglet actif
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                $('a[href="' + activeTab + '"]').tab('show');
            }
        });
    </script>
</body>
</html>
