<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Configuration de la base de données
$servername = "localhost";
$username = "root"; // Utilisateur par défaut de Laragon
$password = ""; // Mot de passe par défaut de Laragon (vide)
$dbname = "winner-asbl";

// Fonction pour logger les erreurs dans la console
function logToConsole($data) {
    $output = $data;
    if (is_array($output) || is_object($output)) {
        $output = json_encode($output, JSON_PRETTY_PRINT);
    }
    echo "<script>console.log('PHP: " . addslashes($output) . "');</script>";
}

// Afficher les données POST reçues
logToConsole('Données POST reçues:');
logToConsole($_POST);

try {
    // Connexion à la base de données
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Traitement du formulaire de contact
    if (isset($_POST['envoyer']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['sujet']) && isset($_POST['message'])) {
        // Nettoyage des données
        $nom = trim(htmlspecialchars($_POST['nom']));
        $email = trim(htmlspecialchars($_POST['email']));
        $sujet = trim(htmlspecialchars($_POST['sujet']));
        $message = trim(htmlspecialchars($_POST['message']));
        
        // Validation des données
        if (empty($nom) || empty($email) || empty($sujet) || empty($message)) {
            $_SESSION['message'] = "Tous les champs sont obligatoires.";
            $_SESSION['message_type'] = "error";
            header("Location: ../contact.php#contact");
            exit();
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = "L'adresse email n'est pas valide.";
            $_SESSION['message_type'] = "error";
            header("Location: ../contact.php#contact");
            exit();
        }
        
        // Insertion dans la base de données
        $stmt = $conn->prepare("INSERT INTO contact (nom, email, sujet, message) VALUES (:nom, :email, :sujet, :message)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':sujet', $sujet);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
        
        // Envoi d'email (à configurer selon votre serveur)
        $to = "votre@email.com"; // Remplacez par votre adresse email
        $subject = "Nouveau message de contact: $sujet";
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        $email_body = "Vous avez reçu un nouveau message de contact :\n\n";
        $email_body .= "Nom: $nom\n";
        $email_body .= "Email: $email\n";
        $email_body .= "Sujet: $sujet\n";
        $email_body .= "Message:\n$message\n";
        
        mail($to, $subject, $email_body, $headers);
        
        // Message de succès
        $_SESSION['message'] = "Votre message a été envoyé avec succès. Nous vous répondrons dès que possible.";
        $_SESSION['message_type'] = "success";
        
        // Redirection avec un message de succès
        header("Location: ../contact.php#contact");
        exit();
    }
    
    // Traitement du formulaire de rendez-vous
    if (isset($_POST['submit_rdv']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // Nettoyage des données
        $nom = trim(htmlspecialchars($_POST['nom'] ?? ''));
        $email = trim(htmlspecialchars($_POST['email'] ?? ''));
        $telephone = trim(htmlspecialchars($_POST['telephone'] ?? ''));
        $type_rdv = trim(htmlspecialchars($_POST['type_rdv'] ?? ''));
        $date_rdv = trim(htmlspecialchars($_POST['date_rdv'] ?? ''));
        $heure_rdv = trim(htmlspecialchars($_POST['heure_rdv'] ?? ''));
        $message = isset($_POST['message']) ? trim(htmlspecialchars($_POST['message'])) : '';
        
        // Validation des données
        $errors = [];
        
        if (empty($nom) || strlen($nom) < 2) {
            $errors[] = "Le nom est requis et doit contenir au moins 2 caractères.";
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Veuillez entrer une adresse email valide.";
        }
        
        if (empty($telephone) || !preg_match('/^[0-9\s\-\(\)\+]{8,20}$/', $telephone)) {
            $errors[] = "Veuillez entrer un numéro de téléphone valide.";
        }
        
        if (empty($type_rdv)) {
            $errors[] = "Veuillez sélectionner un type de rendez-vous.";
        }
        
        $today = new DateTime();
        $selectedDate = new DateTime($date_rdv);
        if (empty($date_rdv) || $selectedDate < $today) {
            $errors[] = "Veuillez sélectionner une date valide (aujourd'hui ou ultérieure).";
        }
        
        if (empty($heure_rdv)) {
            $errors[] = "Veuillez sélectionner une heure de rendez-vous.";
        }
        
        // Vérifier si la date et l'heure sont déjà prises
        $stmt = $conn->prepare("SELECT id FROM rendez_vous WHERE date_rdv = :date_rdv AND heure_rdv = :heure_rdv AND statut != 'annule'");
        $stmt->bindParam(':date_rdv', $date_rdv);
        $stmt->bindParam(':heure_rdv', $heure_rdv);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $errors[] = "Désolé, ce créneau horaire est déjà réservé. Veuillez en choisir un autre.";
        }
        
        // Si pas d'erreurs, on enregistre en base de données
        if (empty($errors)) {
            try {
                $stmt = $conn->prepare("INSERT INTO rendez_vous (nom, email, telephone, type_rdv, date_rdv, heure_rdv, message, statut) 
                                     VALUES (:nom, :email, :telephone, :type_rdv, :date_rdv, :heure_rdv, :message, 'en_attente')");
                
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':telephone', $telephone);
                $stmt->bindParam(':type_rdv', $type_rdv);
                $stmt->bindParam(':date_rdv', $date_rdv);
                $stmt->bindParam(':heure_rdv', $heure_rdv);
                $stmt->bindParam(':message', $message);
                
                $stmt->execute();
                
                // Envoi d'email de confirmation
                $to = $email;
                $subject = "Confirmation de votre rendez-vous";
                $email_message = "Bonjour $nom,\n\n";
                $email_message .= "Nous avons bien reçu votre demande de rendez-vous pour le $date_rdv à $heure_rdv.\n";
                $email_message .= "Type de rendez-vous : $type_rdv\n";
                if (!empty($message)) {
                    $email_message .= "Message : $message\n\n";
                }
                $email_message .= "Statut : En attente de confirmation\n\n";
                $email_message .= "Nous vous contacterons bientôt pour confirmer votre rendez-vous.\n\n";
                $email_message .= "Cordialement,\nL'équipe WINNER ASBL";
                
                $headers = "From: no-reply@winnerasbl.org\r\n";
                $headers .= "Reply-To: contact@winnerasbl.org\r\n";
                $headers .= "X-Mailer: PHP/" . phpversion();
                
                @mail($to, $subject, $email_message, $headers);
                
                // Redirection avec message de succès
                $success_message = "Votre demande de rendez-vous a été enregistrée avec succès. Nous vous contacterons bientôt pour confirmation.";
                $redirect_url = "../index.php?rdv_status=success&message=" . urlencode($success_message);
                
                // Ajouter les champs du formulaire à l'URL pour préremplir le formulaire en cas d'erreur
                $form_fields = [
                    'nom' => $nom,
                    'email' => $email,
                    'telephone' => $telephone,
                    'type_rdv' => $type_rdv,
                    'date_rdv' => $date_rdv,
                    'heure_rdv' => $heure_rdv,
                    'message' => $message
                ];
                
                $redirect_url .= '&' . http_build_query($form_fields);
                
                header("Location: $redirect_url#booking");
                exit();
                
            } catch (PDOException $e) {
                $errors[] = "Une erreur est survenue lors de l'enregistrement de votre demande. Veuillez réessayer plus tard.";
                error_log("Erreur base de données: " . $e->getMessage());
            }
        }
        
        // S'il y a des erreurs, on redirige avec les messages d'erreur
        if (!empty($errors)) {
            $error_message = "Des erreurs ont été détectées :\n- " . implode("\n- ", $errors);
            $redirect_url = "../index.php?rdv_status=error&message=" . urlencode($error_message);
            
            // Ajouter les champs du formulaire à l'URL pour préremplir le formulaire
            $form_fields = [
                'nom' => $nom,
                'email' => $email,
                'telephone' => $telephone,
                'type_rdv' => $type_rdv,
                'date_rdv' => $date_rdv,
                'heure_rdv' => $heure_rdv,
                'message' => $message
            ];
            
            $redirect_url .= '&' . http_build_query($form_fields);
            
            header("Location: $redirect_url#booking");
            exit();
        }
    }
    

    
        // Traitement du formulaire de don
    if (isset($_POST['form_type']) && $_POST['form_type'] === 'donation' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // Nettoyage des données
        $prenom = trim(htmlspecialchars($_POST['prenom'] ?? ''));
        $nom = trim(htmlspecialchars($_POST['nom'] ?? ''));
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $telephone = trim(htmlspecialchars($_POST['telephone'] ?? ''));
        $adresse = trim(htmlspecialchars($_POST['adresse'] ?? ''));
        $ville = trim(htmlspecialchars($_POST['ville'] ?? ''));
        $code_postal = trim(htmlspecialchars($_POST['code_postal'] ?? ''));
        $message = trim(htmlspecialchars($_POST['message'] ?? ''));
        $don_mensuel = isset($_POST['don_mensuel']) ? 1 : 0;
        $newsletter = isset($_POST['newsletter']) ? 1 : 0;
        
        // Gestion du montant (boutons radio ou champ personnalisé)
        $montant = 0;
        if (!empty($_POST['montant_personnalise'])) {
            $montant = (float)$_POST['montant_personnalise'];
        } elseif (isset($_POST['montant'])) {
            $montant = (float)$_POST['montant'];
        }

        // Validation des champs obligatoires
        $errors = [];
        if (empty($prenom)) $errors[] = "Le prénom est obligatoire.";
        if (empty($nom)) $errors[] = "Le nom est obligatoire.";
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Une adresse email valide est obligatoire.";
        if ($montant <= 0) $errors[] = "Veuillez spécifier un montant valide pour votre don.";

        if (empty($errors)) {
            try {
                // Préparation de la requête d'insertion
                $stmt = $conn->prepare("INSERT INTO dons (
                    montant, nom, prenom, email, telephone, adresse, 
                    code_postal, ville, don_mensuel, newsletter, message, statut
                ) VALUES (
                    :montant, :nom, :prenom, :email, :telephone, :adresse, 
                    :code_postal, :ville, :don_mensuel, :newsletter, :message, 'en_attente'
                )");

                // Exécution de la requête avec les paramètres
                $stmt->execute([
                    ':montant' => $montant,
                    ':nom' => $nom,
                    ':prenom' => $prenom,
                    ':email' => $email,
                    ':telephone' => $telephone,
                    ':adresse' => $adresse,
                    ':code_postal' => $code_postal,
                    ':ville' => $ville,
                    ':don_mensuel' => $don_mensuel,
                    ':newsletter' => $newsletter,
                    ':message' => $message
                ]);

                // Récupération de l'ID du don inséré
                $don_id = $conn->lastInsertId();

                // Stocker un message de succès dans la session
                $_SESSION['success_message'] = "Merci pour votre don de {$montant} USD. Votre numéro de don est #{$don_id}.";
                
                // Redirection vers la page de confirmation
                header('Location: ../don.php?status=success');
                exit();

            } catch(PDOException $e) {
                $errorMessage = "Erreur lors de l'enregistrement du don: " . $e->getMessage();
                logToConsole($errorMessage);
                $_SESSION['error_message'] = "Une erreur est survenue lors du traitement de votre don. Veuillez réessayer.";
                header('Location: ../don.php?status=error');
                exit();
            }
        } else {
            // Stocker les erreurs et les données du formulaire dans la session
            $_SESSION['form_errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header('Location: ../don.php?status=error');
            exit();
        }
    }

    // Traitement de l'inscription à la newsletter
    if (isset($_POST['newsletter_email'])) {
        $email = trim(htmlspecialchars($_POST['newsletter_email']));
        
        // Validation de l'email
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['newsletter_message'] = "Veuillez entrer une adresse email valide.";
            $_SESSION['newsletter_message_type'] = "error";
            header("Location: ../contact.php#newsletter");
            exit();
        }
        
        // Vérifier si l'email existe déjà
        $stmt = $conn->prepare("SELECT id FROM newsletter WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            // Mettre à jour l'abonnement existant
            $stmt = $conn->prepare("UPDATE newsletter SET actif = 1, date_inscription = NOW() WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            $_SESSION['newsletter_message'] = "Votre adresse email est déjà enregistrée. Merci pour votre intérêt !";
        } else {
            // Nouvel abonnement
            $stmt = $conn->prepare("INSERT INTO newsletter (email) VALUES (:email)");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            $_SESSION['newsletter_message'] = "Merci pour votre inscription à notre newsletter !";
        }
        
        $_SESSION['newsletter_message_type'] = "success";
        
        // Redirection avec un message de succès
        header("Location: ../contact.php#newsletter");
        exit();
    }
    
} catch(PDOException $e) {
    // En cas d'erreur de base de données
    $errorMessage = "Erreur PDO: " . $e->getMessage() . " dans " . $e->getFile() . " à la ligne " . $e->getLine();
    logToConsole($errorMessage);
    
    $_SESSION['message'] = "Une erreur s'est produite lors de la connexion à la base de données. Veuillez réessayer plus tard.";
    $_SESSION['message_type'] = "error";
    
    // Afficher l'erreur complète pour le débogage (à supprimer en production)
    $_SESSION['debug_error'] = $errorMessage;
    
    header("Location: " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] . "#don" : "../don.php#don"));
    exit();
} catch(Exception $e) {
    // Pour les autres exceptions
    $errorMessage = "Erreur: " . $e->getMessage() . " dans " . $e->getFile() . " à la ligne " . $e->getLine();
    logToConsole($errorMessage);
    
    $_SESSION['message'] = "Une erreur s'est produite: " . $e->getMessage();
    $_SESSION['message_type'] = "error";
    
    // Afficher l'erreur complète pour le débogage (à supprimer en production)
    $_SESSION['debug_error'] = $errorMessage;
    
    header("Location: " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] . "#don" : "../don.php#don"));
    exit();
}
