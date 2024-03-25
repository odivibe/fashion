<?php

// Handle redirect from Flutterwave after payment
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['tx_ref'])) 
{
    // Retrieve transaction reference and other parameters sent by Flutterwave
    $tx_ref = $_GET['tx_ref'];
    $transaction_id = $_GET['transaction_id'];
    $status = $_GET['status'];
    // Additional parameters can be retrieved as needed

    // Process the payment response
    if ($status === 'successful') 
    {
        // Payment was successful, update your database or perform necessary actions
        echo "Payment successful. Transaction ID: $transaction_id";
        // Redirect or display a success message to the user
    } 
    else 
    {
        // Payment failed or was canceled
        echo "Payment failed or canceled.";
        // Redirect or display an appropriate message to the user
    }
} 
else 
{
    // Invalid request or direct access to this page
    echo "Invalid request.";
    // Redirect or display an error message to the user
}

?>
