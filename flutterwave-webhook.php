<?php

// Retrieve the request body from Flutterwave
$request_body = file_get_contents('php://input');

// Verify that the request body is not empty
if(empty($request_body)) {
    http_response_code(400);
    exit("Invalid request: Empty payload");
}

// Parse the JSON payload sent by Flutterwave
$payload = json_decode($request_body, true);

// Verify that the payload is valid JSON
if(json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    exit("Invalid request: Invalid JSON payload");
}

// Extract relevant information from the payload
$event_type = $payload['event'];
$payment_data = $payload['data'];

// Handle different types of events
switch($event_type) {
    case 'payment.success':
        // Process successful payment
        handle_successful_payment($payment_data);
        break;
    case 'payment.failure':
        // Process failed payment
        handle_failed_payment($payment_data);
        break;
    // Add more cases for other event types as needed
    default:
        // Unknown event type
        http_response_code(400);
        exit("Unknown event type: $event_type");
}

// Function to handle successful payment
function handle_successful_payment($payment_data) {
    // Extract relevant payment details
    $tx_ref = $payment_data['tx_ref'];
    $transaction_id = $payment_data['id'];
    $amount = $payment_data['amount'];
    // Extract additional payment details as needed

    // Insert payment details into the database
    // Example: You can use PDO or MySQLi to perform database operations
    // $pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');
    // $stmt = $pdo->prepare("INSERT INTO payments (tx_ref, transaction_id, amount) VALUES (?, ?, ?)");
    // $stmt->execute([$tx_ref, $transaction_id, $amount]);

    // Send a response indicating successful processing
    http_response_code(200);
    exit("Payment processed successfully: Transaction ID $transaction_id");
}

// Function to handle failed payment
function handle_failed_payment($payment_data) {
    // Extract relevant payment details
    $tx_ref = $payment_data['tx_ref'];
    $transaction_id = $payment_data['id'];
    // Extract additional payment details as needed

    // Log the failed payment or perform any necessary actions
    // Example: You can log the payment details in a file or database

    // Send a response indicating successful processing
    http_response_code(200);
    exit("Payment failed: Transaction ID $transaction_id");
}

?>
