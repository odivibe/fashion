<?php

// Check if user is not logged in, redirect to login page
/*if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}*/

// Assuming you have a PDO connection already established
require_once '../include/configs.php';
require_once '../include/sanitize-input.php';
require_once '../include/connection.php';
require_once '../include/unique-code-generator.php';
require_once '../include/error-log.php';
require_once '../include/image-resizer.php';

$product_name = $category_id = $price = $description = $quantity = 
$image_upload = $product_name_err = $category_id_err = $price_err = 
$description_err = $quantity_err = $image_upload_err = $success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" ) 
{






}

?>

