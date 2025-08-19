<?php
session_start();

function logPaymentError($message, $data = []) {
    $logFile = __DIR__ . '/logs/payment_errors.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] {$message}\n";
    if (!empty($data)) {
        $logMessage .= "Data: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
    }
    $logMessage .= "----------------------------------------\n";
    
    if (!is_dir(__DIR__ . '/logs')) {
        mkdir(__DIR__ . '/logs', 0777, true);
    }
    
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

$input = json_decode(file_get_contents('php:input'), true);
if ($input) {
    logPaymentError("Client-side Payment Error", $input);
}

http_response_code(200);
?>
