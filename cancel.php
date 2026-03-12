<?php
session_start();

// Log l'annulation si nécessaire
require_once 'log_payment_error.php';
logPaymentError("Payment Cancelled", [
    'timestamp' => date('Y-m-d H:i:s'),
    'user_agent' => $_SERVER['HTTP_USER_AGENT']
]);

// Rediriger vers la page de don avec un statut
header('Location: don.php?status=cancelled');
exit;
