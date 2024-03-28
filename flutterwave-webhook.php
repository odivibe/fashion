<?php

// Webhook payload received from Flutterwave
$payload = file_get_contents("php://input");

// Decode JSON payload
$data = json_decode($payload, true);

// Check if the payload contains payment information
if (isset($data['data']) && isset($data['event']) && $data['event'] === 'charge.completed') {
    // Extract payment details
    $tx_ref = $data['data']['tx_ref'];
    $transaction_id = $data['data']['id'];
    $amount = $data['data']['amount'];
    $currency = $data['data']['currency'];

    // Define the path to the text file
    $file_path = 'payment_logs.txt';

    // Check if the text file exists, create it if not
    if (!file_exists($file_path)) {
        file_put_contents($file_path, '');
    }

    // Prepare payment details to be logged
    $log_message = "Transaction ID: $transaction_id | Amount: $amount $currency | TX_REF: $tx_ref\n";

    // Append payment details to the text file
    file_put_contents($file_path, $log_message, FILE_APPEND);

    // Respond with success status
    http_response_code(200);
    echo "Payment details logged successfully.";
} else {
    // Respond with error status
    http_response_code(400);
    echo "Invalid payload or event.";
}

?>

