<?php
function sign($params) {
    // Clé secrète pour la signature (à remplacer par votre vraie clé)
    $secretKey = "55c071e2c1322dad47f29708981439f5";
    
    // Trier les paramètres par ordre alphabétique
    ksort($params);
    
    // Créer la chaîne à signer
    $signData = '';
    foreach ($params as $key => $value) {
        $signData .= $key . '=' . $value;
    }
    
    // Générer la signature
    return hash_hmac('sha256', $signData, $secretKey);
}

// Fonction pour valider les données
function validateInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Fonction pour vérifier le montant
function validateAmount($amount) {
    return filter_var($amount, FILTER_VALIDATE_FLOAT) && $amount > 0;
}
?>
