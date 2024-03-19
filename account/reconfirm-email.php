<?php
/*
this file confirms user email after resend email button is clicke and user click on the link sent to his email
*/

$confirmationCode = $_GET['code'];
$timestamp = $_GET['timestamp'];

// Check if the confirmation code is valid
$stmt = $pdo->prepare('SELECT id, username, confirmation_code_timestamp FROM users WHERE confirmation_code = ?');
$stmt->execute([$confirmationCode]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Check if the link has expired (e.g., 24 hours validity)
    $expirationTime = 24 * 60 * 60; // 24 hours in seconds
    if (time() - $timestamp <= $expirationTime) {
        // Update user's confirmation status in the database
        $updateStmt = $pdo->prepare('UPDATE users SET confirmed = 1, confirmation_code = NULL WHERE id = ?');
        $updateStmt->execute([$user['id']]);
        
        echo 'Your registration is confirmed! You can now log in.';
    } else {
        echo 'The confirmation link has expired. Please request a new one.';
        // You might provide a link or button here to redirect users to the resend confirmation page
        // Example: echo '<a href="resend_confirmation.php">Resend Confirmation</a>';
    }
} else {
    echo 'Invalid confirmation code.';
}
?>
