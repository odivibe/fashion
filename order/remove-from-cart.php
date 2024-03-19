<?php
// Function to remove a product from the cart
function removeFromCart($productId) {
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}

// Example usage:
removeFromCart(1); // Remove product with ID 1 from the cart
