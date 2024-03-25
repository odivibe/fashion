<?php

// Define payment details
$amount = 11300;
$first_name = "Elvis";
$last_name = "Luke";
$email = "elvisway4u@gmail.com"; // Replace with customer's email

// Construct payment request
$request = [
    'tx_ref' => time(),
    'amount' => $amount,
    'currency' => 'NGN',
    'payment_options' => 'card',
    'redirect_url' => 'http://localhost/fashion/payment-response.php', // Replace with your success redirect URL
    'customer' => [
        'email' => $email,
        'name' => $first_name . ' ' . $last_name
    ],
    'meta' => [
        'price' => $amount
    ],
    'customizations' => [
        'title' => 'Paying for online course', // Customize payment title
        'description' => 'Level'
    ]
];

// Make API request to Flutterwave
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.flutterwave.com/v3/payments', // Flutterwave API endpoint
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($request),
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer FLWSECK_TEST-ae2690130f4085fdfe4fe300473d3c0f-X', // Replace with your actual secret key
        'Content-Type: application/json'
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

// Handle API response
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $res = json_decode($response);
    if ($res->status == 'success') {
        $link = $res->data->link;
        // Redirect user to payment link
        header('Location: ' . $link);
        exit; // Ensure script execution stops after redirection
    } else {
        echo 'Payment processing failed: ' . $res->message;
    }
}

?>
