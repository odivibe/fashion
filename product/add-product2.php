<?php
// Assuming you have a PDO connection already established
$title = 'Add product';
require_once '../include/configs.php';
require_once '../include/sanitize-input.php';
require_once '../include/connection.php';
require_once '../include/unique-code-generator.php';
require_once '../include/image-resizer.php';

// Fetch categories
$query = "SELECT * FROM categories";
$stmt = $conn->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = []; // Initialize an array to store validation errors

if (isset($_POST["submit_add_product"]) && $_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Validate and sanitize input
    /*$product_name = sanitizeInput($_POST["product_name"]);
    $category_id = intval($_POST["category"]);
    $price = floatval($_POST["price"]);
    $quantity = intval($_POST["quantity"]);
    $description = sanitizeInput($_POST["description"]);
    $productSKU = generateUniqueProductSKU($conn, 'products', 'product_sku_number', 10); //product sku
    $time_created = date('Y-m-d H:i:s');
    //$user_id = $_SESSION['user_id'];*/


    // Check for empty fields
    /*if (empty($product_name)) {
        $errors['product_name'] = "Product name is required";
    }
    if (empty($category_id)) {
        $errors['category'] = "Category is required";
    }
    if (empty($price)) {
        $errors['price'] = "Price is required";
    }
    if (empty($quantity)) {
        $errors['quantity'] = "Quantity is required";
    }
    if (empty($description)) {
        $errors['description'] = "Description is required";
    }
    if (empty($_FILES["product_image"]["name"])) {
        $errors['product_image'] = "Product image is required";
    }*/

    //echo $_FILES["product_image"]["name"][0];

    // File upload handling if there are no errors
    /*if (empty($errors)) 
    {
        $uploadedImages = [];

        foreach ($_FILES["product_image"]["name"] as $key => $originalName) 
        {
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $newName = $product_name . '-' . $category_id . '-' . uniqid() . '-' . time() . '.' . $extension;
            $targetFile = '../uploads/' . $newName;

            // Check file size (2MB limit)
            if ($_FILES["product_image"]["size"][$key] > 2 * 1024 * 1024) 
            {
                $errors['product_image'] = "File size exceeds the limit (2MB)";
                break;
            }

            // Check file type (allow only gif, png, jpeg, webp)
            $allowedTypes = ["gif", "png", "jpeg", "webp", "jpg"];
            if (!in_array(strtolower($extension), $allowedTypes)) 
            {
                $errors['product_image'] = "Invalid file type. Allowed types: gif, png, jpeg, webp, jpg";
                break;
            }

            // Resize image function
            resizeImage($_FILES["product_image"]["tmp_name"][$key], $targetFile, 300, 200);

            $uploadedImages[] = $targetFile;

            // Move the resized image to the target directory
            if (!move_uploaded_file($_FILES["product_image"]["tmp_name"][$key], $targetFile)) 
            {
                $errors['product_image'] = "Failed to move the uploaded file to the target directory.";
                break;
            }
        }

        // Insert product information into the products table
        $query = "INSERT INTO products SET product_name = :product_name, user_id = :user_id, product_description = :product_description, category_id = :category_id, product_price = :product_price, product_quantity = :product_quantity, time_created = :time_created, product_sku_number = :product_sku_number";
        $stmt = $conn->prepare($query);
        $stmt->bindparam(':product_name', $product_name, PDO::PARAM_STR);
        $stmt->bindparam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->bindparam(':product_description', $description, PDO::PARAM_STR);
        $stmt->bindparam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindparam(':product_price', $price, PDO::PARAM_STR);
        $stmt->bindparam(':product_quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindparam(':time_created', $time_created, PDO::PARAM_STR);
        $stmt->bindparam(':product_sku_number', $productSKU, PDO::PARAM_STR);
        $result = $stmt->execute();

        // Get the last inserted ID
        $product_id = $conn->lastInsertId();

        // Save the uploaded image paths in the database
        foreach ($uploadedImages as $image) 
        {
            $query = "INSERT INTO product_images SET product_id = :product_id, image_path = :image_path";
            $stmt = $conn->prepare($query);
            $stmt->bindparam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindparam(':image_path', $image, PDO::PARAM_STR);
            $stmt->execute();
        }

        // Respond with a success message
        echo "Upload successful";
    } 
    else 
    {
        // Respond with an error message if there are validation errors
        //http_response_code(400);
        echo json_encode($errors);
    }*/

    echo "working with ajax";
}

