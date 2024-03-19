<?php
// Set the HTTP response status code to 401 Unauthorized
http_response_code(401);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Access - Your Fashion Store</title>
    <style>
        /* Your CSS styles for the error page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            text-align: center;
            padding: 50px;
        }
        h1 {
            font-size: 36px;
        }
    </style>
</head>
<body>
    <h1>Unauthorized Access</h1>
    <p>Sorry, you don't have permission to access this page.</p>
    <!-- You can provide a link to the login page or any other relevant page -->
    <p><a href="/login">Login</a></p>
</body>
</html>
