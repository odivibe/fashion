<?php
// Set the HTTP response status code to 404 Not Found
http_response_code(404);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - Your Fashion Store</title>
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
    <h1>Oops! Page Not Found</h1>
    <p>We're sorry, the page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
    <!-- You can add a link to your homepage or other relevant pages -->
    <p><a href="/">Return to Homepage</a></p>
</body>
</html>