?>

<?php require_once '../include/header.php'; ?>

<div class="main-content">

    <div class="form-container">
        <div class="form-logo">
            <img src="<?php echo BASE_URL ?>/image/logo.jpeg" alt="Z Lifestyle Logo">
            <h2>Add Product</h2>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" id='add-product-form'>

            <div id="uploadedImages" class="uploaded-images"></div>

            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name">
                <?php if (!empty($errors['product_name'])): ?>
                    <p class="error"><?php echo $errors['product_name']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select id="category" name="category">
                    <option value="" >Select Category</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['category_id']; ?>">
                            <?php echo $category['category_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['category'])): ?>
                    <p class="error"><?php echo $errors['category']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price">
                <?php if (!empty($errors['price'])): ?>
                    <p class="error"><?php echo $errors['price']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity">
                <?php if (!empty($errors['quantity'])): ?>
                    <p class="error"><?php echo $errors['quantity']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" cols="50"></textarea>
                <?php if (!empty($errors['description'])): ?>
                    <p class="error"><?php echo $errors['description']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="product_image">Product Image:</label>
                <input type="file" id="product_image" name="product_image" multiple>
                <?php if (!empty($errors['product_image'])): ?>
                    <p class="error"><?php echo $errors['product_image']; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <input type="submit" name="submit_add_product" value="Add Product" id="submit-add-product">
            </div>

        </form>
    </div>

</div>

    <script>
        // Function to handle file input change
        /*document.getElementById('product_image').addEventListener('change', function () {
            const images = Array.from(this.files);
            displayImages(images);
        });

        // Function to display uploaded images with delete buttons
        function displayImages(images) 
        {
            const uploadedImagesDiv = document.getElementById('uploadedImages');
            uploadedImagesDiv.innerHTML = '';

            images.forEach((image, index) => {
                const imgContainer = document.createElement('div');
                imgContainer.className = 'uploaded-image-container';

                const imgElement = document.createElement('img');
                imgElement.src = URL.createObjectURL(image);
                imgElement.className = 'uploaded-image';

                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.className = 'delete-button';
                deleteButton.addEventListener('click', function () {
                    // Remove the image and associated elements
                    images.splice(index, 1);
                    displayImages(images);
                });

                imgContainer.appendChild(imgElement);
                imgContainer.appendChild(deleteButton);

                uploadedImagesDiv.appendChild(imgContainer);
            });
        }*/

        // Function to handle form submission with AJAX
        submitAddProduct = document.getElementById('submit-add-product');
        submitAddProduct.addEventListener('click', function (event) 
        {
            event.preventDefault();

            // Reset previous error messages
            //resetErrorMessages();

            //const formData = new FormData(this);

            // Add images to FormData manually
            /*const images = document.getElementById('product_image').files;
            for (let i = 0; i < images.length; i++) 
            {
                formData.append('product_image[]', images[i]);
            }*/

            // Perform AJAX request to handle form submission
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'add-product.php');
            //xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

            xhr.onreadystatechange = function () 
            {
                if (xhr.readyState == 4 && xhr.status == 200) 
                {
                    // After successful submission
                    alert(xhr.responseText);
                    //alert('Upload successful');
                } 
                else
                {
                    // Handle validation errors
                    //const errors = JSON.parse(xhr.responseText);
                    //displayErrorMessages(errors);
                    alert('error uploading');

                }
            };

            xhr.send('key');
        });

        // Function to reset previous error messages
        /*function resetErrorMessages() {
            const errorElements = document.querySelectorAll('.error');
            errorElements.forEach((errorElement) => {
                errorElement.textContent = '';
            });
        }

        // Function to display error messages
        function displayErrorMessages(errors) {
            for (const [field, message] of Object.entries(errors)) {
                const errorElement = document.getElementById(`error_${field}`);
                if (errorElement) {
                    errorElement.textContent = message;
                }
            }
        }*/
    </script>

<?php require_once '../include/footer.php'; ?>

