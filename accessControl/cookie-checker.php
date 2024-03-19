<?php
/*
This file checks if the "Remember Me" cookie exists.
*/

require_once '../include/configs.php';

// Check if the "Remember Me" cookie exists
if (isset($_COOKIE['remember_user'])) {
    list($user_id, $token) = explode(':', $_COOKIE['remember_user']);

    // Check the user's token and expiration time in the database
    $query = "SELECT * FROM users WHERE id = :id AND remember_token = :remember_token";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_STR);
    $stmt->bindParam(':remember_token', $token, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && time() <= $user['remember_expiration']) {
        // The token is valid and not expired, log in the user
        $_SESSION['user_id'] = $user_id;
        header("Location:".BASE_URL."/index.php");
        exit();
    } else {
        // Do this if the cookie has expired
        $empty_token = '';
        $empty_expiration = '';

        // The token is expired, update the database to remove the expired token
        $query = "UPDATE users SET remember_token = :remember_token, remember_expiration = :remember_expiration WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':remember_token', $empty_token, PDO::PARAM_STR);
        $stmt->bindParam(':remember_expiration', $empty_expiration, PDO::PARAM_STR);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_STR);
        $stmt->execute();

        // Log out the user
        header("Location:".BASE_URL."/account/logout.php");
        exit();
    }
} 
?>
