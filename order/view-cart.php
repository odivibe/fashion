<?php
// Function to display the contents of the cart
function viewCart() {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            // Fetch product details from the database using $productId
            echo "Product ID: $productId, Quantity: $quantity <br>";
        }
    } else {
        echo "Cart is empty";
    }
}

// Example usage:
viewCart();
