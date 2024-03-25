<?php

require_once 'include/header.php';


// Database connection
$dsn = 'mysql:host=localhost;dbname=fashiondb';
$username = '';
$password = '';

try 
{
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) 
{
    die("Error: Could not connect. " . $e->getMessage());
}

// Fetch products
$stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 4");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="top-cover-image-wrapper">
    <img src="image/top-cover-image.webp" alt="Top Cover Image">
    <div class="image-overlay">
        <h2>Style Elevated</h2>
        <p>Trends Defined. Shop the Look Now!</p>
        <a href="#" class="shop-now-button">Shop Now</a>
    </div>
</div>

<div class="container">

    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
            <h2><?php echo $product['name']; ?></h2>
            <p><?php echo $product['description']; ?></p>
            <p>Price: $<?php echo $product['price']; ?></p>
        </div>
    <?php endforeach; ?>


    <!-- Your content here -->
    <pre> e
    body content goes here
    body content goes here body content goes here
    body content goes here
    body content goes here
    body content goes here
    body content goes here
    body content goes here body content goes here
    body content goes here
    body content goes here
    body content goes here
    body content goes here
    body content goes here body content goes here
    body content goes here
    body content goes here
    body content goes here
    body content goes here
    body content goes here body content goes here
    body content goes here
    body content goes here
    body content goes here
    body content goes here
    body content goes here body content goes here
    body content goes here
    body content goes here
    body content goes here
    body content goes here
    body content goes here
    </pre>
    

</div>


<?php require_once 'include/footer.php'; ?>